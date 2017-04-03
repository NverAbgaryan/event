<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Property;
use AppBundle\Entity\PropertyProduct;
use AppBundle\Entity\PropertyType;
use AppBundle\Entity\User;
use AppBundle\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\Date;

class PropertyManager
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;


    /**
     * PropertyManager constructor.
     *
     * @param PropertyRepository $repository
     * @param EntityManager      $em
     */
    public function __construct(PropertyRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param $id
     *
     * @return object|null|Property
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     *
     * @return object|null|Property
     */
    public function findOneBy($criteria = [])
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAll()
    {
        $qb = $this->repository->createQueryBuilder('property');

        return $qb;
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function findBy($user)
    {
        return $this->repository->createQueryBuilder('property')
            ->where("property.owner = :owner")
            ->andWhere("property.actived =:active")
            ->andWhere("property.removed =:notRemoved")
            ->setParameters(array("owner" => $user,"active"=>true,"notRemoved" => false))
            ->orderBy("property.start", "DESC")
            ->getQuery()
            ->getResult();
    }

    /**
     * @param PropertyType $type
     *
     * @return mixed
     */
    public function findByTypeResultTwo(PropertyType $type)
    {
        return $this->repository->createQueryBuilder('property')
            ->where("property.type = :type")
            ->andWhere("property.actived =:active")
            ->andWhere("property.removed =:notRemoved")
            ->andWhere("property.end >= :date")
            ->setParameters(array(
                "type" => $type,
                "active"=>true,
                "notRemoved" => false,
                "date" => new \DateTime("now")
            ))
            ->orderBy("property.end","DESC")
            ->getQuery()
            ->getResult();
    }

    /**
     * @param PropertyType $type
     *
     * @return mixed
     */
    public function findByType(PropertyType $type)
    {
        return $this->repository->createQueryBuilder('property')
            ->where("property.type = :type")
            ->setParameter("type",$type);
    }


    /**
     * @return mixed
     */
    public function findByFilters($type,$propertyType,$start,$end, $category)
    {
        $qb = $this->repository->createQueryBuilder('property');

        $qb ->where($qb->expr()->in("property.type" ,":type"))
            ->andWhere("property.start >= :start")
            ->andWhere("property.end <= :end")
            ->andWhere($qb->expr()->in("property.propertyType" ,":propertyType"))
            ->andWhere($qb->expr()->in("property.category" ,":category"))
            ->setParameters(array(
                "type" => $type,
                "category" => $category,
                "start" => $start,
                "end" => $end,
                "propertyType" => $propertyType
            ))
        ;
        return $qb;
    }

    /**
     * @return Property
     */
    public function create()
    {
        return new Property();
    }

    /**
     * @param Property $property
     *
     * @return Property
     */
    public function persist(Property $property)
    {
        $this->em->persist($property);
        $this->em->flush();

        return $property;
    }


    /**
     * @param Property $property
     *
     * @return string
     */
    public function remove(Property $property)
    {
        $this->em->remove($property);
        $this->em->flush();

        return "Removed item";
    }
}
