<?php

namespace Acme\Bundle\ApiBundle\Response;

use Acme\Component\Common\Pagination\PaginatorInterface;

interface ResponseDataFactoryInterface
{
    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL = 'fail';
    const STATUS_ERROR = 'error';

    /**
     * @param $data
     * @param string $status
     * @return mixed
     */
    public function get($data, $status = self::STATUS_SUCCESS);

    /**
     * @param PaginatorInterface $paginator
     * @param string $status
     * @return mixed
     */
    public function getPaginationData(PaginatorInterface $paginator, $status = self::STATUS_SUCCESS);

    /**
     * @param string $message
     * @param int $code
     * @param string $status
     * @param array $errors
     * @return mixed
     */
    public function getErrorData($message, $status = self::STATUS_ERROR, $code = null, array $errors = null);
}
