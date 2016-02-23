<?php

namespace Acme\Component\Hotel\Service;

interface OfferFinderInterface
{
    /**
     * @param \DateTime $checkInDate
     * @param \DateTime $checkOutDate
     *
     * @return array
     */
    public function findRooms(\DateTime $checkInDate, \DateTime $checkOutDate);
}
