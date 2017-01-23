<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User.
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @ORM\Column(name="firstName", type="string", length=50)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=50)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=100, unique=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=50)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=100)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=200)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="enabled", type="string", length=10)
     */
    private $enabled;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Role\Role")
     */
    private $role;
    /**
     * @var int
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Post\Post", mappedBy="authors")
     */
    private $posts;
    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Like\Like", mappedBy="user")
     */
    private $likes;

    /**
     * @var string
     *
     * @ORM\Column(name="dataCreate", type="date")
     */
    private $dataCreate;

    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->likes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set login.
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set city.
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * Set address.
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set enabled.
     *
     * @param string $enabled
     *
     * @return User
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
     * Set role.
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }



    /**
     * Set dataCreate.
     *
     * @param string $dataCreate
     *
     * @return User
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
     * Add post.
     *
     * @param \AppBundle\Entity\Post\Post $post
     *
     * @return User
     */
    public function addPost(\AppBundle\Entity\Post\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post.
     *
     * @param \AppBundle\Entity\Post\$post
     */
    public function removePost(\AppBundle\Entity\Post\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }



    /**
     * Add like
     *
     * @param \AppBundle\Entity\Like\Like $like
     *
     * @return User
     */
    public function addLike(\AppBundle\Entity\Like\Like $like)
    {
        $this->likes[] = $like;

        return $this;
    }

    /**
     * Remove like
     *
     * @param \AppBundle\Entity\Like\Like $like
     */
    public function removeLike(\AppBundle\Entity\Like\Like $like)
    {
        $this->likes->removeElement($like);
    }

    /**
     * Get likes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikes()
    {
        return $this->likes;
    }






    public function getUsername()
    {
        return $this->login;
    }

    public function set($login)
    {
        $this->login = $login;

        return $this;
    }

    public function getRoles()
    {
        return array($this->role->getName());
       // return array('ROLE_ADMIN');
    }

    /*public function getPassword()
    {
    }
    */
    public function getSalt()
    {
    }
    public function eraseCredentials()
    {
    }


}
