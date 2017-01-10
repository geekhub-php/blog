<?php

namespace AppBundle\Entity\Tag;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag.
 *
 * @ORM\Table(name="tag_tag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Tag\TagRepository")
 */
class Tag
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
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Post\Post", mappedBy="tags")
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Get posts.
     *
     * @return array
     */
    public function getPosts()
    {
        return $this->posts;
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
     * @return Tag
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
     * Add post.
     *
     * @param \AppBundle\Entity\Post\Post $post
     *
     * @return Tag
     */
    public function addPost(\AppBundle\Entity\Post\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post.
     *
     * @param \AppBundle\Entity\Post\Post $post
     */
    public function removePost(\AppBundle\Entity\Post\Post $post)
    {
        $this->posts->removeElement($post);
    }
}
