<?php

namespace Acme\Bundle\ResourceBundle\Operation;

use Acme\Component\Common\Utility\String;

class LikeOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    public function getExpr($property, $value)
    {
        return $this->expr->like($property, $this->normalizeValue($value));
    }

    /**
     * {@inheritdoc}
     */
    protected function getOperator()
    {
        return '%';
    }

    /**
     * {@inheritdoc}
     */
    protected function normalizeValue($value)
    {
        $operator = $this->getOperator();

        return (String::startsWith($value, $operator) || String::endsWith($value, $operator)) ?
            $value :
            $operator . $value . $operator;
    }
}
