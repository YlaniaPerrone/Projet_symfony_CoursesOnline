<?php

namespace App\Repository;

use App\Entity\Cours;
use App\Entity\Trainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Cours $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Cours $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Cours[] Returns an array of Cours objects
     */

    public function findCoursesByTrainer(int $trainerId): array
    {
        return $this->createQueryBuilder('c')
                ->select(['c.id', 'c.Title', 'c.level', 'c.nbrSession', 'c.Duration', 'c.price', 'c.Description', 'c.Date', 'l.name'])
                ->join('c.language',  'l')
                ->andWhere('c.trainer = :trainerId')
//                ->andWhere('c.language = :languageId')
                ->setParameter('trainerId', $trainerId)
//                ->setParameter('languageId', $languageId)
                ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
                ->getQuery()
                ->getResult()
                ;
    }


    /*
    public function findOneBySomeField($value): ?Cours
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
