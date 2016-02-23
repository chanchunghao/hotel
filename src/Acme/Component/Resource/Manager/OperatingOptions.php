<?php

namespace Acme\Component\Resource\Manager;

class OperatingOptions
{
    /**
     * @var bool
     */
    protected $flush = true;

    /**
     * @var bool
     */
    protected $eventEnabled = true;

    /**
     * @return bool
     */
    public function getFlush()
    {
        return $this->flush;
    }

    /**
     * @param bool $flush
     * @return $this
     */
    public function setFlush($flush)
    {
        $this->flush = $flush;

        return $this;
    }

    /**
     * @return bool
     */
    public function getEventEnabled()
    {
        return $this->eventEnabled;
    }

    /**
     * @param $eventEnabled
     * @return $this
     */
    public function setEventEnabled($eventEnabled)
    {
        $this->eventEnabled = $eventEnabled;

        return $this;
    }
}
