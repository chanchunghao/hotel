<?php
namespace Acme\Bundle\CoreBundle\Tests;

use Acme\Bundle\ResourceBundle\Tests\DatabaseTestCase;
use Acme\Component\Hotel\Model\Offer;
use Acme\Component\Resource\Model\DomainObjectInterface;

class MappingTest extends DatabaseTestCase
{
    public function testContentPageMapping()
    {
        $entity = new Offer();
        $entity->setDate(new \DateTime());
        $this->assertValidMapping($entity, 'Acme\Component\Hotel\Model\Offer');
    }

    private function assertValidMapping(DomainObjectInterface $entity, $repositoryName)
    {
        $repository = $this->em->getRepository($repositoryName);
        $total = count($repository->findAll());
        $this->em->persist($entity);
        $this->em->flush();
        $this->assertEquals($total + 1, count($repository->findAll()));
        $this->em->remove($entity);
        $this->em->flush();
        $this->assertEquals($total, count($repository->findAll()));
    }
}
