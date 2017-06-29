<?php
/**
 * Created by PhpStorm.
 * User: rlbaltha
 * Date: 6/21/17
 * Time: 3:30 PM
 */

namespace AppBundle\Notifier;

use AppBundle\Entity\Notification;
use AppBundle\Entity\Post;


class NotifierManager
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }
    public function createNotifier($date, $user, $post)
    {
        $startdate = clone $date;
        $startdate->sub(new \DateInterval('P7D'));
        $notification = new Notification();
        $notification->setBody($post);
        $notification->setStatus('New');
        $notification->setUser($user);
        $notification->setDate($date);
        $notification->setDisplayEnd($date);
        $notification->setDisplayStart($startdate);

        $this->em->persist($notification);
        $this->em->flush();


        return $notification;
    }

}