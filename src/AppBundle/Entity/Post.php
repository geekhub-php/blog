<?php

namespace AppBundle\Entity;

class Post
{
    private $id;

    private $title;

    private $text;

    private $author;

    private $postedOnDate;

    public function getId()
    {
        return $this->id;
    }
    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * Set text.
     *
     * @param string $text
     *
     * @return Post
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
    /**
     * Get text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
    /**
     * Set author.
     *
     * @param string $author
     *
     * @return Post
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }
    /**
     * Get author.
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * Set postedOnDate.
     *
     * @param \DateTime $postedOnDate
     *
     * @return Post
     */
    public function setPostedOnDate($postedOnDate)
    {
        $this->postedOnDate = $postedOnDate;

        return $this;
    }
    /**
     * Get postedOnDate.
     *
     * @return \DateTime
     */
    public function getPostedOnDate()
    {
        return $this->postedOnDate;
    }
    /**
     * Constructor.
     *
     * @param int       $id;
     * @param string    $title;
     * @param string    $text;
     * @param string    $author;
     * @param \DateTime $postedOnDate;
     */
    public function __construct($id, $title, $text, $author, $postedOnDate)
    {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
        $this->postedOnDate = $postedOnDate;
    }
}
