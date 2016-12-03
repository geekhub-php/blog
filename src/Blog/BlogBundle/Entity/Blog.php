<?php

namespace Blog\BlogBundle\Entity;

class Blog
{
    protected $id;

    protected $title;

    protected $author;

    protected $blog;

    protected $comments;

    protected $created;


    public function SetID($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getID()
    {
        return $this->id;
    }

    public function Settitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }


}