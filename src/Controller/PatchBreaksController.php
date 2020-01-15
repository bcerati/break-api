<?php

namespace App\Controller;

use DateTime;
use App\Entity\Breaks;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityRepository;
use App\Repository\BreaksRepository;
use Doctrine\ORM\EntityManagerInterface;

class PatchBreaksController extends AbstractController
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
     * @Route("/api/breaks", name="patch_breaks",methods={"patch"})
     */
    public function __invoke():Response
    {
        $user = $this->getUser();
        $breaks = $this->breaksRepository->findTodayBreaksForUser($user);
        if ($breaks === null)
        {
            return $this->json([
                'success' => false,
                'message' => 'The break doesn\'t exists',
            ], 400);
        }
        $breaks->setDateFin(new \DateTime());
        $this->em->flush();

        return $this->json([
            'success' => true,
            'breaks' => $breaks->toArray(),
        ]);
    }
}
