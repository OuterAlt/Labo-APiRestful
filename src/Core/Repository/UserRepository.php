<?php

namespace App\Core\Repository;

use App\Core\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * @var \App\Core\Repository\RepositoryHelper $repositoryHelper
     */
    private $repositoryHelper;

    /**
     * UserRepository constructor.
     *
     * @param \Symfony\Bridge\Doctrine\RegistryInterface $registry
     * @param \App\Core\Repository\RepositoryHelper      $repositoryHelper
     */
    public function __construct(
        RegistryInterface $registry,
        RepositoryHelper $repositoryHelper
    ) {
        parent::__construct($registry, User::class);
        $this->repositoryHelper = $repositoryHelper;
    }

    /**
     * Get the users with the URI given parameters
     *
     * @param array $parameters
     *
     * @return \stdClass
     */
    public function getUsersWithParameters(array $parameters = []): array
    {
        $queryBuilder = $this->createQueryBuilder("user");

        $queryBuilder
            ->select("user")
        ;

        $queryBuilder = $this->repositoryHelper->hydrateQuerybuilderWithParameters($queryBuilder, $parameters);

        return $this->repositoryHelper->getQueryBuilderResult($queryBuilder);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('u')
            ->where('u.something = :value')->setParameter('value', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
