<?php

namespace App\Controller;

use App\Entity\CommentaireMuscle;
use Exception;
use App\Entity\GroupeMusculaire;
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
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\Validator\Constraints\IsNull;

class GroupeMusculaireController extends AbstractController
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
    // $response = new Response($serializer->serialize($exerciceMuscle, 'json'), 201, ['Content-Type' => 'application/json+ld']);
    // $exerciceMuscles = $exerciceMuscleRepository->findOneBy(['exercice' => $exerciceId, 'muscle' => substr($content["muscle"], -1), 'isDirect' => $content["isDirect"]]);

    /**
     * 
     * @Route("/api/groupe_musclaires/commentaire/selected", name="api_groupe_musclaires_commentaire_selected",  methods={"GET"})
     * 
     */
    public function groupeMusculaireCommentaireSelected(Request $request, SerializerInterface $serializer)
    {
        try {
            $user = $this->security->getUser();
            
            $groupeMuscluaireRepository = $this->em->getRepository(GroupeMusculaire::class);
            $commentaireMuscleRepository = $this->em->getRepository(CommentaireMuscle::class);
            $muscleRepository = $this->em->getRepository(Muscle::class);
            $groupeMusculaires = $groupeMuscluaireRepository->findAll();
            $commentaireId = $_GET['commentaireId'];
            $muscles = $muscleRepository->findAll();
            $groupeMusculaires = array();
            if($commentaireId != null)
            {
                foreach($muscles as $muscle)
                {
                    // si le muscle a des commentaires associés
                    $muscle->setIsSelected(false);
                    if(!empty($muscle->getCommentaireMuscles())){
                        // pour chaque muscle on vérifie si le commentaire est égale à celui passé en params
                        foreach($muscle->getCommentaireMuscles() as $comMuscle){
                            // si oui
                            if ($comMuscle->getCommentaire()->getId() == $commentaireId)
                            {
                                $muscle->setIsSelected(true);
                                // $muscle->setIsSelected(true);
                            }else{
                                $muscle->setIsSelected(false);
                                // $muscle->setIsSelected(false);
                            }

                        }
                    }
                    $groupeMusculaireId = $muscle->getGroupeMusculaire()->getId();
                    // on vérifie si le groupe musculaire fait déjà partie du tableau
                    $gpMusculairesFinded = array_filter(
                        $groupeMusculaires,
                        function ($e) use ($groupeMusculaireId) {
                            return $e['id'] == $groupeMusculaireId;
                            // return $e->getId() == $groupeMusculaireId;
                        }
                    );

                    if(empty($gpMusculairesFinded))
                    {
                        $groupeMusculaireArray = array(
                            '@id'=> 'api/groupe_musculaires/'.$muscle->getGroupeMusculaire()->getId(), 
                            'id' => $muscle->getGroupeMusculaire()->getId(), 
                            "libelle" =>$muscle->getGroupeMusculaire()->getLibelle(), 
                            "muscles" => array(), 
                            "isSelected" => $muscle->getGroupeMusculaire()->getIsSelected()
                        );
                        array_push($groupeMusculaires, $groupeMusculaireArray);
                    }else{
                        array_push($gpMusculairesFinded, $gpMusculairesFinded);

                    }
                    $muscleArray = array(
                        '@id'=> 'api/muscles/'.$muscle->getId(), 
                        'id' => $muscle->getId(), 
                        "libelle" =>$muscle->getLibelle(), 
                        "description" => $muscle->getDescription(), 
                        "isSelected" => $muscle->getIsSelected()
                    );
                    

                    $gpMusculairesFinded = array_filter(
                        $groupeMusculaires,
                        function ($e) use ($groupeMusculaireId) {
                            return $e['id'] == $groupeMusculaireId;
                            // return $e->getId() == $groupeMusculaireId;
                        }
                    );
                    // dump($groupeMusculaires[key($gpMusculairesFinded)]);
                    array_push($groupeMusculaires[key($gpMusculairesFinded)]["muscles"], $muscleArray);
                    // dump($groupeMusculaires[key($gpMusculairesFinded)]);
                    // exit();
                }

            // pour chaque groupe musculaire on vérifie son statu selected
            foreach($groupeMusculaires as $groupeMusculaire)
            {
                $gpMusculairesF= array_filter(
                    $groupeMusculaires,
                    function ($e) use ($groupeMusculaire) {
                        return $e['id'] == $groupeMusculaire['id'];
                        // return $e->getId() == $groupeMusculaireId;
                    }
                );

                $musclesSelected = array();
                $musclesNotSelected = array();
                // dump($groupeMusculaires[key($gpMusculairesF)]);
                foreach ($groupeMusculaires[key($gpMusculairesF)]["muscles"] as $muscle)
                {
                    if($muscle["isSelected"] == true)
                    {
                        array_push($musclesSelected, $muscle);
                    }else{
                        array_push($musclesNotSelected, $muscle);
                    }
                }
                if(empty($musclesSelected))
                {
                    $groupeMusculaires[key($gpMusculairesF)]["isSelected"] = false;
                }else if(empty($musclesNotSelected)){
                    $groupeMusculaires[key($gpMusculairesF)]["isSelected"] = true;
                }
            }
                $response = new Response($serializer->serialize($groupeMusculaires, 'json'), 201, ['Content-Type' => 'application/json+ld']);
            }else{
                $response = new JsonResponse(['success' => false, 'message' => ' commentaireId is mandatory'], 422);
            }
        } catch (Exception $e) {
            $response = new Response("'message : An error occured'", 500, ['Content-Type' => 'application/json+ld']);
        }
        return $response;
    }

}
