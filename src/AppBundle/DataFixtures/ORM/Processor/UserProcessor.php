<?php
namespace AppBundle\DataFixtures\Processor;

use Nelmio\Alice\ProcessorInterface;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserProcessor implements ProcessorInterface
{
    protected $encoder;

    public function __construct(UserPasswordEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function preProcess($object)
    {
        if (!$object instanceof User) {
            return;
        }

        $password = $this->encoder->encodePassword($object, $object->getPassword());
        $object->setPassword($password);
    }

    public function postProcess($object)
    {

    }
}
