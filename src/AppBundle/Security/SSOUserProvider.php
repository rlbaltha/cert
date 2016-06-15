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
    private $tokenGenerator;

    public function __construct(UserManagerInterface $userManager, EntityManager $em)
    {
        parent::__construct($userManager);
        $this->em = $em;
    }

    public function createUser($username, array $roles, array $attributes)
    {
        var_dump($attributes);die;
        $email = $username.'@uga.edu';
        $token = rtrim(strtr(base64_encode($this->getRandomNumber()), '+/', '-_'), '=');
        $password = substr($token, 0, 12);
        $user = new User();
        $user->setUsername($username);
        $user->setUsernameCanonical($username);
        $user->setEmail($email);
        $user->setEmailCanonical($email);
        $user->setEnabled(true);
        $user->setPlainPassword($password);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}