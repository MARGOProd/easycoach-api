<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\Serie;
use App\Entity\ExerciceRealise;
use App\Entity\OccurrenceTime;
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

class SerieController extends AbstractController
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
     * Get Serie 
     * 
     * @Route("/api/series/reset", name="api_series_reset"), methods={"GET"})
     * 
     */
    public function getResetSerie(Request $request,  SerializerInterface $serializer)
    {
        $exerciceRealiseRepository = $this->em->getRepository(ExerciceRealise::class);
        $occurrenceTimeRepository = $this->em->getRepository(OccurrenceTime::class);
        if(isset($_GET["serie"]))
        {
            $exerciceRealises = $exerciceRealiseRepository->findBy(['serie' => $_GET["serie"]]);
            foreach ($exerciceRealises as &$value) {
                $this->em->remove($value);
                $this->em->flush();
            }
            $occurrenceTimes = $occurrenceTimeRepository->findBy(['serie' => $_GET["serie"]]);
            foreach ($occurrenceTimes as &$value) {
                $this->em->remove($value);
                $this->em->flush();
            }
            // $response = new Response("message :Serie reseted", 204, ['Content-Type' => 'application/json+ld']);
            $response = new JsonResponse(['success' => true, 'message' => 'Serie reseted'], 204);

        }else{
            $response = new Response("'message : Serie Id", 500, ['Content-Type' => 'application/json+ld']);
        }
      
        return $response;
    }

}