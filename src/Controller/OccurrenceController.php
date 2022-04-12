<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\Occurrence;
use App\Entity\Serie;
use App\Entity\SerieExercice;
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

class OccurrenceController extends AbstractController
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
     * Get Serie Exercice Occurrence
     * 
     * @Route("/api/occurrences/serie_exercices", name="api_series_serie_exercices"), methods={"GET"})
     * 
     */
    public function getSerieExercicesOccurrences(Request $request,  SerializerInterface $serializer)
    {
        $serieExerciceRepository = $this->em->getRepository(SerieExercice::class);
        $exerciceRealiseRepository = $this->em->getRepository(ExerciceRealise::class);
        if(isset($_GET["serie"]) && isset($_GET["occurrence"]))
        {
            $exerciceRealises = $exerciceRealiseRepository->findBy(['serie' => $_GET["serie"], 'occurrence' => $_GET["occurrence"]]);
            $serieExercices = $serieExerciceRepository->findBy(['serie' => $_GET["serie"]]);
            foreach ($serieExercices as &$value) {
                $objects = array_filter(
                    $exerciceRealises,
                    function ($e) use (&$value) {
                        return $e->getSerieExercice()->getId() == $value->getId();
                    }
                );
                if(!empty($objects))
                {
                    foreach ($objects as &$value) {
                        if(($key = array_search($value->getSerieExercice(), $serieExercices)) !== FALSE) {
                            unset($serieExercices[$key]);
                        }
                    }
                }
            }
            $response = new Response($serializer->serialize($serieExercices, 'json'), 200, ['Content-Type' => 'application/json+ld']);
        }else{
            $response = new Response("'message : Serie Id ou Occurrence Id manquante'", 500, ['Content-Type' => 'application/json+ld']);
        }
      
        return $response;
    }

     /**
     * Get Exercice Realise Occurrence
     * 
     * @Route("/api/occurrences/exercice_realises", name="api_series_exercice_realises"), methods={"GET"})
     * 
     */
    public function getExerciceRealisesOccurrences(Request $request,  SerializerInterface $serializer)
    {
        $exerciceRealiseRepository = $this->em->getRepository(ExerciceRealise::class);
        if(isset($_GET["serie"]) && isset($_GET["occurrence"]))
        {
            $exerciceRealises = $exerciceRealiseRepository->findBy(['serie' => $_GET["serie"], 'occurrence' => $_GET["occurrence"]]);
            $response = new Response($serializer->serialize($exerciceRealises, 'json'), 200, ['Content-Type' => 'application/json+ld']);
        }else{
            $response = new Response("'message : Serie Id ou Occurrence Id manquante'", 500, ['Content-Type' => 'application/json+ld']);
        }
      
        return $response;
    }
}