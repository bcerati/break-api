<?php

namespace App\Controller;

use DateTime;
use App\Entity\Breaks;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityRepository;

class DailyManagerController extends AbstractController
{
    /**
     * @Route(
     * 
     *          name="tempstotalmanager",
     *          path="/api/tempstotalmanager",
     * 
     * )
     */
    public function __invoke():object
    {
        if (!$this->isGranted('ROLE_MANAGER')) {
            throw new JsonResponse([], 403)
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entities = $entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->addSelect('b')
            ->leftJoin('u.breaks','b')
        ->where('DAY(b.date_debut) = DAY(NOW())')
        ->andwhere('MONTH(b.date_debut) = MONTH(NOW())')
        ->andwhere('YEAR(b.date_debut) = YEAR(NOW())')
        ->getQuery()
        ->getArrayResult();

        return new Jsonresponse($entities);   
    }
}
