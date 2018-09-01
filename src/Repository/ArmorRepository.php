<?php

namespace App\Repository;

use App\Entity\Armor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Armor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Armor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Armor[]    findAll()
 * @method Armor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArmorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Armor::class);
    }

//    /**
//     * @return Armor[] Returns an array of Armor objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Armor
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findArmorByLevel($level)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.levelAvailable <= :val')
            ->setParameter('val', $level)
            ->getQuery()
            ->getResult()
        ;
    }
}
