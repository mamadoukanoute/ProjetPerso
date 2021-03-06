<?php

namespace Plateforme\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="Products")
 * @ORM\Entity(repositoryClass="Plateforme\ProductBundle\Repository\ProductsRepository")
 */
class Products
{

	/**
	 * @var int
	 *
	 * @ORM\Column(name="prodid", type="integer", unique=true)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $prodid;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text")
	 */
	private $description;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="qte", type="integer")
	 */
	private $qte;

	/**
	 * @var float
	 *
	 * @ORM\Column(name="price", type="float")
	 */
	private $price;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="typeid", type="integer")
	 */
	private $typeid;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="fournid", type="integer")
	 */
	private $fournid;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="name_fichier", type="string", length=255)
	 */
	private $nameFichier;

	public $file;



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
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Products
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

	/**
	 * Set description
	 *
	 * @param string $description
	 *
	 * @return Products
	 */
	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * Get description
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set qte
	 *
	 * @param integer $qte
	 *
	 * @return Products
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
	 * Set price
	 *
	 * @param float $price
	 *
	 * @return Products
	 */
	public function setPrice($price)
	{
		$this->price = $price;

		return $this;
	}

	/**
	 * Get price
	 *
	 * @return float
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * Set typeid
	 *
	 * @param integer $typeid
	 *
	 * @return Products
	 */
	public function setTypeid($typeid)
	{
		$this->typeid = $typeid;

		return $this;
	}

	/**
	 * Get typeid
	 *
	 * @return int
	 */
	public function getTypeid()
	{
		return $this->typeid;
	}

	/**
	 * Set fournid
	 *
	 * @param integer $fournid
	 *
	 * @return Products
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
	 * Set nameFichier
	 *
	 * @param string $nameFichier
	 *
	 * @return Annonces
	 */
	public function setNameFichier($nameFichier)
	{
		$this->nameFichier = $nameFichier;

		return $this;
	}

	/**
	 * Get NameFichier
	 *
	 * @return string
	 */
	public function getNameFichier()
	{
		return $this->nameFichier;
	} 



	public function upload($userid)
	{
		if (null === $this->file) {
			return '';
		}

		$name = $this->file->getClientOriginalName();
		$name1=$name;
		$this->file->move($this->getUploadRootDir(), $name);
		//echo $this->getUploadRootDir();
		$date_Depot= new \DateTime("now");
		$date=$userid."_".$date_Depot->format('d-m-Y H:i:s');


		$retour=$this->minimizeImage($name,$date);
		if(strtolower(substr(strrchr($name,'.')  ,1))=='jpeg'|| strtolower(substr(strrchr($name,'.')  ,1))=='jpg' )
		{
			rename($this->getUploadRootDir()."/".$name1,$this->getUploadRootDir()."/".$date.".jpeg");
			$this->nameFichier=$name.".jpeg";
		}
		else if(strtolower(substr(strrchr($name1,'.')  ,1))=='png' ){
			rename($this->getUploadRootDir()."/".$name1,$this->getUploadRootDir()."/".$date.".png");
			$this->nameFichier=$name.".png";
		}
		return $retour;

	}

	public function getUploadDir()
	{
		return 'uploads/Products_img';

	}

	protected function getUploadRootDir()
	{
		// On retourne le chemin relatif vers l'image pour notre code PHP
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}

	public function minimizeImage($name,$date)
	{
		chdir($this->getUploadRootDir());

		if(strtolower(substr(strrchr($name,'.')  ,1))=='jpeg'|| strtolower(substr(strrchr($name,'.')  ,1))=='jpg' ){
			$source = imagecreatefromjpeg($name); 
		}
		if(strtolower(substr(strrchr($name,'.')  ,1))=='png' ){
			$source = imagecreatefrompng($name); 
		}
		$destination = imagecreatetruecolor(150,100);
		$largeur_source = imagesx($source);
		$hauteur_source = imagesy($source);
		$largeur_destination = imagesx($destination);
		$hauteur_destination = imagesy($destination);
		imagecopyresampled($destination, $source, 0, 0, 0, 0,$largeur_destination, $hauteur_destination, $largeur_source,$hauteur_source);
		umask(0);
		if(file_exists("mini")){
			chdir("mini");	
			if(strtolower(substr(strrchr($name,'.')  ,1))=='jpeg'|| strtolower(substr(strrchr($name,'.')  ,1))=='jpg' ){
				imagejpeg($destination,$date.".jpeg");
				return $date.".jpeg";
			}
			if(strtolower(substr(strrchr($name,'.')  ,1))=='png' ){
				imagepng($destination,$date.".png");
				return $date.".png";
			}
		}
		else{

			mkdir("mini", 0777);
			chdir("mini");
			if(strtolower(substr(strrchr($name,'.')  ,1))=='jpeg'|| strtolower(substr(strrchr($name,'.')  ,1))=='jpg' ){
				imagejpeg($destination,$date.".jpeg");
				return $date.".jpeg";
			}
			if(strtolower(substr(strrchr($name,'.')  ,1))=='png' ){
				imagepng($destination,$date.".png");
				return $date.".png";
			}
		}
		return $date;

	}   

}

