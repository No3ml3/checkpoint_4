<?php

namespace App\Repository;

use App\Entity\Music;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Music>
 *
 * @method Music|null find($id, $lockMode = null, $lockVersion = null)
 * @method Music|null findOneBy(array $criteria, array $orderBy = null)
 * @method Music[]    findAll()
 * @method Music[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Music::class);
    }
    public function findFavoriteMusic(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT
        m.name AS name,
        m.audio AS audio,
        u.first_name AS firstName,
        u.last_name AS lastName,
        g.name AS genreName, 
        g.picture AS genrePicture, 
        COUNT(um.user_id) AS numberFav
    FROM
        music m
    JOIN
        user u ON m.user_id = u.id
    LEFT JOIN
        user_music um ON m.id = um.music_id
    JOIN
        type g ON m.type_id = g.id
    GROUP BY
        m.name, m.audio, u.first_name, u.last_name, g.name, g.picture
    ORDER BY
        COUNT(um.user_id) DESC
    LIMIT 4;
            ';

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return Music[] Returns an array of Music objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Music
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
