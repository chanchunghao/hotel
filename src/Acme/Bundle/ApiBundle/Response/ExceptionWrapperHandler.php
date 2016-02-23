<?php

namespace Acme\Bundle\ApiBundle\Response;

use FOS\RestBundle\Util\ExceptionWrapper;
use FOS\RestBundle\View\ExceptionWrapperHandlerInterface;

class ExceptionWrapperHandler implements ExceptionWrapperHandlerInterface
{
    /**
     * @param $data
     *
     * @return ExceptionWrapper
     */
    public function wrap($data)
    {
        return $this->getResponseDataFactory()->getErrorData(
            $data['message'],
            ResponseDataFactory::STATUS_ERROR,
            $data['status_code']
        );
    }

    /**
     * @return ResponseDataFactoryInterface
     */
    protected function getResponseDataFactory()
    {
        return ResponseDataFactory::getInstance();
    }
}
