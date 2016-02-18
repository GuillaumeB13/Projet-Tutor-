<?php
namespace Models;
/**
 * @Entity @Table(name="Users")
 **/
/**@UniqueEntity("login", "Ce nom d'utilisateur existe déjà.")**/
class Users
{
  /** @Id @Column(type="integer", nullable=false) @GeneratedValue **/
  /**@var int **/
protected  $id_users;

	 /** @Column(type="string", nullable=false) **/
     /**@var string **/
 protected $login;

 /** @Column(type="string") **/
 /**@var string **/
 protected $password;

 /** @Column(type="string") **/
 /**@var string **/
 protected $mail;

 /** @Column(type="string", nullable=true) **/
 /**@var string **/
 protected $nom;

 /** @Column(type="string", nullable=true) **/
 /**@var string **/
 protected $prenom;

 /** @Column(type="boolean", nullable=false, options={"default":false}) **/
 /**@var boolean **/
 protected $super_user;

 /** @Column(type="integer", nullable=true) **/
 /**@var int**/
 protected $tel;


    /**
     * Gets the value of id_users.
     *
     * @return mixed
     */
    public function getIdUsers()
    {
        return $this->id_users;
    }

    /**
     * Sets the value of id_users.
     *
     * @param mixed $id_users the id user
     *
     * @return self
     */
    public function setIdUsers($id_users)
    {
        $this->id_users = $id_users;

        return $this;
    }

    /**
     * Gets the value of login.
     *
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Sets the value of login.
     *
     * @param mixed $login the login
     *
     * @return self
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Gets the value of password.
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the value of password.
     *
     * @param mixed $password the password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Gets the value of mail.
     *
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Sets the value of mail.
     *
     * @param mixed $mail the mail
     *
     * @return self
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Gets the value of nom.
     *
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Sets the value of nom.
     *
     * @param mixed $nom the nom
     *
     * @return self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Gets the value of prenom.
     *
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Sets the value of prenom.
     *
     * @param mixed $prenom the prenom
     *
     * @return self
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Gets the value of super_user.
     *
     * @return mixed
     */
    public function getSuperUser()
    {
        return $this->super_user;
    }

    /**
     * Sets the value of super_user.
     *
     * @param mixed $super_user the super user
     *
     * @return self
     */
    public function setSuperUser($super_user)
    {
        $this->super_user = $super_user;

        return $this;
    }

    /**
     * Gets the value of tel.
     *
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Sets the value of tel.
     *
     * @param mixed $tel the tel
     *
     * @return self
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }
}
