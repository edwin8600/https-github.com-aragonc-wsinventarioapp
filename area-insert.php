<?php

require 'base/Set.php';
require 'base/Model.php';
require 'base/Database.php';
require 'model/TbArea.php';

$array = $_REQUEST;

if (!$array) {
    echo json_encode([]);
    exit;
}

$area = new TbArea();

$area->setCodArea($array['cod_area']);
$area->setNombre($array['nombre']);
$area->setCodArea($array['estado']);

$response = $area->insert();

echo json_encode($response);