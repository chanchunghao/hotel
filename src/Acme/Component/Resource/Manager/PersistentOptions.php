<?php

namespace Acme\Component\Resource\Manager;

class PersistentOptions extends OperatingOptions
{
    /**
     * @var bool
     */
    protected $validate = true;

    /**
     * @var ValidatingOptions
     */
    protected $validatingOptions;

    public function __construct()
    {
        $this->validatingOptions = new ValidatingOptions();
    }

    /**
     * @return boolean
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * @param boolean $validate
     * @return $this
     */
    public function setValidate($validate)
    {
        $this->validate = $validate;

        return $this;
    }

    /**
     * @return ValidatingOptions
     */
    public function getValidatingOptions()
    {
        return $this->validatingOptions;
    }

    /**
     * @param ValidatingOptions $validatingOptions
     * @return $this
     */
    public function setValidatingOptions($validatingOptions)
    {
        $this->validatingOptions = $validatingOptions;

        return $this;
    }
}
