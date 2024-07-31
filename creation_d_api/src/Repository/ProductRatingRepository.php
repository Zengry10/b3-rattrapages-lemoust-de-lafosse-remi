<?php

namespace App\Repository;

use App\Entity\ProductRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductRating>
 */
class ProductRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductRating::class);
    }

    public function hasUserRatedProduct(int $userId, int $productId): bool
    {
        $result = $this->createQueryBuilder("p")
            ->andWhere("p.user = :userId")
            ->andWhere("p.product = :productId")
            ->setParameters(new ArrayCollection([
                new Parameter("userId", $userId),
                new Parameter("productId", $productId)
            ]))
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $result !== null;
    }

    //    /**
    //     * @return ProductRating[] Returns an array of ProductRating objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ProductRating
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
