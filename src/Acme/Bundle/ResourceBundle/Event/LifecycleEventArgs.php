<?php

namespace Acme\Bundle\ResourceBundle\Event;

use Acme\Component\Resource\Model\DomainObjectInterface;
use Symfony\Component\EventDispatcher\Event;

class LifecycleEventArgs extends Event
{
    /**
     * @var DomainObjectInterface
     */
    protected $entity;

    public function __construct(DomainObjectInterface $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return DomainObjectInterface
     */
    public function getEntity()
    {
        return $this->entity;
    }
}
