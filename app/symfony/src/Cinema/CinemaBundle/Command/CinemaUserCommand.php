<?php
namespace Cinema\CinemaBundle\Command;
 
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Cinema\CinemaBundle\Entity\User;
 
class CinemaUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cinema:cinema:users')
            ->setDescription('Add users')
            ->addArgument('username', InputArgument::REQUIRED, 'The username')
            ->addArgument('password', InputArgument::REQUIRED, 'The password')
            ->addArgument('email', InputArgument::REQUIRED, 'The email' )
        ;
    }
 
    public function getContainer()
    {
        parent::getContainer();
    }
    
    public function createUser( $username, $password, $email )
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
 
        $user = new User();
        $user->setUsername($username);
        // encode the password
        $factory = $this->getContainer()->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($encodedPassword);
        $user->setEmail($email);
        $em->persist($user);
        $em->flush();
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $email = $input->getArgument('email');
 
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
 
        $user = new User();
        $user->setUsername($username);
        // encode the password
        $factory = $this->getContainer()->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($encodedPassword);
        $user->setEmail($email);
        $em->persist($user);
        $em->flush();
 
        $output->writeln(sprintf('Added %s user with password %s', $username, $password, $email));
    }
}