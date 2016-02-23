<?php

namespace Acme\Bundle\ResourceBundle\Operation;

class LowerThanEqualOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    public function getExpr($property, $value)
    {
        return $this->expr->lte($property, $this->normalizeValue($value));
    }

    /**
     * {@inheritdoc}
     */
    protected function getOperator()
    {
        return '<=';
    }
}
