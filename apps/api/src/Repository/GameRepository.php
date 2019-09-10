<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findUniq($value): ?Game
    {
      $conn = $this->getEntityManager()->getConnection();

      $sql = '
        SELECT * FROM game g
        WHERE g.teamOne = :teamone AND g.teamTwo = :teamtwo AND g.startAt BETWEEN :time1 AND :time2';

      $stmt = $conn->prepare($sql);
      $stmt->execute([
        'teamone' => $value['teamone'],
        'teamtwo' => $value['teamtwo'],
        'time1' => $value['time']->modify('-26 hours'),
        'time2' => $value['time']->modify('+26 hours')
      ]);

      return $stmt->fetchOne();
    }

    public function findRandOne($value): ?Game
    {
      $conn = $this->getEntityManager()->getConnection();

      $sql = '
        SELECT * FROM game g
        WHERE g.source = :source
        ORDER BY RAND() LIMIT 1';

      $stmt = $conn->prepare($sql);
      $stmt->execute([
        'source' => $value['source'],
      ]);

      return $stmt->fetchOne();
    }

    // /**
    //  * @return Game[] Returns an array of Game objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
