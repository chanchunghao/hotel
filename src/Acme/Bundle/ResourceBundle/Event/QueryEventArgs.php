<?php

namespace Acme\Bundle\ResourceBundle\Event;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\EventDispatcher\Event;

class QueryEventArgs extends Event
{
    /**
     * @var QueryBuilder
     */
    protected $qb;

    public function __construct(QueryBuilder $qb)
    {
        $this->qb = $qb;
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->qb;
    }
}
