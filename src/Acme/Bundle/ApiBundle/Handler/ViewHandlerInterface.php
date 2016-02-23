<?php

namespace Acme\Bundle\ApiBundle\Handler;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler as FOSViewHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ViewHandlerInterface
{
    /**
     * @param FOSViewHandler $handler
     * @param View $view
     * @param Request $request
     * @param $format
     * @return Response
     */
    public function createResponse($handler, $view, $request, $format);
}
