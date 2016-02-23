<?php

namespace Acme\Bundle\ResourceBundle\Operation;

use Doctrine\ORM\Query\Expr;

interface OperationFactoryInterface
{
    /**
     * @param Expr $expr
     * @param mixed $value
     * @return OperationInterface
     */
    public function get(Expr $expr, $value);
}
