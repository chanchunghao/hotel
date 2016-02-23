<?php

namespace Acme\Bundle\ResourceBundle\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class ControllerTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->client = static::createClient();
        $this->em = $this->get('doctrine')->getManager();
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

    /**
     * Gets a service by id.
     *
     * @param string $id The service id
     *
     * @return object The service
     */
    protected function get($id)
    {
        return $this->client->getContainer()->get($id);
    }

    /**
     * Generates a URL from the given parameters.
     *
     * @param string      $route         The name of the route
     * @param mixed       $parameters    An array of parameters
     * @param bool|string $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     *
     * @return string The generated URL
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->get('router')->generate($route, $parameters, $referenceType);
    }

    /**
     * @param Response $response
     * @return \stdClass
     */
    protected function getJson(Response $response)
    {
        return json_decode($response->getContent());
    }
}
