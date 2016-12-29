<?php
/**
 * Entity describe "Post" model.
 * User: texas
 * Date: 12/11/16
 * Time: 10:41 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Post
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Author", inversedBy="posts")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     *
     */
    private $author;

    /**
     * @var integer
     *
     * @ORM\ManyToMany(targetEntity="Category", mappedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $categories;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=180)
     * @Assert\Length(
     *      min = 50,
     *      max = 180,
     *      minMessage = "Post title must be at least {{ limit }} characters long",
     *      maxMessage = "Post title cannot be longer than {{ limit }} characters"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 50,
     *      max = 255,
     *      minMessage = "Description must be at least {{ limit }} characters long",
     *      maxMessage = "Description name cannot be longer than {{ limit }} characters"
     * )
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @Assert\Choice(
     *     choices = { 0, 1 },
     *     message = "Choose a post visibility."
     * )
     */
    private $visibility;

    /**
     * @var date
     *
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $createAt;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="post")
     */
    private $comments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
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
     * @return Post
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set descripton
     *
     * @param string $descripton
     *
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get descripton
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set visibility
     *
     * @param boolean $visibility
     *
     * @return Post
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility
     *
     * @return boolean
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Post
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\Author $author
     *
     * @return Post
     */
    public function setAuthor(\AppBundle\Entity\Author $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Post
     */
    public function addCategory(\AppBundle\Entity\Category $category)
    {
        $this->category[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Category $category
     */
    public function removeCategory(\AppBundle\Entity\Category $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Post
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $comment->setPost($this);
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
