<?php

namespace App\Controller;

use DateTime;
use App\Entity\Breaks;
use App\Entity\User;
use App\Repository\BreaksRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PostBreaksController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var BreaksRepository */
    private $breaksRepository;

    public function __construct(EntityManagerInterface $em, BreaksRepository $breaksRepository)
    {
        $this->em = $em;
        $this->breaksRepository = $breaksRepository;
    }

    /**
     * @Route("/api/breaks", name="post_breaks", methods={"post"})
     */
    public function __invoke():Response
    {
        $user = $this->getUser();

        $breaks = $this->breaksRepository->findTodayBreaksForUser($user);
        if ($breaks) {
            return $this->json([
                'success' => false,
                'message' => 'A breaks already exists for the current user today',
            ], 400);
        }

        $breaks = (new Breaks())->setUser($user);

        $this->em->persist($breaks);
        $this->em->flush();

        return $this->json([
            'success' => true,
            'breaks' => $breaks->toArray(),
        ]);
    }
}
