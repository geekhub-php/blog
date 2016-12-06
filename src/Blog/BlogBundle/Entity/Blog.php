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

    public function SetTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function SetBlog($blog)
    {
        $this->blog = $blog;

        return $this;
    }

    public function getblog()
    {
    }
}
