<?php

namespace Acme\Bundle\HotelBundle\Tests\Repository;

use Acme\Bundle\ResourceBundle\Tests\DatabaseTestCase;
use Acme\Component\Hotel\Model\Offer;
use Acme\Component\Hotel\Model\OfferInterface;
use Acme\Component\Resource\Repository\RepositoryInterface;

class OfferRepositoryTest extends DatabaseTestCase
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->em->getRepository(Offer::class);
        $this->createOffer(new \DateTime());
        $this->createOffer(new \DateTime());
        $this->em->flush();
    }

    public function testFindAll()
    {
        $this->assertEquals(2, count($this->repository->findAll()));
    }

    /**
     * @param \DateTime $date
     * @param bool $persist
     *
     * @return OfferInterface
     */
    private function createOffer(\DateTime $date, $persist = true)
    {
        $offer = new Offer();
        $offer->setDate($date);

        if ($persist) {
            $this->em->persist($offer);
        }

        return $offer;
    }
}
