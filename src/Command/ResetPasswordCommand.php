<?php

namespace App\Command;

use App\Repository\UserRepository;
use App\Service\Emails\PHPMailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordCommand extends Command
{
    protected static $defaultName = 'app:reset-password';
    /** @var EntityManagerInterface */
    private $mailerService;
    /** @var UserRepository */
    private $userRepository;
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    /**
     * ResetPasswordCommand constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
            ->addArgument('username', InputArgument::REQUIRED, 'Username');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $password = $input->getArgument('password');
        $username = $input->getArgument('username');

        $user = $this->userRepository->findOneBy(['username' => $username]);
        if($user === null) {
            $io->error("No user Found");
        }else {
            $user->setPassword($this->encoder->encodePassword($user, $password));
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        $io->success('The password has been correctly updated');

        return Command::SUCCESS;
    }
}
