<?php

namespace Acme\Component\Hotel\Model;

use Acme\Component\Resource\Model\DomainObjectTrait;

class Room implements RoomInterface
{
    use DomainObjectTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var OfferInterface
     */
    protected $offer;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return OfferInterface
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * @param OfferInterface $offer
     * @return $this
     */
    public function setOffer($offer = null)
    {
        $this->offer = $offer;

        return $this;
    }
}
