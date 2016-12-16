<?php

namespace AppBundle\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Model\Post;

/**
 * Class Page
 * @package AppBundle\Model
 */
class Page
{

    /**
     * @return array
     */
    public function showAll()
    {
        $file = file_get_contents('../src/AppBundle/Resources/file.json');
        $posts = json_decode($file);
        $data_array = [];
        foreach ($posts as $post){
            $obj = new Post();
            $obj->setId($post->id);
            $obj->setThumb($post->thumb);
            $obj->setTitle($post->title);
            $obj->setContent($post->content);
            $obj->setAuthor($post->author);
            $obj->setDateCreated($post->date_created);
            $obj->setDateUpdate($post->date_update);
            $data_array[] = $obj;
        }
        return $data_array;
    }

    /**
     * @param $id
     * @return \AppBundle\Model\Post
     */
    public function showById($id)
    {
        $file = file_get_contents('../src/AppBundle/Resources/file.json');
        $posts = json_decode($file);

        foreach ($posts as $post){
            if ($post->id == $id){
                $obj = new Post();
                $obj->setId($post->id);
                $obj->setThumb($post->thumb);
                $obj->setTitle($post->title);
                $obj->setContent($post->content);
                $obj->setAuthor($post->author);
                $obj->setDateCreated($post->date_created);
                $obj->setDateUpdate($post->date_update);
            }
        }
        return $obj;
    }
}