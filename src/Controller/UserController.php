<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 07/03/2018
 * Time: 23:41
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class UserController extends Controller
{

    public function listAction(
        Request $request
    ) {
        $response = $this->forward("App\Controller\ApiController::getAction");

        $jmsSerializer = $this->get("jms_serializer");

        /**
         * @var User[] $users
         */
        $users = $jmsSerializer->deserialize(
            $response->getContent(),
            "array",
            "json"
        );

        dump($response);
        dump($users); die;
    }

    /**
     * Creation of a new user
     *
     * @param \Twig\Environment                            $twig
     * @param \Symfony\Component\Form\FormFactoryInterface $formFactory
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
            $entityManager->persist($user);
            $entityManager->flush();

            $jmsSerializer = $this->get("jms_serializer");
            $data = $jmsSerializer->serialize($request->request->get("user"), "json");

            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
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