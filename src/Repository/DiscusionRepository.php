<?php

namespace App\Repository;

use App\Entity\Discusion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Discusion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discusion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discusion[]    findAll()
 * @method Discusion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscusionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Discusion::class);
    }

    // /**
    //  * @return Discusion[] Returns an array of Discusion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Discusion
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
