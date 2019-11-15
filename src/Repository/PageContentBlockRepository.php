<?php

namespace App\Repository;

use App\Entity\PageContentBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PageContentBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageContentBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageContentBlock[]    findAll()
 * @method PageContentBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageContentBlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageContentBlock::class);
    }

    // /**
    //  * @return PageContentBlock[] Returns an array of PageContentBlock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PageContentBlock
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
