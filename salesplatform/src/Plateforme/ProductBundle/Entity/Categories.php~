<?php

namespace Plateforme\ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="Plateforme\ProduitBundle\Repository\CategoriesRepository")
 */
class Categories
{

	/**
	 * @var int
	 *
	 * @ORM\Column(name="catid", type="integer", unique=true)
	 * @ORM\Id
	 */
	private $catid;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nom", type="string", length=255)
	 */
	private $nom;



	/**
	 * Get catid
	 *
	 * @return int
	 */
	public function getCatid()
	{
		return $this->catid;
	}


	/**
	 * Set catid
	 *
	 * @param string $catid
	 *
	 * @return Categories
	 */
	public function setCatid($catid)
	{
		$this->catid = $catid;

		return $this;
	}

	/**
	 * Set nom
	 *
	 * @param string $nom
	 *
	 * @return Categories
	 */
	public function setNom($nom)
	{
		$this->nom = $nom;

		return $this;
	}

	/**
	 * Get nom
	 *
	 * @return string
	 */
	public function getNom()
	{
		return $this->nom;
	}
}

