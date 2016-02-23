<?php

namespace Acme\Bundle\ReviewBundle\Tests\Controller;

use Acme\Bundle\ApiBundle\Response\ResponseDataFactory;
use Acme\Bundle\ResourceBundle\Tests\ControllerTestCase;
use Acme\Component\Hotel\Model\Offer;
use Acme\Component\Hotel\Model\OfferInterface;
use Acme\Component\Resource\Repository\RepositoryInterface;

class OfferControllerTest extends ControllerTestCase
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
        $this->client->request('GET', $this->generateUrl('acme.api.offers.index'));
        $response = $this->client->getResponse();
        $json = $this->getJson($response);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(ResponseDataFactory::STATUS_SUCCESS, $json->status);
        $this->assertEquals(2, count($json->data->results));
    }

    public function testGetById()
    {
        /** @var OfferInterface $entity */
        $entity = $this->repository->findAll()[0];

        $this->client->request('GET', $this->generateUrl('acme.api.offers.show', ['id' => $entity->getId()]));
        $json = $this->getJson($this->client->getResponse());

        $this->assertEquals(ResponseDataFactory::STATUS_SUCCESS, $json->status);
        $this->assertNotNull($json->data);
        $this->assertEquals($entity->getId(), $json->data->id);
    }

    public function testCreate()
    {
        $params = ['date' => (new \DateTime())->add(date_interval_create_from_date_string('1 day'))->format('d/m/Y')];
        $this->client->request('POST', $this->generateUrl('acme.api.offers.create'), $params);
        $json = $this->getJson($this->client->getResponse());

        $this->assertEquals(ResponseDataFactory::STATUS_SUCCESS, $json->status);
        $this->assertNotNull($json->data);
        $this->assertNotNull($json->data->id);
    }

    public function testUpdate()
    {
        // TODO Not implemented.
    }

    public function testDelete()
    {
        /** @var OfferInterface $entity */
        $entity = $this->repository->findAll()[0];
        $id = $entity->getId();

        $this->client->request('DELETE', $this->generateUrl('acme.api.offers.delete', ['id' => $id]));
        $json = $this->getJson($this->client->getResponse());

        $this->assertEquals(ResponseDataFactory::STATUS_SUCCESS, $json->status);
        $this->assertNull($this->repository->find($id));
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
