<?php
/**
 * Created by PhpStorm.
 * User: Thomas Merlin
 * Email: thomas.merlin@fidesio.com
 * Date: 10/03/2018
 * Time: 00:05
 */
namespace App\Api\Helpers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class ResponseBuilder
 * @package App\Api\Helpers
 */
class ResponseBuilder
{
    const responseJsonHeader = array(
        "Content-Type" => "application/json"
    );

    /**
     * @var \Symfony\Component\Serializer\Serializer $serializer
     */
    private $serializer;

    /**
     * ResponseBuilder constructor.
     */
    public function __construct()
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * Generate a response for a [ GET ] API Call.
     *
     * @param array|object                                              $data
     * @param bool                                                      $success
     * @param string                                                    $status
     * @param string                                                    $errorMessage
     *
     * @return Response
     */
    public function createResponseGetMethod(
        $data,
        bool $success = true,
        string $status = "200",
        string $errorMessage = ""
    ) {
        $response = array(
            "success" => $success,
            "data" => $data,
            "status" => $status,
            "errorMessage" => $errorMessage
        );

        return $this->getResponse($response, $status);
    }

    /**
     * Generate a response for a [ POST ] API Call.
     *
     * @param bool   $success
     * @param string $status
     * @param string $errorMessage
     *
     * @return Response
     */
    public function createResponsePostMethod(
        bool $success = true,
        string $status = "201",
        string $errorMessage = ""
    ): Response {
        $response = array(
            "success" => $success,
            "status" => $status,
            "errorMessage" => $errorMessage
        );

        return $this->getResponse($response, $status);
    }

    /**
     * Generate a response for a [ PUT ] API Call.
     *
     * @param bool   $success
     * @param string $status
     * @param string $errorMessage
     *
     * @return Response
     */
    public function createResponsePutMethod(
        bool $success = true,
        string $status = "201",
        string $errorMessage = ""
    ): Response {
        $response = array(
            "success" => $success,
            "status" => $status,
            "errorMessage" => $errorMessage
        );

        return $this->getResponse($response, $status);
    }

    /**
     * Generate an error response when the request encountered some error.
     *
     * @param bool   $success
     * @param string $status
     * @param string $errorMessage
     *
     * @return Response
     */
    public function createErrorResponse(
        string $status,
        string $errorMessage,
        bool $success = false
    ): Response {
        $response = array(
            "success" => $success,
            "status" => $status,
            "errorMessage" => $errorMessage
        );

        return $this->getResponse($response, $status);
    }

    /**
     * Generate the Response to be sent.
     *
     * @param array  $response
     * @param string $status
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse(
        array $response,
        string $status
    ): Response {
        return new Response(
            $this->serializer->serialize($response, "json"),
            $status,
            self::responseJsonHeader
        );
    }
}