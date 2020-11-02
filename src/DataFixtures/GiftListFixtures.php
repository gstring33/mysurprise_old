<?php

namespace App\DataFixtures;

use App\Entity\GiftsList;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GiftListFixtures extends Fixture
{
    const REF_GIFT_LIST = "Giftlist_";

    public function load(ObjectManager $manager)
    {
        for($i=0; $i < 4; $i++) {
            $list = new GiftsList();
            $list->setIsPublished(0);
            $this->addReference(self::REF_GIFT_LIST . $i, $list);
            $manager->persist($list);
        }

        $manager->flush();
    }
}
