<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\UserMarque;
use App\Entity\Marque;
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

class UserController extends AbstractController
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
     * Get User Marque
     * 
     * @Route("/api/marques/users", name="api_marques_user"), methods={"GET"})
     * 
     */
    public function getUserMarque(Request $request,  SerializerInterface $serializer)
    {
        $user = $this->security->getUser();
        $userRepository = $this->em->getRepository(User::class);
        $marqueRepository = $this->em->getRepository(Marque::class);
        if(count( $user->getUserMarques()) != 0)
        {

            $marque = $marqueRepository->findOneBy(['id' => $user->getUserMarques()[0]->getMarque()->getId()]);
            try {
                $users = $userRepository->findAll();
                $newUsers = array();
                foreach ($users as $us) {
                    if($us->getId() != $user->getId())
                    {
                        $marques = array();
                        foreach($us->getUserMarques() as $userMarque)
                        {
                            array_push($marques ,$userMarque->getMarque());
                        }
                        if(in_array($marque, $marques))
                        {
                            array_push($newUsers, $us);
                        }
                    }
            }
            $response = new Response($serializer->serialize($newUsers, 'json'), 200, ['Content-Type' => 'application/json+ld']);
            } catch (Exception $e) {
                $response = new JsonResponse(['success' => false, 'message' => "Erreur de récupération des utilisateur associé à ce compte"], 500);
            }  
        }else{
            $response = new JsonResponse(['success' => false, 'message' => "Cet utilisateur n'est associé à aucune marque"], 500);
        }   
        return $response;
    }
}