<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\Etude;
use App\Entity\Device;
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

class AccountController extends AbstractController
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
            $device->setDeviceKey($content['deviceKey']);
            $device->setUser($user);
            $this->em->persist($device);
            $this->em->flush();
            $this->em->refresh($device->getUser());
            $response = new Response($serializer->serialize($user, 'json', ['groups' => 'user:get']), 200, ['Content-Type' => 'application/json+ld']);
        } else {
            $response = new Response("'Error : User or Device Exist / user unhautorize...'", 500, ['Content-Type' => 'application/json+ld']);
        }
        return $response;

    }


    /**
     * Enregistrement du compte depuis un device
     * @Route("/api/account/register/device", name="api_account_register_device", methods={"POST"})
     * 
     */
    public function registerFromDevice(Request $request, SerializerInterface $serializer)
    {
        try {
            $user = $this->security->getUser();
            $userRepository = $this->em->getRepository(User::class);
            $marqueRepository = $this->em->getRepository(Marque::class);
            $deviceRepository = $this->em->getRepository(Device::class);
            $content = json_decode($request->getContent(), true);
            $params_condition = isset($content["deviceKey"]) && isset($content["marque"]) && isset($content['nom']) && isset($content['prenom']) && isset($content['email']) && isset($content['password']);
            if ($params_condition) {
                if (isset($content["marque"]))
                {
                    $marqueId = substr($content["marque"], -1);
                    $marque = $marqueRepository->findOneBy(['id' => $marqueId]);
                    if($marque != null)
                    {
                        // check if user exist (2 conditions email et device key n'existe pas dans table user)
                        $user = $userRepository->findOneBy(array('email' => $content['deviceKey']));
                        if($user == null)
                        {
                            $user = $userRepository->findOneBy(array('email' => $content['email']));
                        }
                        if($user == null )
                        {
                            // check if device Exist
                            $device = $deviceRepository->findOneBy(array('deviceKey' => $content['deviceKey']));
                            if($device == null )
                            {
                                // Création du User
                                $user = new User();
                                $user->setNom($content['nom']);
                                $user->setPrenom($content['prenom']);
                                $user->setEmail($content['email']);
                                $user->setMarque($marque);
                                $password = $this->encoder->encodePassword($user, $content['password']);
                                $user->setPassword($password);
                                $this->em->persist($user);
                                $this->em->flush();
                                $user = $userRepository->findOneBy(array('email' => $content['email']));
                            
                                // Creation du Device
                                $device = new Device();
                                $device->setDeviceKey($content['deviceKey']);
                                $device->setUser($user);
                                $this->em->persist($device);
                                $this->em->flush();
                                $this->em->refresh($device->setUser($user));
                                $device = $deviceRepository->findOneBy(array('deviceKey' => $content['deviceKey']));
                                $response = new Response($serializer->serialize($user, 'json'), 201, ['Content-Type' => 'application/json+ld']);
                            }else{
                                $response = new JsonResponse(['success' => false, 'message' => 'Ce téléphone est déjà associé à un compte'], 422);
                            }  
                        }else{
                            $response = new JsonResponse(['success' => false, 'message' => "Cet utilisateur existe déjà"], 500);
                        }
                    }else{
                        $response = new JsonResponse(['success' => false, 'message' => "Erreur d'association du user à la marque"], 500);
                    }     
                }else{
                    $response = new JsonResponse(['success' => false, 'message' => 'Attribut marque manquant'], 500);
                }
            } else {
                $response = new JsonResponse(['success' => false, 'message' => '1 ou plusieurs attributs sont manquants et empêchent la création du user.'], 422);
            }
        } catch (UniqueConstraintViolationException $e) {
            $response = new JsonResponse(['success' => false, 'message' => 'Cet email existe déjà.'], 409);
        }
        return $response;
    }

    /**
     * Login depuis un device
     * @Route("/api/account/login/device", name="api_account_login_device", methods={"POST"})
     */
    public function loginFromDevice(Request $request, SerializerInterface $serializer, UserPasswordEncoderInterface $encoder)
    {
        try {
            $user = $this->security->getUser();
            $userRepository = $this->em->getRepository(User::class);
            $deviceRepository = $this->em->getRepository(Device::class);
            $content = json_decode($request->getContent(), true);
            $params_condition = isset($content["email"]) && isset($content["password"]) && isset($content['deviceKey']);
            if ($params_condition) {
                // check if user exist 
                $user = $userRepository->findOneBy(array('email' => $content['email']));
                // check if device Exist
                if($user != null )
                {
                    // check if password correspond
                    if($encoder->isPasswordValid($user, $content["password"]))
                    {
                        // check if Device exist
                        $device = $deviceRepository->findOneBy(array('deviceKey' => $content['deviceKey']));
                        // s'il n'héxiste pas on l'assigne en vérifiant selon sa licence ou la valeur par défaut(fonction assign)
                        if($device == null)
                        {
                            $reponseAssign = $this->assign($request, $user);
                            $content =  json_decode($reponseAssign->getContent(), true);
                            if($content["statusCode"] == 201)
                            {
                                $response = new Response($serializer->serialize($user, 'json'), 200, ['Content-Type' => 'application/json+ld']);
                            }else{
                                $response = new JsonResponse(['success' => false, 'message' => $content["message"]], 500);
                            }
                        }else{
                            // Si device exist on check si device est associé à ce user
                            if($user->getId() == $device->getUser()->getId())
                            {
                                $response = new Response($serializer->serialize($user, 'json'), 200, ['Content-Type' => 'application/json+ld']);
                            }else{
                                // si non on réassign le device à l'utilisateur
                                $device->setUser($user);
                                $this->em->persist($device);
                                $this->em->flush();
                                $this->em->refresh($device->setUser($user));
                                if($user->getId() == $device->getUser()->getId())
                                {
                                    $response = new Response($serializer->serialize($user, 'json'), 200, ['Content-Type' => 'application/json+ld']);
                                }else{
                                    $response = new JsonResponse(['success' => false, 'message' => "ToDo re-assign device"], 500);
                                }
                            }
                        }
                    }else{
                        $response = new JsonResponse(['success' => false, 'message' => "Le mot de passe ne correspond pas"], 500);
                    }  
                }else{
                    $response = new JsonResponse(['success' => false, 'message' => "Aucun compte associé à cet email"], 500);
                }
            } else {
                $response = new JsonResponse(['success' => false, 'message' => '1 ou plusieurs attributs sont manquants.'], 422);
            }
        } catch (UniqueConstraintViolationException $e) {
            $response = new JsonResponse(['success' => false, 'message' => 'Cet email existe déjà.'], 409);
        }
        return $response;
    }


    /**
     * Assignation d'un device à un compte
     * @Route("/api/account/assign", name="api_account_assign", methods={"POST"})
     */
    public function assign(Request $request, User $user = null)
    {
        if($user == null)
        {
            $user = $this->security->getUser();
        }
        $deviceRepository = $this->em->getRepository(Device::class);
        $userRepository = $this->em->getRepository(User::class);
        $content = json_decode($request->getContent(), true);
        $device = $deviceRepository->findOneBy(['deviceKey' => $content['deviceKey']]);
        $userForDevice = $userRepository->findOneBy(['email' => $content['email']]);
        if ($this->encoder->isPasswordValid($userForDevice, $content['password'])) {
            // TODO LICENCE
            if (count($user->getDevices()) < 1000) {
                if ($device == null) {
                    $device = new Device();
                    $device->setDeviceKey($content['deviceKey']);
                }
                $device->setUser($userForDevice);
                $this->em->persist($device);
                $this->em->flush();
                $response = ['success' => true, 'message' => 'Device Registered for User ' . $content['email'], 'statusCode' => 201];
            } else {
                $response = ['success' => false, 'message' =>  "Vous avez atteint le limite d'appareils pour ce compte : " . $content['email'], 'statusCode' => 402];
            }
        } else {
            $response = ['success' => false, 'message' => 'User not found or incorrect password', 'statusCode' => 401];
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
                    new Response($serializer->serialize($user, 'json'), 200, ['Content-Type' => 'application/json+ld']);
            }
    }
}
