<?php

namespace App\EventListener;

use App\Entity\Gift;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ListUnPublisher
{
    /**
     * @param LifecycleEventArgs $args
     */
    public function postRemove (LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if(!$entity instanceof Gift) {
            return;
        }
        $currentGiftList = $entity->getGiftList();
        $totalGifts = count($currentGiftList->getGifts());
        if($totalGifts === 0) {
            $em = $args->getEntityManager();
            $currentGiftList->setIsPublished(0);
            $em->persist($currentGiftList);
            $em->flush();
        }
    }
}