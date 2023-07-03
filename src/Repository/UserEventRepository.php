<?php

namespace App\Repository;

use App\Entity\User\UserEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserEvent>
 *
 * @method UserEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEvent[]    findAll()
 * @method UserEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEvent::class);
    }

    public function save(UserEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return UserEvent
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(): UserEvent
    {
        $entity=new UserEvent();
        $this->getEntityManager()->persist($entity);
        return $entity;
    }

    public function findOneById(int $id): UserEvent|null
    {
        return $this->find($id);
    }
    /**
     * @param array      $params
     *
     * @return UserEvent[]
     */
    public function search(array $params): array
    {
        $qb = $this->createQueryBuilder("c");

        if (isset($params["id"]))
        {
            $qb->andWhere("c.id = :id")->setParameter("id", $params["id"]);
        }
        if (isset($params["ids"]))
        {
            $qb->andWhere("c.id in (:ids)")->setParameter("ids", $params["ids"]);
        }
        if (isset($params["userId"]))
        {
            $qb->andWhere("c.user = :userId")->setParameter("userId", $params["userId"]);
        }

        $query = $qb->getQuery();

        return $query->getResult();
    }

//    /**
//     * @return UserEvent[] Returns an array of UserEvent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserEvent
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
