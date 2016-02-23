<?php

namespace Acme\Bundle\ResourceBundle\Event;

class CancelableEventArgs extends LifecycleEventArgs
{
    /**
     * @var bool
     */
    protected $cancel = false;

    /**
     * @return boolean
     */
    public function isCancel()
    {
        return $this->cancel;
    }

    /**
     * @param boolean $cancel
     * @return $this
     */
    public function setCancel($cancel)
    {
        $this->cancel = $cancel;

        return $this;
    }
}
