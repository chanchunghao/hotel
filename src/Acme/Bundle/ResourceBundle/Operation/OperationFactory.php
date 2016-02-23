<?php

namespace Acme\Bundle\ResourceBundle\Operation;

use Doctrine\ORM\Query\Expr;
use Acme\Component\Common\Utility\String;

class OperationFactory implements OperationFactoryInterface
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * {@inheritdoc}
     */
    public function get(Expr $expr, $value)
    {
        $result = null;

        switch (true) {
            case is_array($value):
                $result = new InOperation($expr);
                break;

            case is_string($value) && (String::startsWith($value, '%') || String::endsWith($value, '%')):
                $result = new LikeOperation($expr);
                break;

            case is_string($value) && String::startsWith($value, '>='):
                $result = new GreaterThanEqualOperation($expr);
                break;

            case is_string($value) && String::startsWith($value, '<='):
                $result = new LowerThanEqualOperation($expr);
                break;

            case is_string($value) && String::startsWith($value, '>'):
                $result = new GreaterThanOperation($expr);
                break;

            case is_string($value) && String::startsWith($value, '<'):
                $result = new LowerThanOperation($expr);
                break;

            default:
                $result = new EqualOperation($expr);
        }

        return $result;
    }
}
