<?php

namespace Nima\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Nima\BlogBundle\ModelNima;

class NimaController extends Controller
{
    /**
     * @Route("/", name="welcome")
     */
    public function indexAction()
    {

        //$data= array('text1' => 'first', 'text2' => 'second');
         $dataOptions=new ModelNima();
        //$dataOptions->getRevuePosts();
        $nameCategories="all";
        return $this->render('NimaBlogBundle:Default:index.html.twig', array('data' => $dataOptions->getRevuePosts($nameCategories),
            'categories' =>$dataOptions->getCategories(),'nameCategories'=>"last posts"));
    }

    /**
     *@Route("/post/{id}", requirements={"id" = "\d+"}, defaults={"id" =0}, name="postPage")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showPostAction($id)
    {
        $dataOptions=new ModelNima();
      $id="1";

        return $this->render('NimaBlogBundle:Default:showPost.html.twig', array('data' => $dataOptions->getSelectedPost($id),
            'categories' =>$dataOptions->getCategories()));
    }

    /**
     *@Route("/most_read", name="mostRead")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showMostReadAction()
    {

        $dataOptions=new ModelNima();
        return $this->render('NimaBlogBundle:Default:mostRead.html.twig', array('data' => $dataOptions->getRevuePosts("most_read"),
            'categories' =>$dataOptions->getCategories(),'nameCategories'=>"most read categories"));
    }
    /**
     *@Route("/most_commented", name="most_commented")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showMostCommentedAction()
    {

        $dataOptions=new ModelNima();
        return $this->render('NimaBlogBundle:Default:mostRead.html.twig', array('data' => $dataOptions->getRevuePosts("most_commented"),
            'categories' =>$dataOptions->getCategories(),'nameCategories'=>"most commented caegories"));
    }
    /**
     *@Route("/categories/{id}", requirements={"id" = "\d+"}, defaults={"id" =0}, name="categories")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showSelectedCategoriesAction($id)
    {

        //$data= array('text1' => 'first', 'text2' => 'second');
        $dataOptions=new ModelNima();
        //$dataOptions->getRevuePosts();
        $nameCategories="all";
        return $this->render('NimaBlogBundle:Default:index.html.twig', array('data' => $dataOptions->getRevuePosts($nameCategories),
            'categories' =>$dataOptions->getCategories(),'nameCategories'=>"name cat. to dataBase"));
    }

    /**
     *@Route("/contacts", name="contacts")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showContactsAction()
    {
        return $this->render('NimaBlogBundle:Default:contacts.html.twig');
    }
}
