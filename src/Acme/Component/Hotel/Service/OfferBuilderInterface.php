<?php

namespace Acme\Component\Hotel\Service;

use Acme\Component\Hotel\Model\OfferInterface;

interface OfferBuilderInterface
{
    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setCheckInDate(\DateTime $date);

    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setCheckOutDate(\DateTime $date);

    /**
     * @return OfferInterface
     */
    public function build();
}
