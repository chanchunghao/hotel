<?php

namespace Acme\Bundle\ResourceBundle\Operation;

class GreaterThanEqualOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    public function getExpr($property, $value)
    {
        return $this->expr->gte($property, $this->normalizeValue($value));
    }

    /**
     * {@inheritdoc}
     */
    protected function getOperator()
    {
        return '>=';
    }
}
