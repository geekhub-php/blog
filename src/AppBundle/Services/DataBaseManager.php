<?php

namespace AppBundle\Services;

use AppBundle\Entity\Post;
use AppBundle\Entity\PostPoint;
use AppBundle\Entity\User;
use AppBundle\Entity\Coment;

class DataBaseManager
{
    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function save($object, User $user = null, Post $post = null, Coment $coment = null)
    {
        if ($object instanceof Post) {
            $object->setUser($user);
        }
        if ($object instanceof PostPoint) {
            $object->setUser($user);
            $object->setPost($post);
        }
        if ($object instanceof Coment) {
            $object->setUser($user);
            if ($coment !== null) {
                $object->setParentComent($coment);
            } else {
                $object->setPost($post);
            }
        }
        $this->em->persist($object);
        $this->em->flush();
    }

    public function update()
    {
        $this->em->flush();
    }

    public function delete($object)
    {
        $this->em->remove($object);
        $this->em->flush();
    }
}
