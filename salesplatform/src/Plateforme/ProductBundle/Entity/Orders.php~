<?php

namespace Plateforme\ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commandes
 *
 * @ORM\Table(name="commandes")
 * @ORM\Entity(repositoryClass="Plateforme\ProduitBundle\Repository\CommandesRepository")
 */
class Commandes
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


	/**
	 * @var int
	 *
	 * @ORM\Column(name="fournid", type="integer")
	 */
	private $fournid;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="statut", type="string", length=255)
	 */
	private $statut;


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
	 * @return Commandes
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
	 * Set statut
	 *
	 * @param string $statut
	 *
	 * @return Commandes
	 */
	public function setStatut($statut)
	{
		$this->statut = $statut;

		return $this;
	}

	/**
	 * Get statut
	 *
	 * @return string
	 */
	public function getStatut()
	{
		return $this->statut;
	}
}

