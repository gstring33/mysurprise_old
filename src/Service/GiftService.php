<?php

namespace App\Service;

use Doctrine\ORM\PersistentCollection;

class GiftService
{
    public function formatGiftsResults(PersistentCollection $gifts)
    {
        $giftsArray = [];
        if(count($gifts) > 0) {
            foreach ($gifts as $gift) {
                $giftsArray[] = [
                    "id" => $gift->getId(),
                    "title" => $gift->getTitle(),
                    "description" => $gift->getDescription(),
                    "link" => $gift->getLink()
                ];
            }
        }

        return $giftsArray;
    }
}