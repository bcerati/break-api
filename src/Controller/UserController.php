<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/me", name="user_me", methods={"GET"})
     */
    public function __invoke(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw new UnauthorizedHttpException('Basic');
        }

        return $this->json($user->toArray());
    }
}
