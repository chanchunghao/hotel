<?php

namespace Acme\Bundle\ApiBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class RespondingEventArgs extends Event
{
    /**
     * @var array
     */
    protected $response;

    /**
     * RespondingEventArgs constructor.
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param array $response
     * @return $this
     */
    public function setResponse(array $response)
    {
        $this->response = $response;

        return $this;
    }
}
