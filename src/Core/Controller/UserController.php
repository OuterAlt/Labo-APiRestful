<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 07/03/2018
 * Time: 23:41
 */

namespace App\Core\Controller;


use App\Core\Entity\User;
use App\Core\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class UserController
 * @package App\Core\Controller
 */
class UserController extends Controller
{
    const apiBaseUrl = "http://127.0.0.1/api/";

    public function listAction(
        Request $request
    ) {
        $guzzleClient = new Client(
            array(
                "base_uri" => self::apiBaseUrl
            )
        );

        $users = $guzzleClient->get("utilisateurs");

        dump($users); die;
    }

    /**
     * Create a new user
     *
     * @param \Twig\Environment                            $twig
     * @param \Symfony\Component\Form\FormFactoryInterface $formFactory
     * @param \Doctrine\ORM\EntityManagerInterface         $entityManager
     * @param \Symfony\Component\HttpFoundation\Request    $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function newAction(
        Environment $twig,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        Request $request
    ) {
        $user = new User();

        $form = $formFactory->create(
            UserType::class,
            $user
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $guzzleClient = new Client(
                array(
                    "base_uri" => self::apiBaseUrl
                )
            );

            $jmsSerializer = $this->get("jms_serializer");

            $response = $guzzleClient->post("utilisateurs", [
                'debug' => false,
                'body' => $jmsSerializer->serialize($user, "json"),
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);

            dump($response); die;
        }

        return new Response(
            $twig->render(
                "user/new.html.twig",
                array(
                    "form" => $form->createView()
                )
            )
        );
    }

}