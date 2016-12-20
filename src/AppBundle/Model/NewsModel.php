<?php

namespace AppBundle\Model;

use AppBundle\Entity\Category;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewsModel
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
        $repository = $this->em->getRepository('AppBundle:News');
        $data = $repository->find($id);
        $this->em->remove($data);
        $this->em->flush();
    }

    public function showAllRecords()
    {
        $repository = $this->em->getRepository('AppBundle:News');
        $data = $repository->findAll();

        return $data;
    }

    public function showRecord($id)
    {

    }

    public function editRecord($id)
    {

    }

}
