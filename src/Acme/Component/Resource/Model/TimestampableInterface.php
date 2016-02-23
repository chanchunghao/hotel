<?php

namespace Acme\Component\Resource\Model;

interface TimestampableInterface
{
    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param \DateTime $dateTime
     * @return $this
     */
    public function setCreatedAt(\DateTime $dateTime);

    /**
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * @param \DateTime $dateTime
     * @return $this
     */
    public function setUpdatedAt(\DateTime $dateTime);
}
