<?php

namespace Acme\Bundle\ResourceBundle\EventListener;

use Acme\Bundle\ResourceBundle\Event\QueryEventArgs;
use Acme\Component\Resource\Model\SortableInterface;

class SortableListener
{
    public function onQueryBuilt(QueryEventArgs $args)
    {
        $qb = $args->getQueryBuilder();
        $class = new \ReflectionClass($qb->getRootEntities()[0]);
        if ($class->implementsInterface(SortableInterface::class)) {
            $alias = $qb->getRootAliases()[0];
            $qb->addOrderBy($alias . '.position', 'ASC');
        }
    }
}
