<?php

namespace Acme\Component\Hotel\Model;

use Acme\Component\Resource\Model\DomainObjectInterface;

interface OfferInterface extends DomainObjectInterface
{
    /**
     * @return \DateTime
     */
    public function getDate();

    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setDate($date = null);

    /**
     * @return RoomInterface[]
     */
    public function getRooms();

    /**
     * @param RoomInterface[] $rooms
     *
     * @return $this
     */
    public function setRooms($rooms = null);

    /**
     * @param RoomInterface $room
     *
     * @return $this
     */
    public function addRoom(RoomInterface $room);

    /**
     * @param RoomInterface $room
     *
     * @return $this
     */
    public function removeRoom(RoomInterface $room);
}
