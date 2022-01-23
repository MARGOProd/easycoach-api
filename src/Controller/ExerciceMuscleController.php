<?php

namespace App\Controller;

use Exception;
use App\Entity\Exercice;
use App\Entity\ExerciceMuscle;
use App\Entity\Muscle;
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
use Symfony\Component\Validator\Constraints\IsNull;

class ExerciceMuscleController extends AbstractController
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
     * 
     * @Route("/api/exercice_muscles/create", name="api_exercice_muscles_create",  methods={"POST"})
     * 
     */
    public function createExerciceMuscles(Request $request, SerializerInterface $serializer)
    {
        try {
            $user = $this->security->getUser();
            $exerciceMuscleRepository = $this->em->getRepository(ExerciceMuscle::class);
            $exerciceRepository = $this->em->getRepository(Exercice::class);
            $muscleRepository = $this->em->getRepository(Muscle::class);
            $content = json_decode($request->getContent(), true);
            if(isset($content["exercice"]) && isset($content["muscle"]))
            {
                $exerciceId = substr($content["exercice"], -1);
                $muscleId = substr($content["muscle"], -1);
                $exerciceMuscles = $exerciceMuscleRepository->findOneBy(['exercice' => $exerciceId, 'muscle' => substr($content["muscle"], -1), 'isDirect' => $content["isDirect"]]);
                if($exerciceMuscles == null)
                {
                    $exercice = $exerciceRepository->find($exerciceId);
                    $muscle = $muscleRepository->find($muscleId);
                    $exerciceMuscle = $this->createExerciceMuscle($exercice, $muscle, $content);
                    $response = new Response($serializer->serialize($exerciceMuscle, 'json'), 201, ['Content-Type' => 'application/json+ld']);

                }else {
                    $response = new JsonResponse(['success' => false, 'message' => ' ExerceMuscle ever exist.'], 422);
                }
            }else {
                $response = new JsonResponse(['success' => false, 'message' => ' Error content body.'], 422);
            }
        } catch (Exception $e) {
            $response = new Response("'message : An error occured'", 500, ['Content-Type' => 'application/json+ld']);
        }
        return $response;
    }

    private function createExerciceMuscle(Exercice $exercice, Muscle $muscle, $value)
    {
        $exerciceMuscle = new ExerciceMuscle();
        $exerciceMuscle->setExercice($exercice);
        $exerciceMuscle->setMuscle($muscle);
        $exerciceMuscle->setIsDirect($value['isDirect']);
        $this->em->persist($exerciceMuscle);
        $this->em->flush();
        return $exerciceMuscle;
    }

}
