<?php

namespace Acme\Bundle\ResourceBundle\Operation;

class EqualOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    public function getExpr($property, $value)
    {
        return $this->expr->eq($property, $this->normalizeValue($value));
    }

    /**
     * {@inheritdoc}
     */
    protected function getOperator()
    {
        return '=';
    }
}
