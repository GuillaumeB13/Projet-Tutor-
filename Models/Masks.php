<?php
namespace Models;

/**
 * @Entity @Table(schema="myocr",name="Masks")
 **/
/**@UniqueEntity("nom_masks", "Ce nom de masque existe déjà.")**/
class Masks
{
  /** @Id @Column(type="integer", nullable=false) @GeneratedValue **/
  /**@var int **/
protected  $id_masks;

	 /** @Column(type="string", nullable=false) **/
     /**@var string **/
 protected $nom_masks;

	/**
     * @OneToOne(targetEntity="Documents", mappedBy="Masks")
     * @JoinColumn(name="id_doc", referencedColumnName="id_doc")
	*/
 protected $id_doc;

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

    /**
     * Gets the value of nom_masks.
     *
     * @return mixed
     */
    public function getNomMasks()
    {
        return $this->nom_masks;
    }

    /**
     * Sets the value of nom_masks.
     *
     * @param mixed $nom_masks the nom masks
     *
     * @return self
     */
    protected function setNomMasks($nom_masks)
    {
        $this->nom_masks = $nom_masks;

        return $this;
    }

    /**
     * Gets the value of id_doc.
     *
     * @return mixed
     */
    public function getIdDoc()
    {
        return $this->id_doc;
    }

    /**
     * Sets the value of id_doc.
     *
     * @param mixed $id_doc the id doc
     *
     * @return self
     */
    protected function setIdDoc($id_doc)
    {
        $this->id_doc = $id_doc;

        return $this;
    }
}