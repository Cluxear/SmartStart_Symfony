<?php

namespace CertificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="CertificationBundle\Repository\TestRepository")
 */
class Test
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_test", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_test;



    /**
     * @var string
     * @ORM\Column(name="titre_test", type="string", length=100)
     */
    private $titre_test;
    /**
     * @var int
     * @ORM\Column(name="passing_score", type="integer")
     */
    private $passing_score;

    /**
     * @var string
     *
     * @ORM\Column(name="questions", type="array")
     */
    private $questions;



    public function __construct() {
        $questions = array();
    }

    // ...

    /**
     * @return mixed
     */
    public function getTitreTest()
    {
        return $this->titre_test;
    }

    /**
     * @param mixed $titre_test
     */
    public function setTitreTest($titre_test)
    {
        $this->titre_test = $titre_test;
    }

    /**
     * @return int
     */
    public function getPassingScore(): int
    {
        return $this->passing_score;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getIdTest()
    {
        return $this->id_test;
    }
}

