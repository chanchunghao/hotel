<?php

namespace Acme\Bundle\HotelBundle\Controller;

use Acme\Bundle\ApiBundle\Controller\ResourceController;
use Acme\Component\Hotel\Service\OfferBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class OfferController extends ResourceController
{
    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function createAction(Request $request)
    {
        $date = \DateTime::createFromFormat('d/m/Y', $request->get('date'));
        $offer = $this->getBuilder()->setCheckInDate($date)->build();

        $errors = [];

        if (false === $this->getManager()->validate($offer, $errors)) {
            return $this->createInvalidParameterResponse($errors);
        }

        $entity = $this->getManager()->create($offer);
        $data = $this->getResponseDataFactory()->get($entity);
        $data = $this->handleResponseData($data);

        return $this->view($data, 201);
    }

    /**
     * {@inheritdoc}
     */
    protected function getManager()
    {
        return $this->get('acme.manager.offer');
    }

    /**
     * @return OfferBuilderInterface
     */
    protected function getBuilder()
    {
        return $this->get('acme.builder.offer');
    }
}
