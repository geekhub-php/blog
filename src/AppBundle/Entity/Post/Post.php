<?php

namespace AppBundle\Entity\Post;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post.
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 */
class Post
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var string
    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="hashtag", type="string", length=100)
     */
    private $hashtag;

    /**
     * @var string
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User\User", inversedBy="posts")
     */
    private $authors;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category\Category")
     */
    private $category;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * @var string
     *
     * @ORM\Column(name="dataCreate", type="string", length=10)
     */
    private $dataCreate;

    /**
     * @var string
     *
     * @ORM\Column(name="enabled", type="string", length=10)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="dataEdit", type="string", length=10)
     */
    private $dataEdit;

    public function __construct()
    {
        $this->authors = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Post
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set body.
     *
     * @param string $body
     *
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set hashtag.
     *
     * @param string $hashtag
     *
     * @return Post
     */
    public function setHashtag($hashtag)
    {
        $this->hashtag = $hashtag;

        return $this;
    }

    /**
     * Get hashtag.
     *
     * @return string
     */
    public function getHashtag()
    {
        return $this->hashtag;
    }

    /**
     * Set authors.
     *
     * @param string $authors
     *
     * @return Post
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;

        return $this;
    }

    /**
     * Get authors.
     *
     * @return string
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Set category.
     *
     * @param string $category
     *
     * @return Post
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set rating.
     *
     * @param int $rating
     *
     * @return Post
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating.
     *
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set dataCreate.
     *
     * @param string $dataCreate
     *
     * @return Post
     */
    public function setDataCreate($dataCreate)
    {
        $this->dataCreate = $dataCreate;

        return $this;
    }

    /**
     * Get dataCreate.
     *
     * @return string
     */
    public function getDataCreate()
    {
        return $this->dataCreate;
    }

    /**
     * Set enabled.
     *
     * @param string $enabled
     *
     * @return Post
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return string
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set dataEdit.
     *
     * @param string $dataEdit
     *
     * @return Post
     */
    public function setDataEdit($dataEdit)
    {
        $this->dataEdit = $dataEdit;

        return $this;
    }

    /**
     * Get dataEdit.
     *
     * @return string
     */
    public function getDataEdit()
    {
        return $this->dataEdit;
    }

    /**
     * Add author.
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return Post
     */
    public function addAuthor(\AppBundle\Entity\User\User $author)
    {
        $this->authors[] = $author;

        return $this;
    }

    /**
     * Remove author.
     *
     * @param \AppBundle\Entity\User $author
     */
    public function removeAuthor(\AppBundle\Entity\User\User $author)
    {
        $this->authors->removeElement($author);
    }
}
