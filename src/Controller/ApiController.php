<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 07/03/2018
 * Time: 23:50
 */

namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function getAction(
        EntityManagerInterface $entityManager
    ) {
        $objects = $entityManager->getRepository(User::class)->findAll();

        $jmsSerializer = $this->get("jms_serializer");
        $data = $jmsSerializer->serialize($objects, "json");

        $response = new Response($data);
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }
}