<?php

namespace Acme\Bundle\ApiBundle\Request;

use Symfony\Component\HttpFoundation\Request;

interface RequestHandlerInterface
{
    /**
     * @param Request $request
     * @param $className
     * @return array
     */
    public function getSorters(Request $request, $className);

    /**
     * @param Request $request
     * @param $className
     * @return array
     */
    public function getFilters(Request $request, $className);

    /**
     * @param Request $request
     * @return string
     */
    public function getKeyword(Request $request);

    /**
     * @param Request $request
     * @return int
     */
    public function getPageIndex(Request $request);

    /**
     * @param Request $request
     * @return int
     */
    public function getPageSize(Request $request);
}
