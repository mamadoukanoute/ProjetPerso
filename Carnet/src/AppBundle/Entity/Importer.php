<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


class Importer
{


    private $nomfichier;


    public $file;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomfichier
     *
     * @param string $nomfichier
     *
     * @return Importer
     */
    public function setNomfichier($nomfichier)
    {
        $this->nomfichier = $nomfichier;

        return $this;
    }

    /**
     * Get nomfichier
     *
     * @return string
     */
    public function getNomfichier()
    {
        return $this->nomfichier;
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



        rename($this->getUploadRootDir()."/".$name,$this->getUploadRootDir()."/".$date.".txt");
        $this->nomfichier=$date.".txt";
        return $this->nomfichier;


    }

    public function getUploadDir()
    {
        return 'uploads/Carnets';

    }

    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }


}

