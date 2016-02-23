<?php

namespace Acme\Bundle\ResourceBundle\Event;

use Acme\Component\Resource\Model\DomainObjectInterface;

class BuildingEventArgs extends LifecycleEventArgs
{
    /**
     * @var array
     */
    protected $params;

    public function __construct(DomainObjectInterface $obj, array $params)
    {
        parent::__construct($obj);
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }
}
