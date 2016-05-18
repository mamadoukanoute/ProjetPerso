<?php

namespace Plateforme\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Basket
 *
 * @ORM\Table(name="Basket")
 * @ORM\Entity(repositoryClass="Plateforme\ProductBundle\Repository\BasketRepository")
 */
class Basket
{

    /**
     * @var int
     *
     * @ORM\Column(name="pid", type="integer", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pid;

    /**
     * @var int
     *
     * @ORM\Column(name="prodid", type="integer",)
     */
    private $prodid;

    /**
     * @var int
     *
     * @ORM\Column(name="userid", type="integer")
     */
    private $userid;

    /**
     * @var int
     *
     * @ORM\Column(name="qte", type="integer")
     */
    private $qte;
    public $name;




   /* public function __construct($name)
    {
        $this->name=$name;
    }*/




    /**
     * Get pid
     *
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set prodid
     *
     * @param integer $prodid
     *
     * @return Basket
     */
    public function setProdid($prodid)
    {
        $this->prodid = $prodid;

        return $this;
    }

    /**
     * Get prodid
     *
     * @return int
     */
    public function getProdid()
    {
        return $this->prodid;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     *
     * @return Basket
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set qte
     *
     * @param integer $qte
     *
     * @return Basket
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return int
     */
    public function getQte()
    {
        return $this->qte;
    }


 public function getName()
    {
        return $this->name;
    }
     
    public function setName($name)
    {
        $this->name = $name;
     
        return $this;
    }



}

