<?php

namespace App\EventListener;

use App\Entity\Gift;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ListPublisher
{
    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist (LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if(!$entity instanceof Gift) {
            return;
        }
        $currentGiftList = $entity->getGiftList();
        $em = $args->getEntityManager();
        $currentGiftList->setIsPublished(1);
        $em->persist($currentGiftList);
        $em->flush();
    }
}