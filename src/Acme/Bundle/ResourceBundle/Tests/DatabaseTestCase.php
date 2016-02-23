<?php
namespace Acme\Bundle\ResourceBundle\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class DatabaseTestCase extends KernelTestCase
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $this->em->beginTransaction();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        if ($this->em) {
            $this->em->rollback();
            $this->em->close();
        }
        parent::tearDown();
    }
}
