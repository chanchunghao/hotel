<?php

namespace Acme\Bundle\ResourceBundle\Operation;

use Doctrine\ORM\Query\Expr;
use Acme\Component\Common\Utility\String;

abstract class AbstractOperation implements OperationInterface
{
    /**
     * @var Expr
     */
    protected $expr;

    /**
     * @param Expr $expr
     */
    public function __construct(Expr $expr)
    {
        $this->expr = $expr;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getExpr($property, $value);

    /**
     * @return string
     */
    abstract protected function getOperator();

    /**
     * @param mixed $value
     * @return mixed
     */
    protected function normalizeValue($value)
    {
        return String::startsWith($value, $this->getOperator()) ? substr($value, count($this->getOperator())) : $value;
    }
}
