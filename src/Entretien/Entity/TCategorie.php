<?php

namespace Entretien\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TCategorie
 * @codeCoverageIgnore Getters and setters should not be tested.
 *
 * @ORM\Table(name="T_CATEGORIE")
 * @ORM\Entity
 */
class TCategorie
{

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_CATEGORIE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="S_CATEGORIE_ID", allocationSize=1, initialValue=1)
     */
    private $idCategorie;

    /**
     * @var integer
     *
     * @ORM\Column(name="ACTIF", type="integer", nullable=true)
     */
    private $actif;

    /**
     * @var integer
     *
     * @ORM\Column(name="ORDRE", type="integer", nullable=true)
     */
    private $ordre;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_PARENT", type="integer", nullable=true)
     */
    private $idParent;

    /**
     * @var string
     *
     * @ORM\Column(name="REF_TABLE", type="string", length=128, nullable=true)
     */
    private $refTable;

    /**
     * @var string
     *
     * @ORM\Column(name="LIBELLE", type="string", length=256, nullable=true)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_BAREME", type="integer", nullable=true)
     */
    private $idBareme;

    /**
     * Get idCategorie
     *
     * @return integer
     */
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    /**
     * Set actif
     *
     * @param integer $actif
     * @return TCategorie
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return integer
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     * @return TCategorie
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set idParent
     *
     * @param integer $idParent
     * @return TCategorie
     */
    public function setIdParent($idParent)
    {
        $this->idParent = $idParent;

        return $this;
    }

    /**
     * Get idParent
     *
     * @return integer
     */
    public function getIdParent()
    {
        return $this->idParent;
    }

    /**
     * Set refTable
     *
     * @param string $refTable
     * @return TCategorie
     */
    public function setRefTable($refTable)
    {
        $this->refTable = $refTable;

        return $this;
    }

    /**
     * Get refTable
     *
     * @return string
     */
    public function getRefTable()
    {
        return $this->refTable;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return TCategorie
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return TCategorie
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
     * Set idBareme
     *
     * @param integer $idBareme
     * @return TCategorie
     */
    public function setIdBareme($idBareme)
    {
        $this->idBareme = $idBareme;

        return $this;
    }

    /**
     * Get idBareme
     *
     * @return integer
     */
    public function getIdBareme()
    {
        return $this->idBareme;
    }
}

