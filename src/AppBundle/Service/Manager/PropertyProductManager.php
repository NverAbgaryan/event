<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\PropertyProduct;
use AppBundle\Repository\PropertyProductRepository;
use Doctrine\ORM\EntityManager;

class PropertyProductManager
{
    /**
     * @var PropertyProductRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * PropertyProductRepository constructor.
     *
     * @param PropertyProductRepository $repository
     * @param EntityManager          $em
     */
    public function __construct(PropertyProductRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAll()
    {
        $qb = $this->repository->createQueryBuilder('property_category');

        return $qb;
    }

    /**
     * @return PropertyProduct
     */
    public function create()
    {
        return new PropertyProduct();
    }

    /**
     * @param PropertyProduct $property
     *
     * @return PropertyProduct
     */
    public function persist(PropertyProduct $product)
    {
        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }
}

