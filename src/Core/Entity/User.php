<?php

namespace App\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToArrayTransformer;

/**
 * Class User
 * @package App\Core\Entity
 * @ORM\Entity(repositoryClass="App\Core\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->firstname = "";
        $this->lastname = "";
    }

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string")
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string")
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * Getter for the "id" property.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter for the "firstname" property.
     *
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Setter for the "firstname" property.
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Getter for the "lastname" property.
     *
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Setter for the "lastname" property.
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname(string $lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Getter for the "createdAt" property.
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * Setter for the "createdAt" property.
     *
     * @param \DateTime $createdAt
     *
     * @ORM\PrePersist()
     *
     * @return User
     */
    public function setCreatedAt(): User
    {
        $this->createdAt = new \DateTime();
        return $this;
    }

    /**
     * Getter for the "updatedAt" property.
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Setter for the "updatedAt" property.
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
     * @return User
     */
    public function setUpdatedAt(): User
    {
        $this->updatedAt = new \DateTime();
        return $this;
    }
}
