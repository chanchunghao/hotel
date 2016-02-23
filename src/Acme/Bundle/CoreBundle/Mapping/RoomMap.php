<?php

namespace Acme\Bundle\CoreBundle\Mapping;

use Acme\Component\Hotel\Model\Room;

class RoomMap extends AbstractMap
{
    public function __construct()
    {
        $this->arrayMembers(['id', 'name', 'offer']);
    }

    /**
     * @return string The source type
     */
    public function getSourceType()
    {
        return 'array';
    }

    /**
     * @return string The destination type
     */
    public function getDestinationType()
    {
        return Room::class;
    }
}
