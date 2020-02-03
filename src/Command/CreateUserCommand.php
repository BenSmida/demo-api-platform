<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';
    private $entityManager;
    private $encoder;

    public function  __construct(
        string $name = null,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $encoder
    )
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a user')
            ->addArgument('fullname', InputArgument::REQUIRED, 'fullname')
            ->addArgument('email', InputArgument::REQUIRED, 'email')
            ->addArgument('password', InputArgument::REQUIRED, 'password')
            ->addArgument('role', InputArgument::REQUIRED, 'role')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $fullname = $input->getArgument('fullname');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $role = $input->getArgument('role');

        $user = (new User())
            ->setEmail($email)
            ->setFullname($fullname)
            ->setRoles([$role]);
        $user->setPassword($this->encoder->encodePassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('User created successfully');

        return 0;
    }
}
