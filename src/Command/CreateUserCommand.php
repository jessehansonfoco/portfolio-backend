<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

#[AsCommand(
    name: 'webapp:create:user',
    description: 'Create a User',
)]
class CreateUserCommand extends Command
{

    const OPT_EMAIL = 'email';
    const OPT_FIRST_NAME = 'first';
    const OPT_LAST_NAME = 'last';
    const OPT_PASSWORD = 'password';

    public function __construct(
        protected EntityManagerInterface $em,
        protected UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(self::OPT_EMAIL, null, InputOption::VALUE_OPTIONAL, 'Email address');
        $this->addOption(self::OPT_FIRST_NAME, null, InputOption::VALUE_OPTIONAL, 'First name');
        $this->addOption(self::OPT_LAST_NAME, null, InputOption::VALUE_OPTIONAL, 'Last name');
        $this->addOption(self::OPT_PASSWORD, null, InputOption::VALUE_OPTIONAL, 'Password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getOption(self::OPT_EMAIL);
        $firstName = $input->getOption(self::OPT_FIRST_NAME);
        $lastName = $input->getOption(self::OPT_LAST_NAME);
        $plaintextPassword = $input->getOption(self::OPT_PASSWORD);

        if ($email && $firstName && $lastName && $plaintextPassword) {

            $user = new User();
            $user->setEmail($email);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setRoles(['ROLE_ADMIN']);

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $this->em->persist($user);

            $this->em->flush();
            $io->success('Created User.');
            return Command::SUCCESS;
        }

        $helper = $this->getHelper('question');

        $q1 = new Question('Email: ');
        $email = $helper->ask($input, $output, $q1);

        $q2 = new Question('Password: ');
        $plaintextPassword = $helper->ask($input, $output, $q2);

        $q3 = new Question('First name: ');
        $firstName = $helper->ask($input, $output, $q3);

        $q4 = new Question('Last name: ');
        $lastName = $helper->ask($input, $output, $q4);

        $user = new User();
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setRoles(['ROLE_ADMIN']);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $this->em->persist($user);

        $this->em->flush();
        $io->success('Created User.');
        return Command::SUCCESS;
    }
}
