<?php
namespace Models;
/**
 * @Entity @Table(name="Champs")
 *@UniqueEntity("nom_Champs", "Ce nom de champ existe déjà.")**/
class Champs{
  /** @Id @Column(type="integer", nullable=false) @GeneratedValue **/
  /**@var int **/
protected  $id_Champs;

/** @Column(type="string", nullable=false) **/
/**@var string **/
protected $nom_Champs;

/** @Column(type="string")**/
/**@var string **/
protected $Type_Champs;

/** @Column(type="float")**/
/**@var float **/
protected $x1;

/** @Column(type="float")**/
/**@var float **/
protected $x2;

/** @Column(type="float")**/
/**@var float **/
protected $y1;

/** @Column(type="float")**/
/**@var float **/
protected $y2;

	/**
     * @OneToMany(targetEntity="Masks", mappedBy="Champs")
     * @JoinColumn(name="id_masks", referencedColumnName="id_masks")
	 */
protected  $id_masks;

    /**
     * Gets the value of id_Champs.
     *
     * @return mixed
     */
    public function getIdChamps()
    {
        return $this->id_Champs;
    }

    /**
     * Sets the value of id_Champs.
     *
     * @param mixed $id_Champs the id champs
     *
     * @return self
     */
    protected function setIdChamps($id_Champs)
    {
        $this->id_Champs = $id_Champs;

        return $this;
    }

    /**
     * Gets the value of nom_Champs.
     *
     * @return mixed
     */
    public function getNomChamps()
    {
        return $this->nom_Champs;
    }

    /**
     * Sets the value of nom_Champs.
     *
     * @param mixed $nom_Champs the nom champs
     *
     * @return self
     */
    protected function setNomChamps($nom_Champs)
    {
        $this->nom_Champs = $nom_Champs;

        return $this;
    }

    /**
     * Gets the value of Type_Champs.
     *
     * @return mixed
     */
    public function getTypeChamps()
    {
        return $this->Type_Champs;
    }

    /**
     * Sets the value of Type_Champs.
     *
     * @param mixed $Type_Champs the type champs
     *
     * @return self
     */
    protected function setTypeChamps($Type_Champs)
    {
        $this->Type_Champs = $Type_Champs;

        return $this;
    }

    /**
     * Gets the value of x1.
     *
     * @return mixed
     */
    public function getX1()
    {
        return $this->x1;
    }

    /**
     * Sets the value of x1.
     *
     * @param mixed $x1 the x1
     *
     * @return self
     */
    protected function setX1($x1)
    {
        $this->x1 = $x1;

        return $this;
    }

    /**
     * Gets the value of x2.
     *
     * @return mixed
     */
    public function getX2()
    {
        return $this->x2;
    }

    /**
     * Sets the value of x2.
     *
     * @param mixed $x2 the x2
     *
     * @return self
     */
    protected function setX2($x2)
    {
        $this->x2 = $x2;

        return $this;
    }

    /**
     * Gets the value of y1.
     *
     * @return mixed
     */
    public function getY1()
    {
        return $this->y1;
    }

    /**
     * Sets the value of y1.
     *
     * @param mixed $y1 the y1
     *
     * @return self
     */
    protected function setY1($y1)
    {
        $this->y1 = $y1;

        return $this;
    }

    /**
     * Gets the value of y2.
     *
     * @return mixed
     */
    public function getY2()
    {
        return $this->y2;
    }

    /**
     * Sets the value of y2.
     *
     * @param mixed $y2 the y2
     *
     * @return self
     */
    protected function setY2($y2)
    {
        $this->y2 = $y2;

        return $this;
    }

    /**
     * Gets the value of id_masks.
     *
     * @return mixed
     */
    public function getIdMasks()
    {
        return $this->id_masks;
    }

    /**
     * Sets the value of id_masks.
     *
     * @param mixed $id_masks the id masks
     *
     * @return self
     */
    protected function setIdMasks($id_masks)
    {
        $this->id_masks = $id_masks;

        return $this;
    }
}