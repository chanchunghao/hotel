<?php

namespace Acme\Bundle\CoreBundle\Mapping;

use BCC\AutoMapperBundle\Mapper\AbstractMap as MapBase;
use BCC\AutoMapperBundle\Mapper\FieldAccessor\Simple;

abstract class AbstractMap extends MapBase
{
    /**
     * {@inheritdoc}
     */
    public function buildDefaultMap()
    {
        $type = $this->getSourceType() !== 'array' ? $this->getSourceType() : $this->getDestinationType();
        $reflectionClass = new \ReflectionClass($type);

        foreach ($reflectionClass->getProperties() as $property) {
            $this->fieldAccessors[$property->name] = new Simple($property->name);
        }

        return $this;
    }

    /**
     * @param string $member
     * @return $this
     */
    protected function arrayMember($member)
    {
        $this->route($member, '[' . $member . ']');

        return $this;
    }

    /**
     * @param string[] $members
     * @return $this
     */
    protected function arrayMembers(array $members)
    {
        foreach ($members as $member) {
            $this->arrayMember($member);
        }

        return $this;
    }
}
