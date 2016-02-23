<?php

namespace Acme\Component\Common\Pagination;

use Pagerfanta\Adapter\DoctrineORMAdapter;

class DoctrineORMPaginator extends AbstractPaginator
{
    /**
     * {@inheritdoc}
     */
    protected function getAdapter($source)
    {
        return new DoctrineORMAdapter($source);
    }
}
