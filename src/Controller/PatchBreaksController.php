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

class PatchBreaksController extends AbstractController
{
    /**
     * @Route("/api/breaks", name="patch_breaks",methods={"patch"})
     */
    public function __invoke():Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $entities = $entityManager->getRepository(Breaks::class)->createQueryBuilder('o')
        ->where('DAY(o.date_debut)<=DAY(NOW())')
        ->andwhere('MONTH(o.date_debut)<=MONTH(NOW())')
        ->andwhere('YEAR(o.date_debut)<=YEAR(NOW())')
        ->andwhere('o.user=?1')
        ->andwhere('o.date_fin IS NULL')
        ->setParameter(1,$user)
        ->getQuery()
        ->getArrayResult();

        if($entities != null)
        {
            $sql="UPDATE breaks SET date_fin=NOW() WHERE user_id=1 AND date_fin IS NULL";
            $stmt=$entityManager->getConnection()->prepare($sql);
            $result=$stmt->execute();

            $response = new Response();
            $response->setStatusCode(200);
            return $response;
        }
        else
        {
            $response = new Response();
            $response->setStatusCode(500);
            return $response;
        }  
    }
}
