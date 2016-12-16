<?php

namespace Blog\BlogBundle\Entity;

class BlogEntity
{
    protected $id;

    protected $title;

    protected $author;

    protected $blog;

    protected $comments;

    protected $created;


    public function setID($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getID()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setBlog($blog)
    {
        $this->blog = $blog;

        return $this;
    }

    public function getblog()
    {
    }
}
