<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use BeSimple\SsoAuthBundle\Security\Core\User\UserFactoryInterface;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Security\UserProvider;

class SSOUserProvider extends UserProvider implements UserFactoryInterface
{
    private $em;

    public function __construct(UserManagerInterface $userManager, EntityManager $em)
    {
        parent::__construct($userManager);
        $this->em = $em;
    }

    public function createUser($username, array $roles, array $attributes)
    {
        $user = new User();
        $user->setUsername($username);
        // probably set some other fields, and maybe roles!

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}