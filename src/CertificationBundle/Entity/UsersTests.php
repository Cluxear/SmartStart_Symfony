<?php

namespace CertificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersTests
 *
 * @ORM\Table(name="users_tests")
 * @ORM\Entity(repositoryClass="CertificationBundle\Repository\UsersTestsRepository")
 */
class UsersTests
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
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumn(name="id_test", referencedColumnName="id_test")
     */
    private $test_id;
    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user_id;
    /**
     * @ORM\Column(name="status", type="string", length=100)
     */
    private $status;
    /**
     * @ORM\Column(name="nbr_essai", type="integer")
     */
    private $nbr_essai;

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getNbrEssai()
    {
        return $this->nbr_essai;
    }

    /**
     * @return mixed
     */
    public function getTestId()
    {
        return $this->test_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    public function __construct()
    {
        $this->status = "submitted";
        $this->nbr_essai = 1;
    }
}

