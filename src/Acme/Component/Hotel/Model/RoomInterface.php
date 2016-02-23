<?php

namespace Acme\Component\Hotel\Model;

use Acme\Component\Resource\Model\DomainObjectInterface;

interface RoomInterface extends DomainObjectInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * @return OfferInterface
     */
    public function getOffer();

    /**
     * @param OfferInterface $offer
     *
     * @return $this
     */
    public function setOffer($offer = null);
}
