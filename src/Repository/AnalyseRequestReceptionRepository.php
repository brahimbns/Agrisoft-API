<?php

namespace App\Repository;

use App\Entity\AnalyseRequestReception;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnalyseRequestReception>
 *
 * @method AnalyseRequestReception|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnalyseRequestReception|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnalyseRequestReception[]    findAll()
 * @method AnalyseRequestReception[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnalyseRequestReceptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnalyseRequestReception::class);
    }

    public function save(AnalyseRequestReception $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AnalyseRequestReception $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AnalyseRequestReception[] Returns an array of AnalyseRequestReception objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AnalyseRequestReception
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
