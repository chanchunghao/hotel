<?php

namespace Acme\Bundle\ApiBundle\Response;

use Acme\Component\Common\Pagination\PaginatorInterface;

class ResponseDataFactory implements ResponseDataFactoryInterface
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @var array
     */
    protected $response = [];

    /**
     * {@inheritdoc}
     */
    public function get($data, $status = self::STATUS_SUCCESS)
    {
        return ['data' => $data, 'status' => $status];
    }

    /**
     * {@inheritdoc}
     */
    public function getPaginationData(PaginatorInterface $paginator, $status = self::STATUS_SUCCESS)
    {
        return ['data' => [
            'results' => $paginator->getCurrentPage(),
            'page' => $paginator->getPageIndex(),
            'limit' => $paginator->getPageSize(),
            'total' => $paginator->getTotal(),
            'totalPage' => $paginator->getPageCount()
        ], 'status' => $status];
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorData($message, $status = self::STATUS_ERROR, $code = null, array $errors = null)
    {
        $data = ['message' => $message, 'status' => $status];

        if ($code) {
            $data['code'] = $code;
        }

        if ($errors) {
            $data['errors'] = $errors;
        }

        return $data;
    }
}
