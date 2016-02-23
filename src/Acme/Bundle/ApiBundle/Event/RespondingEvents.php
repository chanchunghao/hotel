<?php

namespace Acme\Bundle\ApiBundle\Event;

class RespondingEvents
{
    /**
     * The ON_RESPONDING event occurs before respond.
     *
     * This event allows you to access response.
     * The event listener method receives a Acme\Bundle\ApiBundle\Event\RespondingEventArgs instance.
     */
    const ON_RESPONDING = 'acme.event.{0}.responding';

    /**
     * The ON_MODEL_BUILDING event occurs before respond.
     *
     * This event allows you to access model.
     * The event listener method receives a Acme\Bundle\ApiBundle\Event\ModelBuildingEventArgs instance.
     */
    const ON_MODEL_BUILT = 'acme.event.{0}.model_built';
}
