<?php

namespace Plateforme\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="Orders")
 * @ORM\Entity(repositoryClass="Plateforme\ProductBundle\Repository\OrdersRepository")
 */
class Orders
{

	/**
	 * @var int
	 *
	 * @ORM\Column(name="cmdid", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $cmdid;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="prodid", type="integer",unique=true)
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


	/**
	 * @var int
	 *
	 * @ORM\Column(name="fournid", type="integer")
	 */
	private $fournid;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="status", type="string", length=255)
	 */
	private $status;


	/**
	 * Get cmdid
	 *
	 * @return int
	 */
	public function getCmdid()
	{
		return $this->cmdid;
	}

	/**
	 * Set userid
	 *
	 * @param integer $userid
	 *
	 * @return Panier
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
	 * @return Panier
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




	/**
	 * Set prodid
	 *
	 * @param integer $prodid
	 *
	 * @return Panier
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
	 * Set fournid
	 *
	 * @param integer $fournid
	 *
	 * @return Orders
	 */
	public function setFournid($fournid)
	{
		$this->fournid = $fournid;

		return $this;
	}

	/**
	 * Get fournid
	 *
	 * @return int
	 */
	public function getFournid()
	{
		return $this->fournid;
	}

	/**
	 * Set status
	 *
	 * @param string $status
	 *
	 * @return Orders
	 */
	public function setStatus($status)
	{
		$this->status = $status;

		return $this;
	}

	/**
	 * Get status
	 *
	 * @return string
	 */
	public function getStatus()
	{
		return $this->status;
	}
}

