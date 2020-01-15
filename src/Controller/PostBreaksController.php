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

class PostBreaksController extends AbstractController
{
    /**
     * @Route("/api/breaks", name="post_breaks",methods={"post"})
     */
    public function __invoke():Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $entities = $entityManager->getRepository(Breaks::class)->createQueryBuilder('o')
        ->where('DAY(o.date_debut)=DAY(NOW())')
        ->andwhere('MONTH(o.date_debut)=MONTH(NOW())')
        ->andwhere('YEAR(o.date_debut)=YEAR(NOW())')
        ->andwhere('o.user=?1')
        ->andwhere('o.date_fin IS NULL')
        ->setParameter(1,$user)
        ->getQuery()
        ->getArrayResult();

        if($entities != null)
        {
            $sql="UPDATE breaks SET date_fin=NOW() WHERE user_id=$user AND date_fin IS NULL";
            $stmt=$entityManager->getConnection()->prepare($sql);
            $result=$stmt->execute();
        }


        $sql="INSERT INTO breaks (date_debut,user_id) VALUES (NOW(),$user)";
        $stmt=$entityManager->getConnection()->prepare($sql);
        $result=$stmt->execute();

        $entities = $entityManager->getRepository(Breaks::class)->createQueryBuilder('o')
        ->select('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(o.date_fin,o.date_debut))))')
        ->where('DAY(o.date_debut)=DAY(NOW())')
        ->andwhere('MONTH(o.date_debut)=MONTH(NOW())')
        ->andwhere('YEAR(o.date_debut)=YEAR(NOW())')
        ->andwhere('o.user=1')
        ->andwhere('o.date_fin > 0')
        ->getQuery()
        ->getArrayResult();

        return new Jsonresponse($entities);   
    }
}
