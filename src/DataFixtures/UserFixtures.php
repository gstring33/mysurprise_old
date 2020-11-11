<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var Faker\Generator */
    private $faker;
    /** @var UserPasswordEncoderInterface */
    private $encoder;
    const USER_MAX = 3;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->faker = Faker\Factory::create('de_DE');
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for($i=0; $i < self::USER_MAX; $i++) {
            $user = new User();
            $firstname = $this->faker->firstName;
            $lastname = $this->faker->lastName;
            $user->setFirstname($firstname)
                ->setLastname($lastname)
                ->setRoles([])
                ->setIsSelected(false)
                ->setPassword($this->encoder->encodePassword($user, '12345'))
                ->setUsername(lcfirst($firstname) . "." . lcfirst($lastname))
                ->setGiftsList( ($this->getReference(GiftListFixtures::REF_GIFT_LIST . $i)))
                ->setIsAllowedToSelectUser(0)
                ->setHash(md5($firstname . "." . $lastname))
                ->setImage("/build/images/profil-" . $i . ".png");

            $manager->persist($user);
        }

        $super_admin = new User();
        $super_admin->setFirstname('Martin')
            ->setLastname('Dhenu')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setIsSelected(false)
            ->setPassword($this->encoder->encodePassword($super_admin, '12345'))
            ->setUsername('martin.dhenu')
            ->setGiftsList( ($this->getReference(GiftListFixtures::REF_GIFT_LIST . "3")))
            ->setIsAllowedToSelectUser(0)
            ->setHash(md5("Martin.Dhenu"))
            ->setImage("/build/images/profil-4.png");

        $manager->persist($super_admin);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GiftListFixtures::class,
        ];
    }
}
