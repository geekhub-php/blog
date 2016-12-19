<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * UserData.
 *
 * @ORM\Table(name="user_data")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserDataRepository")
 */
class UserData
{
    use Timestampable;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User object
     *
     * @ORM\OneToOne(targetEntity="UserBloger", inversedBy="information")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=150, nullable=true)
     */
    private $address;

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
     * Set user.
     *
     * @param User object
     *
     * @return UserData
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get userId.
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return UserData
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
     * Set address.
     *
     * @param string $address
     *
     * @return UserData
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
}
