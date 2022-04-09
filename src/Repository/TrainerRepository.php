<?php

namespace App\Repository;

use App\Entity\Trainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method Trainer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trainer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trainer[]    findAll()
 * @method Trainer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainerRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trainer::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Trainer $entity, bool $flush = true): void
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
    public function remove(Trainer $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Trainer) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return Trainer[] Returns an array of Language objects
     */
    public function findTrainerByCompany(int $companyId): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.id', 't.firstname', 't.name', 't.email', 't.isActive')
            ->andWhere('t.company = :companyId')
//            ->andWhere('t.roles = :roles ')
            ->setParameter('companyId', $companyId)
//            ->setParameter('roles', $roles)
            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }


    /**
     * @throws NonUniqueResultException
     */
    public function findTrainerById(int $trainerId)
    {
        return $this->createQueryBuilder('t')
            ->select('t.id', 't.firstname', 't.name', 't.email', 't.roles','t.isActive')
            ->andWhere('t.id = :trainerId')
            ->setParameter('trainerId', $trainerId)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }


    /**
     * @throws NonUniqueResultException
     */
    public function findTrainerByCourses(int $coursId): ?Trainer
    {
        return $this->createQueryBuilder('t')
            ->select('t.cours')
            ->andWhere('t.cours = : coursId')
            ->setParameter('coursId', $coursId)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}
