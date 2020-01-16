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
     *          name="tempsmanager",
     *          path="/api/tempstotalmanager",
     * 
     * )
     */
    public function __invoke():object
    {  
        $entityManager = $this->getDoctrine()->getManager();
        $entities = $entityManager->getRepository(Breaks::class)->createQueryBuilder('o')
        ->select('IDENTITY(o.user) as user_id,o.date_debut,o.date_fin')
        ->where('DAY(o.date_debut)=DAY(NOW())')
        ->andwhere('MONTH(o.date_debut)=MONTH(NOW())')
        ->andwhere('YEAR(o.date_debut)=YEAR(NOW())')
        ->andwhere('o.date_fin > 0')
        ->getQuery()
        ->getArrayResult();
        return new Jsonresponse($entities);   
    }

}