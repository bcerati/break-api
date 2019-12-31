<?php

namespace App\Controller;

use DateTime;
use App\Entity\Breaks;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityRepository;

class PostBreaksController extends AbstractController
{
    /**
     * @Route("/api/breaks", name="post_breaks",methods={"post"})
     */
    public function __invoke():object
    {
        $entityManager = $this->getDoctrine()->getManager();
        $sql="INSERT INTO breaks (date_debut,utilisateur_id) VALUES (NOW(),1)";
        $stmt=$entityManager->getConnection()->prepare($sql);
        $result=$stmt->execute();

        $entities = $entityManager->getRepository(Breaks::class)->createQueryBuilder('o')
        ->select('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(o.date_fin,o.date_debut))))')
        ->where('DAY(o.date_debut)=DAY(NOW())')
        ->andwhere('MONTH(o.date_debut)=MONTH(NOW())')
        ->andwhere('YEAR(o.date_debut)=YEAR(NOW())')
        ->andwhere('o.utilisateur=1')
        ->andwhere('o.date_fin > 0')
        ->getQuery()
        ->getArrayResult();
        return new Jsonresponse($entities);   
    }
}
