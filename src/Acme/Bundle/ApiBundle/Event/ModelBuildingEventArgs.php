<?php

namespace Acme\Bundle\ApiBundle\Event;

use Acme\Component\Resource\Model\DomainObjectInterface;
use Symfony\Component\EventDispatcher\Event;

class ModelBuildingEventArgs extends Event
{
    /**
     * @var DomainObjectInterface
     */
    protected $model;

    /**
     * RespondingEventArgs constructor.
     * @param DomainObjectInterface $model
     */
    public function __construct(DomainObjectInterface $model)
    {
        $this->model = $model;
    }

    /**
     * @return DomainObjectInterface
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param DomainObjectInterface $model
     * @return $this
     */
    public function setModel(DomainObjectInterface $model)
    {
        $this->model = $model;

        return $this;
    }
}
