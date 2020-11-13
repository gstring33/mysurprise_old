<?php

namespace App\Command;

use App\DataFixtures\GiftListFixtures;
use App\Entity\GiftsList;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserAdminCreateCommand extends Command
{
    protected static $defaultName = 'app:user-admin-create';
    /**@var EntityManager */
    private $em;

    /**
     * UserAdminCreateCommand constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setDescription('Create a user Admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $list = new GiftsList();
        $list->setIsPublished(0);
        $this->addReference(self::REF_GIFT_LIST . $i, $list);
        $this->em->persist($list);

        $super_admin = new User();
        $firstname = 'Martin';
        $lastname = 'Dhenu';
        $super_admin->setFirstname($firstname)
            ->setLastname($lastname)
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setIsSelected(false)
            ->setPassword($this->encoder->encodePassword($super_admin, '12345'))
            ->setUsername(lcfirst($firstname) . '.' . lcfirst($lastname))
            ->setGiftsList($list)
            ->setIsAllowedToSelectUser(0)
            ->setHash(md5("Martin.Dhenu"))
            ->setImage("/build/images/martin.png");

        $this->em->persist($super_admin);

        $this->em->flush();

        $io->success($firstname . ' ' . $lastname . ' has been successfully created');

        return Command::SUCCESS;
    }
}
