<?php

namespace App\Controller;

use DateTime;
use App\Entity\Breaks;
use App\Entity\Utilisateur;
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
     *          path="/api/tempstotal/{id}",
     * 
     * )
     */
    public function __invoke($id):object
    {
        $entityManager = $this->getDoctrine()->getManager();

        $date=explode("-",$id);
        $day=$date[0];$month=$date[1];$year=$date[2];
        $date=explode("$",$id);
        $user=$date[1];

        $entities = $entityManager->getRepository(Breaks::class)->createQueryBuilder('o')
        ->select('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(o.date_fin,o.date_debut))))')
        ->where('DAY(o.date_debut)=?1')
        ->andwhere('MONTH(o.date_debut)=?2')
        ->andwhere('YEAR(o.date_debut)=?3')
        ->andwhere('o.id_utilisateur=?4')
        ->andwhere('o.date_fin > 0')
        ->setParameter(1,$day)
        ->setParameter(2,$month)
        ->setParameter(3,$year)
        ->setParameter(4,$user)
        ->getQuery()
        ->getArrayResult();
        return new Jsonresponse($entities);   
    }

}
