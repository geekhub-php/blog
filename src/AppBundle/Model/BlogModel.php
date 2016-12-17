<?php

namespace AppBundle\Model;

use AppBundle\Entity\Category;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BlogModel
{

    private $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function createRecord($record)
    {

    }

    public function deleteRecord($id)
    {

    }

    public function showAllRecords()
    {
        $repository = $this->em->getRepository('AppBundle:Category');
        $data = $repository->findAll();

        return $data;
    }

    public function showRecord($id)
    {

    }

    public function editRecord($id)
    {

    }

    public function patchRecord($id)
    {

    }
}
