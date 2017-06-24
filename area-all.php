<?php

require 'base/Set.php';
require 'base/Model.php';
require 'base/Database.php';
require 'model/TbArea.php';

$area = new TbArea();
$areas = $area->findAll();

$json = [];

foreach ($areas as $area) {
    $json[]['cod_area'] = $area->getCodArea();
    $json[]['nombre'] = $area->getNombre();
    $json[]['estado'] = $area->getEstado();
}

echo json_encode($json);