<?php

namespace Acme\Bundle\ResourceBundle\Operation;

class GreaterThanOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    public function getExpr($property, $value)
    {
        return $this->expr->gt($property, $this->normalizeValue($value));
    }

    /**
     * {@inheritdoc}
     */
    protected function getOperator()
    {
        return '>';
    }
}
