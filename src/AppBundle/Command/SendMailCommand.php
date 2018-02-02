<?php
/**
 * Created by PhpStorm.
 * User: rlbaltha
 * Date: 1/18/18
 * Time: 3:53 PM
 */
// src/AppBundle/Command/SendMailCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class SendMailCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "app/console")
            ->setName('app:send-mail')

            // the short description shown while running "php app/console list"
            ->setDescription('Send mail')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command sends mail.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // access the container using getContainer()
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $currentCheckpoints = $em->getRepository('AppBundle:Checkpoint')->findCurrentForMail();
        foreach($currentCheckpoints as $c)
        {
            $name = $c->getName();
            $deadline = $c->getDeadline();
            $user = $c->getProject()->getCapstone()->getUser()->getName();
            $text = $user. ', you have a task deadline on '. $deadline->format('m-d-Y h:i A'). '.  Please login and review.';
            $message = \Swift_Message::newInstance()
                ->setSubject('Certificate Timeline Task: '. $name)
                ->setFrom('scdirector@uga.edu')
                ->setTo('ron.balthazor@gmail.com')
                ->setCc('ron.balthazor@gmail.com')
                ->setBody(
                    $this->getContainer()->get('twig')->render(

                        'AppBundle:Email:apply.html.twig',
                        array('name' => $name,
                            'text' => $text)
                    ),
                    'text/html');
            $this->getContainer()->get('mailer')->send($message);
        }


        $output->writeln(count($currentCheckpoints) . " notifications sent!");

    }
}