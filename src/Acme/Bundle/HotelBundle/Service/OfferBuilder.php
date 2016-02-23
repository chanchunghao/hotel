<?php

namespace Acme\Bundle\HotelBundle\Service;

use Acme\Component\Hotel\Model\Offer;
use Acme\Component\Hotel\Model\OfferInterface;
use Acme\Component\Hotel\Model\Room;
use Acme\Component\Hotel\Service\OfferBuilderInterface;
use Acme\Component\Hotel\Service\OfferFinderInterface;

class OfferBuilder implements OfferBuilderInterface
{
    /**
     * @var OfferFinderInterface
     */
    protected $finder;

    /**
     * @var \DateTime
     */
    protected $checkInDate;

    /**
     * @var \DateTime
     */
    protected $checkOutDate;

    /**
     * OfferBuilder constructor.
     * @param OfferFinderInterface $finder
     */
    public function __construct(OfferFinderInterface $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setCheckInDate(\DateTime $date)
    {
        $this->checkInDate = $date;

        return $this;
    }

    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setCheckOutDate(\DateTime $date)
    {
        $this->checkOutDate = $date;

        return $this;
    }

    /**
     * @return OfferInterface
     */
    public function build()
    {
        $checkInDate = $this->checkInDate ?: new \DateTime();
        $checkOutDate = $this->checkOutDate;

        if (empty($checkOutDate)) {
            $checkOutDate = clone  $checkInDate;
            $checkOutDate->add(date_interval_create_from_date_string('1 day'));
        }

        $offer = new Offer();
        $offer->setDate($checkInDate);

        foreach ($this->finder->findRooms($checkInDate, $checkOutDate) as $roomName) {
            $room = new Room();
            $room->setName($roomName)->setOffer($offer);
            $offer->addRoom($room);
        }

        return $offer;
    }
}
