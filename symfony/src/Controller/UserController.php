<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    public function indexAction(Request $request): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        //dd($users);
        return $this->json($users);
    }
}