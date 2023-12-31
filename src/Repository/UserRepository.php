<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

     public function findFavoriteArtist(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT
        u.id,
        u.first_name,
        u.last_name,
        u.speudo,
        u.picture,
        COUNT(DISTINCT l.user_target) AS num_likes,
        COUNT(DISTINCT m.id) AS num_music,
        (
            SELECT audio
            FROM music m2
            WHERE m2.user_id = u.id
            ORDER BY m2.id DESC
            LIMIT 1
        ) AS last_music
    FROM user u
    LEFT JOIN user_user l ON u.id = l.user_source
    LEFT JOIN music m ON u.id = m.user_id
    GROUP BY u.id, u.first_name, u.last_name, u.speudo, u.picture
    ORDER BY num_likes DESC
    LIMIT 4;
            ';

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findTrueArtist(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT
        u.id,
        u.first_name,
        u.last_name,
        u.speudo,
        u.picture,
        COUNT(DISTINCT l.user_target) AS num_likes,
        COUNT(DISTINCT m.id) AS num_music,
        (
            SELECT audio
            FROM music m2
            WHERE m2.user_id = u.id
            ORDER BY m2.id DESC
            LIMIT 1
        ) AS last_music
    FROM user u
    LEFT JOIN user_user l ON u.id = l.user_source
    LEFT JOIN music m ON u.id = m.user_id
    GROUP BY u.id, u.first_name, u.last_name, u.speudo, u.picture
    ORDER BY num_likes DESC
    LIMIT 4;
            ';

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }



  /*   public function findFavoriteArtist(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT user.first_name, user.last_name, user.id, music.id, music.name, COUNT(music.id) AS user_count
        FROM music
        JOIN user_music ON music.id = user_music.music_id
        JOIN user ON user.id = user_music.user_id
        GROUP BY music.id, music.name, user.first_name, user.last_name, user.id, music.audio
        LIMIT 4;
            ';

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    } */

//    /**
//     * @return User[] Returns an array of User objects
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

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
