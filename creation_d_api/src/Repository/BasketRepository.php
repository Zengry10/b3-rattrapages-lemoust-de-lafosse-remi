<?php

namespace App\Repository;

use App\Entity\Basket;
use App\Enum\BasketStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Basket>
 */
class BasketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Basket::class);
    }

    public function getUserActiveBasket(int $userId)
    {
        return $this->getUserBasketByStatus($userId, BasketStatusEnum::DRAFT);
    }

    public function getValidatedBasket(int $userId)
    {
        return $this->getUserBasketByStatus($userId, BasketStatusEnum::VALIDATED);
    }

    public function getCancellableBasket(int $userId)
    {
        $queryBuilder = $this->createQueryBuilder("b");

        return $queryBuilder
            ->andWhere("b.user = :userId")
            ->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->eq("b.status", ":draftStatus"),
                $queryBuilder->expr()->eq("b.status", ":validatedStatus")
            ))
            ->setParameters(new ArrayCollection([
                new Parameter("userId", $userId),
                new Parameter("draftStatus", BasketStatusEnum::DRAFT->value),
                new Parameter("validatedStatus", BasketStatusEnum::VALIDATED->value),
            ]))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getUserBasketByStatus(int $userId, BasketStatusEnum $status)
    {
        return $this->createQueryBuilder("b")
            ->andWhere("b.user = :userId")
            ->andWhere("b.status = :status")
            ->setParameters(new ArrayCollection([
                new Parameter("userId", $userId),
                new Parameter("status", $status->value),
            ]))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

//    /**
//     * @return Basket[] Returns an array of Basket objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Basket
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
