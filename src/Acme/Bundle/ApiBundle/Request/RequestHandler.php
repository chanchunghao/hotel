<?php

namespace Acme\Bundle\ApiBundle\Request;

use Acme\Component\Common\Collection\Enumerable;
use Acme\Component\Common\Utility\String;
use Acme\Component\Resource\Criteria\MetadataDriverInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var MetadataDriverInterface
     */
    protected $driver;

    public function __construct(MetadataDriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * {@inheritdoc}
     */
    public function getSorters(Request $request, $className)
    {
        $results = [];
        $sorting = $request->get('sort');

        if ($sorting) {
            $predicate = function ($s) use ($className) {
                return $this->driver->isSortable($className, $this->getSortKey($s));
            };
            $keySelector = function ($s) {
                return $this->getSortKey($s);
            };
            $valueSelector = function ($s) {
                return String::startsWith($s, '-') ? 'DESC' : 'ASC';
            };
            $results = Enumerable::from(String::split($sorting, ','))
                ->where($predicate)
                ->toDictionary($keySelector, $valueSelector);
        }

        return $results;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters(Request $request, $className)
    {
        $predicate = function ($value, $key) use ($className) {
            return $this->driver->isFilterable($className, $key);
        };

        return Enumerable::from($request->query->all())->where($predicate)->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getKeyword(Request $request)
    {
        return $request->get('q', '');
    }

    /**
     * {@inheritdoc}
     */
    public function getPageIndex(Request $request)
    {
        return $request->get('page', 1);
    }

    /**
     * {@inheritdoc}
     */
    public function getPageSize(Request $request)
    {
        return $request->get('limit', 10);
    }

    /**
     * @param string $s
     * @return string
     */
    protected function getSortKey($s)
    {
        return (String::startsWith($s, '-') || String::startsWith($s, '+')) ? substr($s, 1) : $s;
    }
}
