<?php

namespace Acme\Component\Resource\Model;

interface DomainObjectInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);
}
