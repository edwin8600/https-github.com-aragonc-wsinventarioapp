<?php

/**
 * Class TblUsuario
 *
 * Model Entity for TblUsuario table
 *
 * @author José Loguercio <jloguercio@loggux.com>
 * @copyright Copyright (c) 2017, Loggux.com Internet Service
 */
class TbUsuario extends Model
{
    /**
     * cod_user
     *
     * @access protected
     * @var integer
     */
    private $cod_user;

    /**
     * nombres
     *
     * @access protected
     * @var string
     */
    private $nombres;

    /**
     * apaterno
     *
     * @access protected
     * @var string
     */
    private $apaterno;

    /**
     * amaterno
     *
     * @access protected
     * @var string
     */
    private $amaterno;

    /**
     * email
     *
     * @access protected
     * @var string
     */
    private $email;

    /**
     * pass
     *
     * @access protected
     * @var string
     */
    private $pass;

    /**
     * tipousuario
     *
     * @access protected
     * @var integer
     */
    private $tipousuario;

    /**
     * estado
     *
     * @access protected
     * @var integer
     */
    private $estado;

    /**
     * getCodUser
     *
     * @access public
     * @return int cod_user
     */
    public function getCodUser()
    {
        return $this->cod_user;
    }

    /**
     * setCodUser
     *
     * @access public
     * @param int $cod_user
     */
    public function setCodUser($cod_user)
    {
        $this->cod_user = $cod_user;
    }

    /**
     * getNombres
     *
     * @access public
     * @return string nombres
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * setNombres
     *
     * @access public
     * @param string $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * getApaterno
     *
     * @access public
     * @return string apaterno
     */
    public function getApaterno()
    {
        return $this->apaterno;
    }

    /**
     * setApaterno
     *
     * @access public
     * @param string $apaterno
     */
    public function setApaterno($apaterno)
    {
        $this->apaterno = $apaterno;
    }

    /**
     * getAmaterno
     *
     * @access public
     * @return string amaterno
     */
    public function getAmaterno()
    {
        return $this->amaterno;
    }

    /**
     * setAmaterno
     *
     * @access public
     * @param string $amaterno
     */
    public function setAmaterno($amaterno)
    {
        $this->amaterno = $amaterno;
    }

    /**
     * getEmail
     *
     * @access public
     * @return string email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * setEmail
     *
     * @access public
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * getPass
     *
     * @access public
     * @return string pass
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * setPass
     *
     * @access public
     * @param string $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     * getTipousuario
     *
     * @access public
     * @return int tipousuario
     */
    public function getTipousuario()
    {
        return $this->tipousuario;
    }

    /**
     * setTipousuario
     *
     * @access public
     * @param int $tipousuario
     */
    public function setTipousuario($tipousuario)
    {
        $this->tipousuario = $tipousuario;
    }

    /**
     * getEstado
     *
     * @access public
     * @return int estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * setEstado
     *
     * @access public
     * @param int $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
}