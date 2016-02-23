<?php

namespace Acme\Bundle\ResourceBundle\Manager;

use BCC\AutoMapperBundle\Mapper\Mapper;
use Doctrine\ORM\EntityManagerInterface as OperatorInterface;
use Doctrine\ORM\QueryBuilder;
use Acme\Bundle\ResourceBundle\Event\BuildingEventArgs;
use Acme\Bundle\ResourceBundle\Event\CancelableEventArgs;
use Acme\Bundle\ResourceBundle\Event\LifecycleEventArgs;
use Acme\Bundle\ResourceBundle\Event\LifecycleEvents;
use Acme\Bundle\ResourceBundle\Event\QueryEventArgs;
use Acme\Bundle\ResourceBundle\Event\QueryEvents;
use Acme\Component\Common\Collection\Enumerable;
use Acme\Component\Common\Utility\Collection;
use Acme\Component\Common\Utility\Inflector;
use Acme\Component\Common\Utility\String;
use Acme\Component\Resource\Criteria\AbstractSearchCriteria;
use Acme\Component\Resource\Criteria\CriteriaFactoryInterface;
use Acme\Component\Resource\Manager\OperatingOptions;
use Acme\Component\Resource\Manager\PersistentOptions;
use Acme\Component\Resource\Manager\ValidatingOptions;
use Acme\Component\Resource\Model\DomainObjectInterface;
use Acme\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ValidatorInterface;

class ResourceManager implements ResourceManagerInterface
{
    /**
     * @var string
     */
    protected $entityClassName;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @var OperatorInterface
     */
    protected $operator;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var Mapper
     */
    protected $mapper;

    /**
     * @var CriteriaFactoryInterface
     */
    protected $criteriaFactory;

    /**
     * @param string $entityClassName
     * @param ValidatorInterface $validator
     * @param OperatorInterface $operator
     * @param RepositoryInterface $repository
     * @param CriteriaFactoryInterface $criteriaFactory
     */
    public function __construct(
        $entityClassName,
        $validator,
        OperatorInterface $operator,
        RepositoryInterface $repository,
        CriteriaFactoryInterface $criteriaFactory
    ) {
        $this->operator = $operator;
        $this->repository = $repository;
        $this->criteriaFactory = $criteriaFactory;
        $this->validator = $validator;
        $this->entityClassName = $entityClassName;
        $this->entityName = String::toSnakeCase(String::baseClass($entityClassName));
    }

    /**
     * @param EventDispatcherInterface $dispatcher
     * @return $this
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * @param Mapper $mapper
     * @return $this
     */
    public function setMapper(Mapper $mapper)
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function newInstance(array $params = [])
    {
        return $this->build($params, false);
    }

    /**
     * {@inheritdoc}
     */
    public function create($params, $options = null)
    {
        $options = $options ?: new PersistentOptions();
        if (empty($options->getValidatingOptions()->getGroups())) {
            $options->getValidatingOptions()->setGroups(['create']);
        }
        $eventEnabled = $this->dispatcher && $options->getEventEnabled();
        $entity = is_array($params) ? $this->build($params, $eventEnabled) : $params;

        if (!$eventEnabled || $this->dispatchLifecycleEvent(LifecycleEvents::ON_CREATING, $entity, true)) {
            $this->save($entity, $options);

            if ($eventEnabled) {
                $this->dispatchLifecycleEvent(LifecycleEvents::ON_CREATED, $entity);
            }
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function update($params, $options = null)
    {
        $options = $options ?: new PersistentOptions();
        if (empty($options->getValidatingOptions()->getGroups())) {
            $options->getValidatingOptions()->setGroups(['update']);
        }
        $eventEnabled = $this->dispatcher && $options->getEventEnabled();
        $entity = is_array($params) ? $this->build($params, $eventEnabled) : $params;

        if (!$eventEnabled || $this->dispatchLifecycleEvent(LifecycleEvents::ON_UPDATING, $entity, true)) {
            $this->save($entity, $options);

            if ($eventEnabled) {
                $this->dispatchLifecycleEvent(LifecycleEvents::ON_UPDATED, $entity);
            }
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($params, $options = null)
    {
        $entity = $params instanceof DomainObjectInterface ?
            $params :
            $this->operator->getReference($this->entityClassName, $params);
        $options = $options ?: new OperatingOptions();
        $eventEnabled = $this->dispatcher && $options->getEventEnabled();

        if (!$eventEnabled || $this->dispatchLifecycleEvent(LifecycleEvents::ON_DELETING, $entity, true)) {
            $this->operator->remove($entity);

            if ($options->getFlush()) {
                $this->operator->flush();
            }

            if ($eventEnabled) {
                $this->dispatchLifecycleEvent(LifecycleEvents::ON_DELETED, $entity);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validate($params, array &$errors = [], $options = null)
    {
        $entity = is_array($params) ? $this->build($params) : $params;
        $options = $options ?: new ValidatingOptions();
        $errorsList = $this->validator->validate(
            $entity,
            $options->getGroups(),
            $options->getTraverse(),
            $options->getDeep()
        );

        $keySelector = function (ConstraintViolationInterface $error) {
            return $error->getPropertyPath();
        };
        $valueSelector = function (ConstraintViolationInterface $error) {
            return $error->getMessage();
        };

        $errors = Enumerable::from($errorsList)->toDictionary($keySelector, $valueSelector);

        return 0 === count($errors);
    }

    /**
     * {@inheritdoc}
     */
    public function get($filters, array $sorters = [])
    {
        $entity = null;

        if (is_array($filters)) {
            $criteria = $this->getSearchCriteria('', $filters, $sorters);
            $qb = $this->repository->getBy($criteria->getFilters(), $criteria->getSorters());
            $this->dispatchQueryBuiltEvent($qb);
            $entity = $qb->getQuery()->getOneOrNullResult();
        } else {
            $entity = $this->repository->find($filters);
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(array $sorters = [])
    {
        $qb = $this->repository->getAll($this->getSearchCriteria('', [], $sorters)->getSorters());
        $this->dispatchQueryBuiltEvent($qb);

        return $this->repository->createPaginator($qb);
    }

    /**
     * {@inheritdoc}
     */
    public function getBy(array $filters, array $sorters = [])
    {
        $criteria = $this->getSearchCriteria('', $filters, $sorters);
        $qb = $this->repository->getBy($criteria->getFilters(), $criteria->getSorters());
        $this->dispatchQueryBuiltEvent($qb);

        return $this->repository->createPaginator($qb);
    }

    /**
     * {@inheritdoc}
     */
    public function search($keyword, array $filters = [], array $sorters = [])
    {
        $criteria = $this->getSearchCriteria($keyword, $filters, $sorters);
        $qb = $this->repository->search(
            $criteria->getKeyword(),
            $criteria->getAllSearchKeys(),
            $criteria->getFilters(),
            $criteria->getSorters()
        );
        $this->dispatchQueryBuiltEvent($qb);

        return $this->repository->createPaginator($qb);
    }

    /**
     * {@inheritdoc}
     */
    public function build(array $params, $event = false)
    {
        /** @var DomainObjectInterface $obj */
        $obj = Collection::getValue('id', $params) ?
            $this->repository->find($params['id']) :
            new $this->entityClassName();

        if ($this->dispatcher && $event) {
            $this->dispatchBuildingEvent(LifecycleEvents::ON_BUILDING, $obj, $params);
        }

        if ($this->mapper) {
            $obj = $this->mapper->map($params, $obj);
        } else {
            foreach ($params as $key => $value) {
                $property = Inflector::classify($key);
                $setter = 'set' . $property;
                if (is_callable(array($obj, $setter))) {
                    $obj->$setter($value);
                }
            }
        }

        if ($this->dispatcher && $event) {
            $this->dispatchBuildingEvent(LifecycleEvents::ON_BUILT, $obj, $params);
        }

        return $obj;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClassName()
    {
        return $this->entityClassName;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * @param $entity
     * @param PersistentOptions $options
     */
    protected function save($entity, $options = null)
    {
        $options = $options ?: new PersistentOptions();
        $isValid = true;
        $errors = [];

        if ($options->getValidate()) {
            $isValid = $this->validate($entity, $errors, $options->getValidatingOptions());
        }

        if ($isValid) {
            $this->operator->persist($entity);

            if ($options->getFlush()) {
                $this->operator->flush();
            }
        } else {
            throw new \InvalidArgumentException("Entity is invalid. Errors: $errors");
        }
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
     * @param string $keyword
     * @param array $filters
     * @param array $sorts
     * @return AbstractSearchCriteria
     */
    protected function getSearchCriteria($keyword, array $filters, array $sorts = [])
    {
        $criteria = $this->criteriaFactory->get($this->entityClassName);
        $criteria->setKeyword($keyword)->setFilters($filters)->setSorters($sorts);

        return $criteria;
    }

    /**
     * @param string $event
     * @param DomainObjectInterface $obj
     * @param array $params
     */
    private function dispatchBuildingEvent($event, $obj, array $params)
    {
        $eventArgs = new BuildingEventArgs($obj, $params);
        $this->dispatcher->dispatch($this->getEventName($event, 'all'), $eventArgs);
        $this->dispatcher->dispatch($this->getEventName($event, $this->entityName), $eventArgs);
    }

    /**
     * @param string $event
     * @param DomainObjectInterface $entity
     * @param bool $cancelable
     * @return bool action should be continue.
     */
    private function dispatchLifecycleEvent($event, $entity, $cancelable = false)
    {
        $eventArgs = $cancelable ? new CancelableEventArgs($entity) : new LifecycleEventArgs($entity);
        $this->dispatcher->dispatch($this->getEventName($event, 'all'), $eventArgs);

        if (!$cancelable || !$eventArgs->isCancel()) {
            $this->dispatcher->dispatch($this->getEventName($event, $this->entityName), $eventArgs);

            return !$cancelable || !$eventArgs->isCancel();
        }

        return false === $cancelable;
    }

    /**
     * @param QueryBuilder $qb
     */
    private function dispatchQueryBuiltEvent(QueryBuilder $qb)
    {
        $eventArgs = new QueryEventArgs($qb);
        $this->dispatcher->dispatch($this->getEventName(QueryEvents::ON_QUERY_BUILT, 'all'), $eventArgs);
        $this->dispatcher->dispatch($this->getEventName(QueryEvents::ON_QUERY_BUILT, $this->entityName), $eventArgs);
    }
}
