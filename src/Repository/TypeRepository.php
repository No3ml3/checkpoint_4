<?php

namespace App\Repository;

use App\Entity\Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Type>
 *
 * @method Type|null find($id, $lockMode = null, $lockVersion = null)
 * @method Type|null findOneBy(array $criteria, array $orderBy = null)
 * @method Type[]    findAll()
 * @method Type[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Type::class);
    }

    public function findFavoriteType(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT
    t.name AS name,
    t.id,
    t.picture AS picture,
    COUNT(tu.user_id) AS numberOfUsers,
    (
        SELECT m.audio
        FROM music m
        JOIN type_user tu2 ON m.user_id = tu2.user_id
        WHERE tu2.type_id = t.id
        ORDER BY m.id DESC
        LIMIT 1
    ) AS last_music
FROM
    type t
JOIN
    type_user tu ON t.id = tu.type_id
JOIN
    user u ON tu.user_id = u.id
GROUP BY
    t.name,
    t.id,
    t.picture
ORDER BY
    COUNT(tu.user_id) DESC
LIMIT 4;
';

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
    //    /**
    //     * @return Type[] Returns an array of Type objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Type
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
