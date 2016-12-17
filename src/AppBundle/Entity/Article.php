<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20)
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * One Article has many Comments
     *
     * @var Comment
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article")
     */
    protected $comments;

    /**
     * Many Articles have One Category
     *
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * Many Articles have Many Authors
     *
     * @var Author
     *
     * @ORM\ManyToMany(targetEntity="Author", inversedBy="articles")
     * @ORM\JoinTable(name="articles_authors")
     */
    private $authors;

    /**
     * Many Articles have Many Tags
     *
     * @var Tag
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="articles")
     * @ORM\JoinTable(name="articles_tags")
     */
    private $tags;



    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->authors = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     *
     * @return article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent($length = null)
    {
        if (false === is_null($length) && $length > 0) {
            return substr($this->content, 0, $length);
        } else {
            return $this->content;
        }
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function getAuthors()
    {
        return $this->authors;
    }

    public function addAuthor(Author $authors)
    {
        if (!$this->authors->contains($authors)) {
            $this->authors[] = $authors;
            $authors->addArticle($this);
        }

        return $this;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function addTag(Tag $tags)
    {
        if (!$this->tags->contains($tags)) {
            $this->tags[] = $tags;
            $tags->addArticle($this);
        }
        return $this;
    }
}
