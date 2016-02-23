<?php

namespace Acme\Bundle\ResourceBundle\Repository;

use Doctrine\ORM\EntityRepository as RepositoryBase;
use Doctrine\ORM\QueryBuilder;
use Acme\Bundle\ResourceBundle\Operation\OperationFactory;
use Acme\Bundle\ResourceBundle\Operation\OperationFactoryInterface;
use Acme\Component\Common\Pagination\DoctrineORMPaginator;
use Acme\Component\Common\Utility\String;
use Acme\Component\Resource\Repository\RepositoryInterface;

class EntityRepository extends RepositoryBase implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->getAll()->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $qb = $this->getBy($criteria, $orderBy ?: []);

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        if ($offset) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public static function createPaginator($source)
    {
        return new DoctrineORMPaginator($source);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(array $sorters = [])
    {
        $qb = $this->createQueryBuilder($this->getAlias());
        $this->applySort($qb, $sorters);

        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function getBy(array $filters, array $sorters = null)
    {
        $qb = $this->createQueryBuilder($this->getAlias());
        $this->applyFilters($qb, $filters)->applySort($qb, $sorters);

        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function search($q, array $fields, array $filters = [], array $sorters = [])
    {
        $qb = $this->createQueryBuilder($this->getAlias());
        $this->applyFilters($qb, $filters)->applySearch($qb, $q, $fields)->applySort($qb, $sorters);

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param array $filters
     * @return $this
     */
    protected function applyFilters(QueryBuilder $qb, array $filters)
    {
        foreach ($filters as $filterBy => $value) {
            if (null !== $value && '' !== $value) {
                $name = $this->getPropertyName($filterBy);
                $operation = $this->getOperationFactory()->get($qb->expr(), $value);
                $parameter = str_replace('.', '_', $filterBy);
                $qb
                    ->andWhere($operation->getExpr($name, ':' . $parameter))
                    ->setParameter($parameter, $value);
            }
        }

        return $this;
    }

    /**
     * @param QueryBuilder $qb
     * @param array $sorters
     * @return $this
     */
    protected function applySort(QueryBuilder $qb, array $sorters)
    {
        foreach ($sorters as $sortBy => $order) {
            $qb->addOrderBy($this->getPropertyName($sortBy), $order);
        }

        return $this;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $q
     * @param array $fields
     * @return $this
     */
    protected function applySearch(QueryBuilder $qb, $q, array $fields)
    {
        if ($q && $fields) {
            if (count($fields) > 1) {
                $expr = $qb->expr()->orX();
                foreach ($fields as $field) {
                    $expr->add($qb->expr()->like($this->getPropertyName($field), ':q'));
                }
            } else {
                $expr = $qb->expr()->like($this->getPropertyName($fields[0]), ':q');
            }

            $qb->andWhere($expr)->setParameter('q', '%' . $q . '%');
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function getPropertyName($name)
    {
        if (false === strpos($name, '.')) {
            return $this->getAlias() . '.' . String::toCamelCase($name);
        }

        return $name;
    }

    /**
     * @return string
     */
    protected function getAlias()
    {
        return 'this';
    }

    /**
     * @return OperationFactoryInterface
     */
    protected function getOperationFactory()
    {
        return OperationFactory::getInstance();
    }
}
