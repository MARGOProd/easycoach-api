<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\ExerciceRealise;
use App\Security\UserAuthenticator;
use OpenApi\Annotations as OA;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class StatistiquesController extends AbstractController
{
    private $em;
    private $security;
    private $encoder;

    public function __construct(EntityManagerInterface $em, ManagerRegistry $managerRegistry, Security $security, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->security = $security;
        $this->encoder = $encoder;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * Get Statistique 
     * 
     * @Route("/api/statistiques/seance_users", name="api_statistiques_seance_users"), methods={"GET"})
     * 
     */
    public function getStatistiqueSeanceUser(Request $request,  SerializerInterface $serializer){
        $exerciceRealiseRepository = $this->em->getRepository(ExerciceRealise::class);
        $statExercice = [];
        $stat = ["Poids" => 0, "Calories"=> 0, ];
        if(isset($_GET["seanceUser"]))
        {
            $exerciceRealises = $exerciceRealiseRepository->findBy(['seanceUser' => $_GET["seanceUser"]]);
            foreach ($exerciceRealises as &$value) {
                if($value->getPoids() != null)
                {
                    $stat["Poids"] += $value->getPoids();
                }
                if($value->getCalorie() != null){
                    $stat["Calories"] += $value->getCalorie();
                }
            }
            $exercicesListUnique = [];
            $arrayExercice = ["Exercice" => '', "Répétitions" => 0, "Poids" => 0, "Calories" => 0, "Durée" => 0];
            foreach($exerciceRealises  as $exerciceRealise){
                if(!array_key_exists($exerciceRealise->getExercice()->getLibelle(), $exercicesListUnique))
                {
                    $arrayExercice["Exercice"] = $exerciceRealise->getExercice()->getLibelle();
                    $exercicesListUnique[$exerciceRealise->getExercice()->getLibelle()] = $arrayExercice;
                }
            }
            foreach ($exercicesListUnique as $exerciceName) {
                foreach($exerciceRealises  as $exoReal)
                {
                    if($exoReal->getExercice()->getLibelle() == $exerciceName["Exercice"] )
                    {
                        $exercicesListUnique[$exerciceName["Exercice"]]["Répétitions"] += $exoReal->getRepetition();
                        $exercicesListUnique[$exerciceName["Exercice"]]["Poids"] += $exoReal->getPoids();
                        $exercicesListUnique[$exerciceName["Exercice"]]["Calories"] += $exoReal->getCalorie();
                        $exercicesListUnique[$exerciceName["Exercice"]]["Durée"] += $exoReal->getDuree();
                    }
                }
            }
            $stat["Exercices"] = $exercicesListUnique;
            $response = new Response($serializer->serialize($stat, 'json'), 200, ['Content-Type' => 'application/json+ld']);

        }else{
            $response = new Response("'message : seanceUserId manquant", 400, ['Content-Type' => 'application/json+ld']);
        }
      
        return $response;
    }

}