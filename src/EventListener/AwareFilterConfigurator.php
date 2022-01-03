<?php
// api/EventListener/UserFilterConfigurator.php

namespace App\EventListener;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Annotations\Reader;

final class AwareFilterConfigurator
{
    private $em;
    private $tokenStorage;
    private $reader;
    private $authorizationChecker;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage, Reader $reader, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->reader = $reader;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onKernelRequest(): void
    {
        if (!$user = $this->getUser()) {
            //throw new \RuntimeException('There is no authenticated user.');
            return;
        }
        if (!$this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
            if(!$this->authorizationChecker->isGranted('ROLE_ADMIN')){
                //It's a user.
                $filter = $this->em->getFilters()->enable('user_filter');
                $filter->setParameter('id', $user->getId());
                $filter->setAnnotationReader($this->reader);
            }else{
                //It's an ADMIN
                if($user->getMarque() != null){
                    //It's a Marque ADMIN
                    $filter = $this->em->getFilters()->enable('marque_filter');
                    $filter->setParameter('id', $user->getMarque()->getId()); //TODO A revoir pour fixer la table
                    $filter->setAnnotationReader($this->reader);
                }else{
                    //The Marque ADMIN do not have a specific filter. The response will handle in another file.
                }
            }
        }
    }

    private function getUser(): ?UserInterface
    {
        if (!$token = $this->tokenStorage->getToken()) {
            return null;
        }

        $user = $token->getUser();
        return $user instanceof UserInterface ? $user : null;
    }
}
