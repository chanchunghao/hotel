<?php

namespace Acme\Bundle\HotelBundle\Service;

use Acme\Component\Common\Collection\Enumerable;
use Acme\Component\Common\Utility\String;
use Acme\Component\Hotel\Service\OfferFinderInterface;
use Buzz\Browser;
use Symfony\Component\DomCrawler\Crawler;

class OfferFinder implements OfferFinderInterface
{
    /**
     * @var string
     */
    protected $requestUrlFormat;

    /**
     * OfferFinder constructor.
     *
     * @param string $requestUrlFormat
     */
    public function __construct($requestUrlFormat)
    {
        $this->requestUrlFormat = $requestUrlFormat;
    }

    /**
     * {@inheritdoc}
     */
    public function findRooms(\DateTime $checkInDate, \DateTime $checkOutDate)
    {
        $requestUrl = String::format(
            $this->requestUrlFormat,
            $checkInDate->format('d/m/Y'),
            $checkOutDate->format('d/m/Y')
        );

        $browser = new Browser();
        $response = $browser->get($requestUrl);
        $crawler = new Crawler($response->getContent());

        $selector = function (Crawler $node) {
          return $node->text();
        };

        return $crawler->filter('.room-info > h3')->each($selector);
    }
}
