<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;

class ListManager
{

    /** @var UserRepository */
    private $userRepository;
    /** @var LoggerInterface */
    private $logger;

    /**
     * ListManager constructor.
     * @param UserRepository $userRepository
     * @param LoggerInterface $logger
     */
    public function __construct(UserRepository $userRepository, LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    /**
     * @param string $username
     * @return bool
     */
    public function isAllowedToCreateList(string $username): bool
    {
        try {
            $user = $this->userRepository->findOneByUsername($username);
            if($user instanceof User) {
                return $user->getGiftsList() === NULL;
            }
        }catch(\ErrorException $exception) {
            $this->logger->error($exception->getMessage());
            return false;
        }
    }

    /**
     * @param string $username
     * @return bool
     */
    public function isAllowedToManageList(string $username): bool
    {
        try {
            $user = $this->userRepository->findOneByUsername($username);
            if($user instanceof User) {
                return $user->getGiftsList() !== NULL;
            }
        }catch(\ErrorException $exception) {
            $this->logger->error($exception->getMessage());
            return false;
        }
    }
}