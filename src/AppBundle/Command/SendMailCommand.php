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
        $current = $em->getRepository('AppBundle:Notification')->findCurrentShared();
        foreach($current as $c)
        {
            $name = 'Test';
            $text = $c->getBody();
            $message = \Swift_Message::newInstance()
                ->setSubject('Certificate Notification')
                ->setFrom('scdirector@uga.edu')
                ->setTo('ron.balthazor@gmail.com')
                ->setCc('ron.balthazor@gmail.com')
                ->setBody($text);
            $this->getContainer()->get('mailer')->send($message);
        }

        $output->writeln(count($current) . " notifications sent!");

    }
}