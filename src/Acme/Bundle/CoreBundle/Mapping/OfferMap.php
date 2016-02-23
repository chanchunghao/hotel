<?php

namespace Acme\Bundle\CoreBundle\Mapping;

use Acme\Component\Hotel\Model\Offer;

class OfferMap extends AbstractMap
{
    public function __construct()
    {
        $this->arrayMembers(['id', 'name', 'date']);
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
        return Offer::class;
    }
}
