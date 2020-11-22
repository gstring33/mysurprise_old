<?php

namespace App\Service;

use App\Entity\ResetPasswordRequest;
use App\Repository\ResetPasswordRequestRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Security;

class UserService
{
    /** @var Security */
    private $security;

    private $user;
    /** @var ResetPasswordRequestRepository */
    private $passwordRequestRepository;
    /** @var EntityManager */
    private $manager;

    /**
     * UserService constructor.
     * @param Security $security
     * @param ResetPasswordRequestRepository $passwordRequestRepository
     * @param EntityManager $manager
     */
    public function __construct(
        Security $security,
        ResetPasswordRequestRepository $passwordRequestRepository,
        EntityManager $manager
    )
    {
        $this->security = $security;
        $this->user = $this->security->getToken()->getUser();
        $this->passwordRequestRepository = $passwordRequestRepository;
        $this->manager = $manager;
    }

    public function hasAlreadySelectedUser()
    {
        return $this->user->getSelectedUser() !== NULL;
    }

    public function removeUserResetTokens()
    {
        $tokens = $this->passwordRequestRepository->findBy(["user" => $this->user]);
        foreach ($tokens as $token) {
            $this->manager->remove($token);
        }
        $this->manager->flush();
    }
}