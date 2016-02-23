<?php

namespace Acme\Component\Hotel\Model;

use Acme\Component\Resource\Model\DomainObjectTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Offer implements OfferInterface
{
    use DomainObjectTrait;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var Collection
     */
    protected $rooms;

    /**
     * Offer constructor.
     */
    public function __construct()
    {
        $this->rooms = new ArrayCollection();
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setDate($date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return RoomInterface[]
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * @param RoomInterface[] $rooms
     *
     * @return $this
     */
    public function setRooms($rooms = null)
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * @param RoomInterface $room
     *
     * @return $this
     */
    public function addRoom(RoomInterface $room)
    {
        $this->rooms[] = $room;

        return $this;
    }

    /**
     * @param RoomInterface $room
     *
     * @return $this
     */
    public function removeRoom(RoomInterface $room)
    {
        $this->rooms->removeElement($room);
    }
}
