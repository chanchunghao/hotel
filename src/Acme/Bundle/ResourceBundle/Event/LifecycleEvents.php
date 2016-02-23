<?php

namespace Acme\Bundle\ResourceBundle\Event;

class LifecycleEvents
{
    /**
     * The ON_BUILDING event occurs before the entity is built.
     *
     * This event allows you to modify the values of the entity before build.
     * The event listener method receives a Acme\Bundle\ResourceBundle\Event\BuildingEventArgs instance.
     */
    const ON_BUILDING = 'acme.event.{0}.building';

    /**
     * The ON_BUILT event occurs after the entity is built.
     *
     * This event allows you to access the entity which will be built.
     * The event listener method receives a Acme\Bundle\ResourceBundle\Event\BuildingEventArgs instance.
     */
    const ON_BUILT = 'acme.event.{0}.built';

    /**
     * The ON_CREATING event occurs before the entity is created.
     *
     * This event allows you to modify the values of the entity before create or cancel creating.
     * The event listener method receives a Acme\Bundle\ResourceBundle\Event\CancelableEventArgs instance.
     */
    const ON_CREATING = 'acme.event.{0}.creating';

    /**
     * The ON_CREATED event occurs after the entity is created.
     *
     * This event allows you to access the entity which will be created.
     * The event listener method receives a Acme\Bundle\ResourceBundle\Event\LifecycleEventArgs instance.
     */
    const ON_CREATED = 'acme.event.{0}.created';

    /**
     * The ON_UPDATING event occurs before the entity is updated.
     *
     * This event allows you to modify the values of the entity before update or cancel updating.
     * The event listener method receives a Acme\Bundle\ResourceBundle\Event\CancelableEventArgs instance.
     */
    const ON_UPDATING = 'acme.event.{0}.updating';

    /**
     * The ON_UPDATED event occurs after the entity is updated.
     *
     * This event allows you to access the entity which will be updated.
     * The event listener method receives a Acme\Bundle\ResourceBundle\Event\LifecycleEventArgs instance.
     */
    const ON_UPDATED = 'acme.event.{0}.updated';

    /**
     * The ON_DELETING event occurs before the entity is deleted.
     *
     * This event allows you to modify the values of the entity before delete or cancel deleting.
     * The event listener method receives a Acme\Bundle\ResourceBundle\Event\CancelableEventArgs instance.
     */
    const ON_DELETING = 'acme.event.{0}.deleting';

    /**
     * The ON_DELETED event occurs after the entity is deleted.
     *
     * This event allows you to access the entity which will be deleted.
     * The event listener method receives a Acme\Bundle\ResourceBundle\Event\LifecycleEventArgs instance.
     */
    const ON_DELETED = 'acme.event.{0}.deleted';
}
