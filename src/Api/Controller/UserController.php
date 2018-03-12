<?php
/**
 * Created by PhpStorm.
 * User: Thomas Merlin
 * Email: thomas.merlin@fidesio.com
 * Date: 09/03/2018
 * Time: 21:33
 */

namespace App\Api\Controller;

use App\Api\Helpers\ResponseBuilder;
use App\Api\Helpers\UriParser;
use App\Core\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class UserController
 * @package App\Api\Controller
 */
class UserController extends Controller
{
    /**
     * [GET Method] Display all the users.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Doctrine\ORM\EntityManagerInterface      $entityManager
     * @param \App\Api\Helpers\UriParser                $uriParser
     * @param \App\Api\Helpers\ResponseBuilder          $responseBuilder
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listAction(
        Request $request,
        EntityManagerInterface $entityManager,
        UriParser $uriParser,
        ResponseBuilder $responseBuilder
    ): Response {
        if ($request->isMethod("GET")) {
            try {
                $uri           = $request->getUri();
                $uriParameters = $uriParser->getUriParameters($uri);

                $data = $entityManager->getRepository(User::class)->getUsersWithParameters($uriParameters);

                return $responseBuilder->createResponseGetMethod($data);
            } catch (\Exception $exception) {
                return $responseBuilder->createErrorResponse(
                    "500",
                    $exception->getMessage()
                );
            }
        } else {
            return $responseBuilder->createErrorResponse(
                "405",
                "Méthode non autorisée. (Méthode(s) autorisé(es) : [ GET ]."
            );
        }
    }

    /**
     * [POST Method] Receive data from the request and create a new user.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Doctrine\ORM\EntityManagerInterface      $entityManager
     * @param \App\Api\Helpers\ResponseBuilder          $responseBuilder
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function newAction(
        Request $request,
        EntityManagerInterface $entityManager,
        ResponseBuilder $responseBuilder
    ): Response {
        if ($request->isMethod("POST")) {
            try {
                $encoders = array(new JsonEncoder());
                $normalizers = array(new ObjectNormalizer());
                $serializer = new Serializer($normalizers, $encoders);

                $rawData = $request->getContent();

                /**
                 * @var User $user
                 */
                $user = $serializer->deserialize(
                    $rawData,
                    User::class,
                    "json"
                );

                $entityManager->persist($user);
                $entityManager->flush();

                return $responseBuilder->createResponsePostMethod();
            } catch (\Exception $exception) {
                return $responseBuilder->createErrorResponse(
                    "500",
                    $exception->getMessage()
                );
            }
        } else {
            return $responseBuilder->createErrorResponse(
                "405",
                "Méthode non autorisée. (Méthode(s) autorisé(es) : [ POST ]."
            );
        }
    }

    /**
     * [GET Method] Display the information for a given user.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Doctrine\ORM\EntityManagerInterface      $entityManager
     * @param \App\Api\Helpers\ResponseBuilder          $responseBuilder
     * @param integer                                   $userId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function showAction(
        Request $request,
        EntityManagerInterface $entityManager,
        ResponseBuilder $responseBuilder,
        int $userId
    ): Response {
        if ($request->isMethod("GET")) {
            try {
                $data = $entityManager->getRepository(User::class)->find($userId);

                return $responseBuilder->createResponseGetMethod($data);
            } catch (\Exception $exception) {
                return $responseBuilder->createErrorResponse(
                    "500",
                    $exception->getMessage()
                );
            }
        } else {
            return $responseBuilder->createErrorResponse(
                "405",
                "Méthode non autorisée. (Méthode(s) autorisé(es) : [ GET ]."
            );
        }
    }

    /**
     * [PUT Method] Edit the information of a given user.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Doctrine\ORM\EntityManagerInterface      $entityManager
     * @param \App\Api\Helpers\ResponseBuilder          $responseBuilder
     * @param integer                                   $userId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function editAction(
        Request $request,
        EntityManagerInterface $entityManager,
        ResponseBuilder $responseBuilder,
        int $userId
    ): Response {
        if ($request->isMethod("PUT")) {
            try {
                $encoders = array(new JsonEncoder());
                $normalizers = array(new ObjectNormalizer());
                $serializer = new Serializer($normalizers, $encoders);

                $initialUserData = $entityManager->getRepository(User::class)->find($userId);

                $rawUserData = $request->getContent();

                /**
                 * @var User $user
                 */
                $newUserData = $serializer->deserialize(
                    $rawUserData,
                    User::class,
                    "json"
                );


                $user = $this->updateUserProperties($initialUserData, $newUserData);

                $entityManager->persist($user);
                $entityManager->flush();

                return $responseBuilder->createResponsePutMethod();
            } catch (\Exception $exception) {
                return $responseBuilder->createErrorResponse(
                    "500",
                    $exception->getMessage()
                );
            }
        } else {
            return $responseBuilder->createErrorResponse(
                "405",
                "Méthode non autorisée. (Méthode(s) autorisé(es) : [ PUT ]."
            );
        }
    }

    /**
     * Update the current user entity with the new user entity datas.
     *
     * @param \App\Core\Entity\User $initialUserData
     * @param object|User $newUserData
     *
     * @return \App\Core\Entity\User
     */
    public function updateUserProperties(
        User $initialUserData,
        $newUserData
    ): User {
        $initialUserData
            ->setFirstname($newUserData->getFirstname())
            ->setLastname($newUserData->getLastname())
        ;

        return $initialUserData;
    }
}
