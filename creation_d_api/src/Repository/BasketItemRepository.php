<?php

namespace App\Repository;

use App\Entity\BasketItem;
use App\Enum\BasketStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BasketItem>
 */
class BasketItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BasketItem::class);
    }

    public function hasUserPurchasedProduct(int $userId, int $productId): bool
    {
        $result = $this->createQueryBuilder("b")
            ->select("b")
            ->leftJoin("b.basket", "ba")
            ->andWhere("ba.user = :userId")
            ->andWhere("ba.status = :status")
            ->andWhere("b.product = :productId")
            ->setParameters(new ArrayCollection([
                new Parameter("userId", $userId),
                new Parameter("status", BasketStatusEnum::COMPLETED->value),
                new Parameter("productId", $productId)
            ]))
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $result !== null;
    }

    //    /**
    //     * @return BasketItem[] Returns an array of BasketItem objects
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

    //    public function findOneBySomeField($value): ?BasketItem
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
