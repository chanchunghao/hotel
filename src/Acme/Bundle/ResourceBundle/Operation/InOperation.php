<?php

namespace Acme\Bundle\ResourceBundle\Operation;

class InOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    public function getExpr($property, $value)
    {
        return $this->expr->in($property, $value);
    }

    /**
     * {@inheritdoc}
     */
    protected function getOperator()
    {
        return '';
    }
}
