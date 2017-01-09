<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Post
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageRepository")
 */
class Page extends PostSuperClass
{
    /**
     * @var Author
     *
     * @ORM\ManyToOne(targetEntity="Author", inversedBy="pages")
     */
    private $author;

    /**
     * Set author
     *
     * @param \AppBundle\Entity\Author $author
     *
     * @return Page
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
}
