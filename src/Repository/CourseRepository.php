<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function findLastCourses(int $duration = 2): array{
        //En DQL
        /*$entityManager = $this->getEntityManager();
        $dql = "SELECT c 
                FROM App\Entity\Course c
                WHERE c.duration > :duration
                ORDER BY c.dateCreated DESC";
        $query = $entityManager->createQuery($dql);
        $query->setParameter('duration',$duration)
            ->setMaxResults(5);

        return $query->getResult();*/

        //Avec le queryBuilder
        $queryBuilder = $this->createQueryBuilder('c')
            ->andWhere('c.duration > :duration')
            ->addOrderBy('c.dateCreated', 'DESC')
            ->setParameter('duration', $duration)
            ->setMaxResults(5);
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    //    /**
    //     * @return Course[] Returns an array of Course objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Course
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
