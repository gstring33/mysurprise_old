<?php

namespace App\DataFixtures;

use App\Entity\TchatRoom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TchatRoomFixtures extends Fixture
{
    const REF_TCHATROOM = "Tchatroom_";

    public function load(ObjectManager $manager)
    {
        for($i=0; $i < UserFixtures::USER_MAX + 1; $i++) {
            $tchatRoom = new TchatRoom();
            $this->addReference(self::REF_TCHATROOM . $i, $tchatRoom);
            $manager->persist($tchatRoom);
        }

        $manager->flush();
    }
}
