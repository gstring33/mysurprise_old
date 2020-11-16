<?php

namespace App\Command;

use App\Entity\GiftsList;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserTestCreateCommand extends Command
{
    protected static $defaultName = 'app:create-user-test';
    /**@var EntityManagerInterface */
    private $em;
    /**@var UserPasswordEncoderInterface */
    private $encoder;

    /**
     * UserAdminCreateCommand constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct();
        $this->em = $em;
        $this->encoder = $encoder;
    }

    protected function configure()
    {
        $this->setName('app:create-user-admin')
            ->setDescription('Create a user Admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $list = new GiftsList();
        $list->setIsPublished(0);
        $this->em->persist($list);

        $userTest = new User();
        $firstname = 'Quentin';
        $lastname = 'Tarantino';
        $userTest->setFirstname($firstname)
            ->setLastname($lastname)
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setIsSelected(false)
            ->setPassword($this->encoder->encodePassword($userTest, '12345'))
            ->setUsername(lcfirst($firstname) . '.' . lcfirst($lastname))
            ->setGiftsList($list)
            ->setIsAllowedToSelectUser(0)
            ->setHash(md5($firstname . "." . $lastname))
            ->setEmail(lcfirst($firstname) . "." . lcfirst($lastname) ."@gmail.com")
            ->setIsFirstConnection(1)
            ->setImage("/build/images/martin.png");

        $this->em->persist($userTest);

        $this->em->flush();

        $io->success($firstname . ' ' . $lastname . ' has been successfully created');

        return Command::SUCCESS;
    }
}
