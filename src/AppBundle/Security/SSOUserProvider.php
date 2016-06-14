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
        $email = $username.'@uga.edu';
        $user = new User();
        $user->setUsername($username);
        $user->setUsernameCanonical($username);
        $user->setEmail($email);
        $user->setEmailCanonical($email);
        $user->setEnabled(true);
        $user->setPlainPassword('test123456');
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}