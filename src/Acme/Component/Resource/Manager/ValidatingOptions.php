<?php

namespace Acme\Component\Resource\Manager;

class ValidatingOptions
{
    /**
     * @var array
     */
    protected $groups = [];

    /**
     * @var bool
     */
    protected $traverse = true;

    /**
     * @var bool
     */
    protected $deep = true;

    /**
     * @return string
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param array $groups
     * @return $this
     */
    public function setGroups(array $groups)
    {
        $this->groups = $groups;
        $this->groups[] = 'Default';

        return $this;
    }

    /**
     * @param string $group
     * @return $this
     */
    public function addGroup($group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * @param string $group
     * @return $this
     */
    public function removeGroup($group)
    {
        array_diff($this->groups, [$group]);

        return $this;
    }

    /**
     * @return boolean
     */
    public function getTraverse()
    {
        return $this->traverse;
    }

    /**
     * @param boolean $traverse
     * @return $this
     */
    public function setTraverse($traverse)
    {
        $this->traverse = $traverse;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getDeep()
    {
        return $this->deep;
    }

    /**
     * @param boolean $deep
     * @return $this
     */
    public function setDeep($deep)
    {
        $this->deep = $deep;

        return $this;
    }
}
