<?php

namespace UserBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var int
     *
     * @ORM\Column(name="completion_rate", type="integer", nullable=true)
     */
    protected $completion_rate;

    /**
     * @ORM\OneToMany(targetEntity="\UserBundle\Entity\User", mappedBy="user_id")
     *
     */
    private $reclamations;


    public function __construct() {
        parent::__construct();
        $this->reclamations = new ArrayCollection();
    }


    // ...
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}

