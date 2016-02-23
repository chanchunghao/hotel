<?php

namespace Acme\Bundle\ResourceBundle\Manager;

use Acme\Component\Resource\Manager\ManagerInterface;
use Acme\Component\Resource\Model\DomainObjectInterface;

interface ResourceManagerInterface extends ManagerInterface
{
    /**
     * @param array $params
     * @param bool $event
     *
     * @return DomainObjectInterface
     */
    public function build(array $params, $event = false);

    /**
     * @return string
     */
    public function getEntityClassName();

    /**
     * @return string
     */
    public function getEntityName();
}
