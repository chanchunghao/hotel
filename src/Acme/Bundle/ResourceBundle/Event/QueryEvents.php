<?php

namespace Acme\Bundle\ResourceBundle\Event;

class QueryEvents
{
    /**
     * The ON_QUERY_BUILT event occurs after query built.
     *
     * This event allows you to access query builder.
     * The event listener method receives a Acme\Bundle\ResourceBundle\Event\QueryEventArgs instance.
     */
    const ON_QUERY_BUILT = 'acme.event.{0}.query_built';
}
