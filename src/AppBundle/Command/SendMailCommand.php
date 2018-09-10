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
            $email = $c->getProject()->getCapstone()->getUser()->getEmail();
            $mentors = $c->getProject()->getCapstone()->getCapstoneMentor();
            $task = $c->getDescription();
            $mentoremail = array();
            foreach($mentors as $m)    {
                $mentoremail[] = $m->getEmail();
            }

            $text = '<p>' .$user. ', you have a task deadline on <strong>'. $deadline->format('m-d-Y h:i A').
                '</strong><p><strong>'.$name.'</strong></p><p>'.$task.'</p>
            <p>Thanks for all your good work! </p> 
            <p>Mentors, please check in on the progress of this capstone. Thanks for mentoring.</p>';
            $message = \Swift_Message::newInstance()
                ->setSubject('Sustainability Capstone Timeline Task: '. $name)
                ->setFrom('scdirector@uga.edu')
                ->setTo($email)
                ->setCc($mentoremail)
                ->setBcc('scdirector@uga.edu')
                ->setBody(
                    $this->getContainer()->get('twig')->render(

                        'AppBundle:Email:apply.html.twig',
                        array('name' => $name,
                            'text' => $text)
                    ),
                    'text/html');
            $this->getContainer()->get('mailer')->send($message);
        }

    }
}