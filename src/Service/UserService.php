<?php

namespace App\Service;

use Symfony\Component\Security\Core\Security;

class UserService
{
    /** @var Security */
    private $security;

    private $user;

    /**
     * UserService constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
        $this->user = $this->security->getToken()->getUser();
    }

    public function hasAlreadySelectedUser()
    {
        return $this->user->getSelectedUser() !== NULL;
    }
}