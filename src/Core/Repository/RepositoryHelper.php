<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 09/03/2018
 * Time: 23:53
 */

namespace App\Core\Repository;

use App\Core\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class RepositoryHelper
 * @package App\Core\Repository
 */
class RepositoryHelper
{
    /**
     * @var \Symfony\Component\Serializer\Serializer
     */
    private $serializer;

    /**
     * RepositoryHelper constructor.
     */
    public function __construct()
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * Hydrate a query builder with a bunch of parameters and returns the QueryBuilder.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param array                      $parameters
     *
     * @return QueryBuilder
     */
    public function hydrateQuerybuilderWithParameters(
        QueryBuilder $queryBuilder,
        array $parameters
    ) {
        if (count($parameters) > 0) {
            if (isset($parameters["limit"])) {
                $queryBuilder->setMaxResults($parameters["limit"]);
            }

            if (isset($parameters["start"])) {
                $queryBuilder->setFirstResult($parameters["start"]);
            }
        }

        return $queryBuilder;
    }

    public function getQueryBuilderResult(QueryBuilder $queryBuilder)
    {
//        $datas = $queryBuilder->getQuery()->getResult();
//
//        $result = new \stdClass();
//
//        /**
//         * @var User $data
//         */
//        foreach ($datas as $data) {
//            $id = $data->getId();
//            $result->$id = $this->serializer->serialize($data, "json");
//        }
//
//        return $result;

        return $queryBuilder->getQuery()->getResult();
    }
}