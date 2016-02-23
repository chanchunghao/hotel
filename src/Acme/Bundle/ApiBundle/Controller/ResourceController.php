<?php

namespace Acme\Bundle\ApiBundle\Controller;

use BCC\AutoMapperBundle\Mapper\Mapper;
use Doctrine\ORM\EntityNotFoundException;
use Acme\Bundle\ApiBundle\Event\ModelBuildingEventArgs;
use Acme\Bundle\ApiBundle\Event\RespondingEventArgs;
use Acme\Bundle\ApiBundle\Event\RespondingEvents;
use Acme\Bundle\ResourceBundle\Manager\ResourceManagerInterface;
use Acme\Bundle\ApiBundle\Request\RequestHandlerInterface;
use Acme\Bundle\ApiBundle\Response\ResponseDataFactory;
use Acme\Bundle\ApiBundle\Response\ResponseDataFactoryInterface;
use Acme\Component\Common\Collection\Enumerable;
use Acme\Component\Common\Utility\String;
use Acme\Component\Resource\Model\DomainObjectInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 */
abstract class ResourceController extends FOSRestController
{
    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $paginator = $this->getManager()->search(
            $this->getKeyword($request),
            $this->getFilters($request),
            $this->getSorters($request)
        );
        $paginator
            ->setPageIndex($this->getPageIndex($request))
            ->setPageSize($this->getPageSize($request));
        $data = $this->getResponseDataFactory()->getPaginationData($paginator);
        $data = $this->handleResponseData($data);

        return $data;
    }

    /**
     * @Rest\View
     * @param $id
     * @return array
     */
    public function showAction($id)
    {
        $entity = $this->getManager()->get($id);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        $data = $this->getResponseDataFactory()->get($entity);
        $data = $this->handleResponseData($data);

        return $data;
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function createAction(Request $request)
    {
        $params = $request->get('data', null);
        $errors = [];

        if (false === $this->getManager()->validate($params, $errors)) {
            return $this->createInvalidParameterResponse($errors);
        }

        $entity = $this->getManager()->create($params);
        $data = $this->getResponseDataFactory()->get($entity);
        $data = $this->handleResponseData($data);

        return $this->view($data, 201);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @param $id
     * @return array
     */
    public function updateAction(Request $request, $id)
    {
        $params = $request->get('data', null);
        $params['id'] = $id;

        $errors = [];

        if (false === $this->getManager()->validate($params, $errors)) {
            return $this->createInvalidParameterResponse($errors);
        }

        try {
            $entity = $this->getManager()->update($params);
            $data = $this->getResponseDataFactory()->get($entity);
            $data = $this->handleResponseData($data);

            return $data;
        } catch (EntityNotFoundException $ex) {
            return $this->view(null, 204);
        }
    }

    /**
     * @Rest\View
     * @param $id
     * @return array
     */
    public function deleteAction($id)
    {
        $this->getManager()->delete($id);

        return $this->getResponseDataFactory()->get(null);
    }

    /**
     * @param array $errors
     * @param int $statusCode
     * @return array
     */
    public function createInvalidParameterResponse(array $errors = null, $statusCode = 400)
    {
        $data = $this
            ->getResponseDataFactory()
            ->getErrorData('', ResponseDataFactory::STATUS_FAIL, $statusCode, $errors);

        return $this->view($data, $statusCode);
    }

    /**
     * @return ResourceManagerInterface
     */
    abstract protected function getManager();

    /**
     * @return string
     */
    protected function getModelClassName()
    {
        return $this->getManager()->getEntityClassName();
    }

    /**
     * @return EventDispatcherInterface
     */
    protected function getDispatcher()
    {
        return $this->get('event_dispatcher');
    }

    /**
     * @return RequestHandlerInterface
     */
    protected function getRequestHandler()
    {
        return $this->get('acme.handler.request');
    }

    /**
     * @return ResponseDataFactoryInterface
     */
    protected function getResponseDataFactory()
    {
        return $this->get('acme.factory.response_data');
    }

    /**
     * @return Mapper
     */
    protected function getMapper()
    {
        return $this->get('bcc_auto_mapper.mapper');
    }

    /**
     * Get event name.
     *
     * @param $event
     * @param $entityName
     * @return string
     */
    protected function getEventName($event, $entityName)
    {
        return String::format($event, $entityName);
    }

    /**
     * @param $data
     * @return array
     */
    protected function dispatchRespondingEvent($data)
    {
        $eventArgs = new RespondingEventArgs($data);
        $dispatcher = $this->getDispatcher();
        $entityName = $this->getManager()->getEntityName();

        $dispatcher->dispatch($this->getEventName(RespondingEvents::ON_RESPONDING, 'all'), $eventArgs);
        $dispatcher->dispatch($this->getEventName(RespondingEvents::ON_RESPONDING, $entityName), $eventArgs);

        return $eventArgs->getResponse();
    }

    /**
     * @param DomainObjectInterface $model
     * @return DomainObjectInterface
     */
    protected function dispatchModelBuiltEvent(DomainObjectInterface $model)
    {
        $eventArgs = new ModelBuildingEventArgs($model);
        $dispatcher = $this->getDispatcher();
        $entityName = $this->getManager()->getEntityName();

        $dispatcher->dispatch($this->getEventName(RespondingEvents::ON_MODEL_BUILT, 'all'), $eventArgs);
        $dispatcher->dispatch($this->getEventName(RespondingEvents::ON_MODEL_BUILT, $entityName), $eventArgs);

        return $eventArgs->getModel();
    }

    /**
     * @param $data
     * @return array
     */
    protected function handleResponseData($data)
    {
        if ($data && $data['data']) {
            if (is_array($data['data'])) {
                $selector = function ($entity) {
                    $model = $this->buildModel($entity);
                    $model = $this->dispatchModelBuiltEvent($model);

                    return $model;
                };
                $data['data']['results'] = Enumerable::from($data['data']['results'])->select($selector)->toArray();
            } else {
                $model = $this->buildModel($data['data']);
                $model = $this->dispatchModelBuiltEvent($model);
                $data['data'] = $model;
            }
        }

        $data = $this->dispatchRespondingEvent($data);

        return $data;
    }

    /**
     * @param $entity
     * @return DomainObjectInterface
     */
    protected function buildModel($entity)
    {
        if ($this->getManager()->getEntityClassName() == $this->getModelClassName()) {
            return $entity;
        }

        $className = $this->getModelClassName();
        $model = new $className();

        return $this->getMapper()->map($entity, $model);
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function getKeyword(Request $request)
    {
        return $this->getRequestHandler()->getKeyword($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getFilters(Request $request)
    {
        return $this->getRequestHandler()->getFilters($request, $this->getManager()->getEntityClassName());
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getSorters(Request $request)
    {
        return $this->getRequestHandler()->getSorters($request, $this->getManager()->getEntityClassName());
    }

    /**
     * @param Request $request
     * @return int
     */
    protected function getPageSize(Request $request)
    {
        return $this->getRequestHandler()->getPageSize($request);
    }

    /**
     * @param Request $request
     * @return int
     */
    protected function getPageIndex(Request $request)
    {
        return $this->getRequestHandler()->getPageIndex($request);
    }
}
