<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\Etude;
use App\Entity\Device;
use App\Entity\Marque;
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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AccountController extends AbstractController
{
    private $em;
    private $security;
    private $encoder;

    public function __construct(EntityManagerInterface $em, Security $security, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->security = $security;
        $this->encoder = $encoder;
    }

    /**
     * Test de l'appel API
     * 
     * @Route("/api/account/check", name="api_account_check")
     * 
     */
    public function check(Request $request)
    {
        $user = $this->security->getUser();
        return new JsonResponse([
            'success' => true,
            'data' => [
                'email' => $user->getEmail()
            ]
        ]);
    }


    /**
     * Creation d'un compte de démonstration
     * 
     * @Route("/api/account/demo", name="api_account_demo", methods={"POST"})
     * 
     */
    public function demo(Request $request, SerializerInterface $serializer)
    {
        $user = $this->security->getUser();

        $deviceRepository = $this->em->getRepository(Device::class);
        $userRepository = $this->em->getRepository(User::class);
        $marqueRepository = $this->em->getRepository(Marque::class);
        $content = json_decode($request->getContent(), true);
        $device = $deviceRepository->findOneBy(['deviceKey' => $content['deviceKey']]);
        $user = $userRepository->findOneBy(['email' => $content['deviceKey']]);
        $marque = $marqueRepository->findOneBy(['libelle' => 'Cocoach']);
        if ($user == null) {
            // Creation du User de Demo avec UUID
            $user = new User();
            $user->setNom($content['deviceKey']);
            $user->setPrenom($content['deviceKey']);
            $user->setEmail($content['deviceKey']);
            $user->setMarque($marque);
            $password = $this->encoder->encodePassword($user, 'ThisUserDoesntHaveAnyPassword');
            $user->setPassword($password);
            $this->em->persist($user);
            $this->em->flush();
            // Creation du Device
            $device = new Device();
            $device->deviceKey = $content['deviceKey'];
            $device->user = $user;
            $this->em->persist($device);
            $this->em->flush();
            $this->em->refresh($device->user);
            $response = new Response($serializer->serialize($user, 'json', ['groups' => 'user:get']), 200, ['Content-Type' => 'application/json+ld']);
        } else {
            $response = new Response("'Error : User or Device Exist / user unhautorize...'", 500, ['Content-Type' => 'application/json+ld']);
        }
        return $response;
        // return new JsonResponse(
        // );
    }

    /**
     * Creation d'un compte
     * 
     * @Route("/api/account/register", name="api_account_register", methods={"POST"})
     * 
     */
    public function register(Request $request, SerializerInterface $serializer)
    {
        try {
            $user = $this->security->getUser();
            $userRepository = $this->em->getRepository(User::class);
            $content = json_decode($request->getContent(), true);
            $params_condition = isset($content["deviceKey"]) && isset($content["marque"]) && isset($content['nom']) && isset($content['prenom']) && isset($content['email']) && isset($content['password']);
            if ($params_condition) {
                $user = $userRepository->findOneBy(array('email' => $content['deviceKey']));
                if (!is_null($user)) {
                    if (filter_var($content["email"], FILTER_VALIDATE_EMAIL)) {
                        //Creation de la marque
                        $marque = new Marque();
                        $marque->libelle = $content["marque"];
                        $this->em->persist($marque);
                        $this->em->flush();
                        $this->em->refresh($marque);
                        // Update du User
                        $user->setLastname($content['nom']);
                        $user->setFirstname($content['prenom']);
                        $user->setEmail($content['email']);
                        $password = $this->encoder->encodePassword($user, $content['password']);
                        $user->setPassword($password);
                        $user->setMarque($marque);
                        $this->em->persist($user);
                        $this->em->flush();

                        $response = new Response($serializer->serialize($user, 'json', ['groups' => 'user:get']), 201, ['Content-Type' => 'application/json+ld']);
                    } else {
                        $response = new Response("'Error : Email not well formed.'", 422, ['Content-Type' => 'application/json+ld']);
                    }
                } else {
                    $response = new Response("'Error : User or Device doesn't Exist / user unhautorize...'", 500, ['Content-Type' => 'application/json+ld']);
                }
            } else {
                $response = new Response("'Error : Arguments are missing or not well formed.'", 422, ['Content-Type' => 'application/json+ld']);
            }
        } catch (UniqueConstraintViolationException $e) {
            $response = new Response("'Error : This email is already in use.'", 409, ['Content-Type' => 'application/json+ld']);
        } catch (Exception $e) {
            $response = new Response("'Error : An error occured'", 500, ['Content-Type' => 'application/json+ld']);
        }

        return $response;
    }

    /**
     * Assignation d'un device à un compte
     * @Route("/api/account/assign", name="api_account_assign", methods={"POST"})
     */
    public function assign(Request $request)
    {
        $user = $this->security->getUser();
        $deviceRepository = $this->em->getRepository(Device::class);
        $userRepository = $this->em->getRepository(User::class);
        $content = json_decode($request->getContent(), true);
        $device = $deviceRepository->findOneBy(['deviceKey' => $content['deviceKey']]);
        $userForDevice = $userRepository->findOneBy(['email' => $content['email']]);
        if ($this->encoder->isPasswordValid($userForDevice, $content['password'])) {
            // TODO LICENCE
            if (count($user->devices) < 2) {
                if ($device == null) {
                    $device = new Device();
                    $device->deviceKey = $content['deviceKey'];
                }
                $device->user = $userForDevice;
                $this->em->persist($device);
                $this->em->flush();
                $response = ['success' => true, 'message' => 'Device Registered for User ' . $content['email'], 'statusCode' => 201];
            } else {
                $response = ['success' => false, 'message' =>  'User a atteint son nombre limite de devices' . $content['email'], 'statusCode' => 402];
            }
        } else {
            $response = ['success' => false, 'error' => 'User not found or incorrect password', 'statusCode' => 401];
        }
        return new JsonResponse(
            $response,
            $response["statusCode"]
        );
    }

    /**
     * Récupération d'un user depuis son token ou sa deviceKey
     * @Route("/api/account/whoami", name="api_account_whoami", methods={"GET"})
     */
    public function whoAmI(Request $request, JWTTokenManagerInterface $jwtManager, SerializerInterface $serializer)
    {
            $user = $this->security->getUser();
            if (is_null($user)) {
                return
                    new Response("'Error : Invalid Token.'", 401, ['Content-Type' => 'application/json+ld']);
            } else {
                return
                    new Response($serializer->serialize($user, 'json', ['groups' => 'user:get']), 201, ['Content-Type' => 'application/json+ld']);
            }
    }
}
