<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
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
                ->setPassword($this->encoder->encodePassword($user, 'geizig12345'))
                ->setUsername(lcfirst($firstname) . "." . lcfirst($lastname));
            $manager->persist($user);
        }

        $super_admin = new User();
        $super_admin->setFirstname('Martin')
            ->setLastname('Dhenu')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setIsSelected(false)
            ->setPassword($this->encoder->encodePassword($super_admin, 'geizig12345'))
            ->setUsername('martin.dhenu');
        $manager->persist($super_admin);

        $manager->flush();
    }
}
