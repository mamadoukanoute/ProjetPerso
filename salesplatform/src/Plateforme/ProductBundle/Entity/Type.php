<?php

namespace Plateforme\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table(name="Type")
 * @ORM\Entity(repositoryClass="Plateforme\ProductBundle\Repository\TypeRepository")
 */
class Type
{

	/**
	 * @var int
	 *
	 * @ORM\Column(name="typeid", type="integer", unique=true)
	 * @ORM\Id
	 */
	private $typeid;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;



	/**
	 * Get Typeid
	 *
	 * @return int
	 */
	public function getTypeid()
	{
		return $this->typeid;
	}


	/**
	 * Set typeid
	 *
	 * @param string $typeid
	 *
	 * @return Type
	 */
	public function setTypeid($typeid)
	{
		$this->typeid = $typeid;

		return $this;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Type
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get Name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
}

