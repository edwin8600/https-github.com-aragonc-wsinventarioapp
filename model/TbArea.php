<?php

/**
 * Class TblArea
 *
 * Model Entity for TblArea table
 *
 * @author José Loguercio <jloguercio@loggux.com>
 * @copyright Copyright (c) 2017, Loggux.com Internet Service
 */
class TbArea extends Model
{
    /**
     * cod_area
     *
     * @access protected
     * @var integer
     */
    private $cod_area;

    /**
     * nombre
     *
     * @access protected
     * @var string
     */
    private $nombre;

    /**
     * estado
     *
     * @access protected
     * @var integer
     */
    private $estado;

    /**
     * getCodArea
     *
     * @access public
     * @return int cod_area
     */
    public function getCodArea()
    {
        return $this->cod_area;
    }

    /**
     * setCodArea
     *
     * @access public
     * @param int $cod_area
     */
    public function setCodArea($cod_area)
    {
        $this->cod_area = $cod_area;
    }

    /**
     * getNombre
     *
     * @access public
     * @return string nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * setNombre
     *
     * @access public
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
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