<?php

namespace App\EventListener;

use App\Entity\Gift;
use App\Repository\UserRepository;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class ListPublisher
{
    /** @var Security */
    private $security;

    /**
     * ListPublisher constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postPersist (LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if(!$entity instanceof Gift) {
            return;
        }

        $em = $args->getEntityManager();
        $currentGiftList = $entity->getGiftList();
        if(!$currentGiftList->getIsPublished()) {
            $currentGiftList->setIsPublished(1);
            $em->persist($currentGiftList);
        }

        $user =$this->security->getUser();
        if(!$user->getIsAllowedToSelectUser() AND $user->getSelectedUser() === NULL) {
            $user->setIsAllowedToSelectUser(1);
            $em->persist($user);
        }

        $em->flush();
    }
}