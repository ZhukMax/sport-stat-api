<?php

namespace App\Repository;

use App\Entity\SportType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SportType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportType[]    findAll()
 * @method SportType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportType::class);
    }

    public function findOneBySynonyms($value): ?SportType
    {
      $conn = $this->getEntityManager()->getConnection();

      $sql = '
          SELECT * FROM sport_type s
          WHERE JSON_SEARCH(s.synonyms, \'one\', :synonym) is not null';
      $stmt = $conn->prepare($sql);
      $stmt->execute(['synonym' => $value]);

      return $stmt->fetchOne();
    }

    // /**
    //  * @return SportType[] Returns an array of SportType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SportType
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
