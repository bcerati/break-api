<?php

namespace App\Controller;

use DateTime;
use App\Entity\Breaks;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityRepository;

class TempsController extends AbstractController
{
    /**
     * @Route(
     * 
     *          name="tempstotal",
     *          path="/api/tempstotal",
     * 
     * )
     */
    public function __invoke():object
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $entities = $entityManager->getRepository(Breaks::class)->createQueryBuilder('o')
        ->select('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(o.date_fin,o.date_debut))))')
        ->where('DAY(o.date_debut)>DAY(NOW())-5')
        ->andwhere('MONTH(o.date_debut)=MONTH(NOW())')
        ->andwhere('YEAR(o.date_debut)=YEAR(NOW())')
        ->andwhere('o.user=?1')
        ->andwhere('o.date_fin > 0')
        ->setParameter(1,$user)
        ->getQuery()
        ->getArrayResult();
        return new Jsonresponse($entities);   
    }

}
