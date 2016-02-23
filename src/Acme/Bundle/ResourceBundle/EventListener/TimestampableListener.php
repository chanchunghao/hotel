<?php

namespace Acme\Bundle\ResourceBundle\EventListener;

use Acme\Bundle\ResourceBundle\Event\LifecycleEventArgs;
use Acme\Component\Resource\Model\TimestampableInterface;

class TimestampableListener
{
    /**
     * @param LifecycleEventArgs $args
     */
    public function onCreating(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof TimestampableInterface) {
            $now = new \DateTime();
            $entity->setCreatedAt($now);
            $entity->setUpdatedAt($now);
        }
    }
}
