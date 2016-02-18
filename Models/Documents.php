<?php
namespace Models;
/**
 *@InheritanceType("SINGLE_TABLE")
 *@DiscriminatorColumn(name="type_doc", type="string")
 * @Entity @Table(name="Documents")
 **/
/**@UniqueEntity("nom_doc", "Ce nom de masque existe déjà.")**/
class Documents
{
  /** @Id @Column(type="integer", nullable=false) @GeneratedValue **/
  /**@var int **/
protected  $id_doc;

	 /** @Column(type="string", nullable=false) **/
     /**@var string **/
 protected $nom_doc;

	/**
     * @OneToOne(targetEntity="Masks", mappedBy="Documents")
     * @JoinColumn(name="id_masks", referencedColumnName="id_masks")
	*/
 protected $id_masks;

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

    /**
     * Gets the value of nom_doc.
     *
     * @return mixed
     */
    public function getNomDoc()
    {
        return $this->nom_doc;
    }

    /**
     * Sets the value of nom_doc.
     *
     * @param mixed $nom_doc the nom doc
     *
     * @return self
     */
    protected function setNomDoc($nom_doc)
    {
        $this->nom_doc = $nom_doc;

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