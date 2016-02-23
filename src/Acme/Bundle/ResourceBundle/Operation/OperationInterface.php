<?php

namespace Acme\Bundle\ResourceBundle\Operation;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Comparison;

interface OperationInterface
{
    /**
     * @param string $property
     * @param mixed $value
     * @return Comparison
     */
    public function getExpr($property, $value);
}
