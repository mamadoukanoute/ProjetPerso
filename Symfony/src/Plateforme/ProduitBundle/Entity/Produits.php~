<?php

namespace Plateforme\ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produits
 *
 * @ORM\Table(name="produits")
 * @ORM\Entity(repositoryClass="Plateforme\ProduitBundle\Repository\ProduitsRepository")
 */
class Produits
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
	 * @ORM\Column(name="nom", type="string", length=255)
	 */
	private $nom;

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
	 * @ORM\Column(name="prix", type="float")
	 */
	private $prix;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="catid", type="integer")
	 */
	private $catid;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="fournid", type="integer")
	 */
	private $fournid;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="nom_fichier", type="string", length=255)
	 */
	private $nomFichier;

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
	 * Set nom
	 *
	 * @param string $nom
	 *
	 * @return Produits
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

	/**
	 * Set description
	 *
	 * @param string $description
	 *
	 * @return Produits
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
	 * @return Produits
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
	 * Set prix
	 *
	 * @param float $prix
	 *
	 * @return Produits
	 */
	public function setPrix($prix)
	{
		$this->prix = $prix;

		return $this;
	}

	/**
	 * Get prix
	 *
	 * @return float
	 */
	public function getPrix()
	{
		return $this->prix;
	}

	/**
	 * Set catid
	 *
	 * @param integer $catid
	 *
	 * @return Produits
	 */
	public function setCatid($catid)
	{
		$this->catid = $catid;

		return $this;
	}

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
	 * Set fournid
	 *
	 * @param integer $fournid
	 *
	 * @return Produits
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
	 * Set nomFichier
	 *
	 * @param string $nomFichier
	 *
	 * @return Annonces
	 */
	public function setNomFichier($nomFichier)
	{
		$this->nomFichier = $nomFichier;

		return $this;
	}

	/**
	 * Get nomFichier
	 *
	 * @return string
	 */
	public function getNomFichier()
	{
		return $this->nomFichier;
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
		$nom=$userid."_".$date_Depot->format('d-m-Y H:i:s');


		$retour=$this->minimizeImage($name,$nom);
		if(strtolower(substr(strrchr($name,'.')  ,1))=='jpeg'|| strtolower(substr(strrchr($name,'.')  ,1))=='jpg' )
		{
			rename($this->getUploadRootDir()."/".$name1,$this->getUploadRootDir()."/".$nom.".jpeg");
			$this->nomFichier=$nom.".jpeg";
		}
		else if(strtolower(substr(strrchr($name1,'.')  ,1))=='png' ){
			rename($this->getUploadRootDir()."/".$name1,$this->getUploadRootDir()."/".$nom.".png");
			$this->nomFichier=$nom.".png";
		}
		return $retour;

	}

	public function getUploadDir()
	{
		return 'uploads/Annonces_img';
	}

	protected function getUploadRootDir()
	{
		// On retourne le chemin relatif vers l'image pour notre code PHP
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}

	public function minimizeImage($name,$nom)
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
				imagejpeg($destination,$nom.".jpeg");
				return $nom.".jpeg";
			}
			if(strtolower(substr(strrchr($name,'.')  ,1))=='png' ){
				imagepng($destination,$nom.".png");
				return $nom.".png";
			}
		}
		else{

			mkdir("mini", 0777);
			chdir("mini");
			if(strtolower(substr(strrchr($name,'.')  ,1))=='jpeg'|| strtolower(substr(strrchr($name,'.')  ,1))=='jpg' ){
				imagejpeg($destination,$nom.".jpeg");
				return $nom.".jpeg";
			}
			if(strtolower(substr(strrchr($name,'.')  ,1))=='png' ){
				imagepng($destination,$nom.".png");
				return $nom.".png";
			}
		}
		return $nom;

	}   

}

