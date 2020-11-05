<?php

namespace App\EventListener;

use App\Entity\Gift;
use App\Repository\UserRepository;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class ListUnpublisher
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
    public function postRemove (LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if(!$entity instanceof Gift) {
            return;
        }

        $em = $args->getEntityManager();
        $currentGiftList = $entity->getGiftList();
        if(count($currentGiftList->getGifts()) === 0) {
            $currentGiftList->setIsPublished(0);
            $em->persist($currentGiftList);
            $user = $this->security->getUser()->setIsAllowedToSelectUser(0);
            $em->persist($user);
            $em->flush();
        }
    }
}