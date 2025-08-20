<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Employee;
use App\Entity\WorkPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkPoint>
 */
class WorkPointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkPoint::class);
    }

    //    /**
    //     * @return WorkPoint[] Returns an array of WorkPoint objects
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

    //    public function findOneBySomeField($value): ?WorkPoint
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findEmployeesByWorkPointId(int $workPointId) : array {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->from (Employee::class, 'e')
            ->join('e.job', 'j')
            ->join('j.department', 'd')
            ->join('d.workPoint', 'w')
            ->where('w.id = :workPointId')
            ->setParameter('workPointId', $workPointId)
            ->getQuery()
            ->getResult();
    }

    public function getWorkPoints() : array {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('w.id', 'w.name', 'w.address', 'w.county', 'w.type', 'w.phoneNumber', 'w.programStart', 'w.programEnd', 'c.name as company', 'w.createdAt', 'w.updatedAt')
            ->from (WorkPoint::class, 'w')
            ->join(Company::class, 'c', 'WITH', 'w.company = c.id')
            ->orderBy('w.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
