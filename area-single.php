<?php

require 'base/Set.php';
require 'base/Model.php';
require 'base/Database.php';
require 'model/TbArea.php';

$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : null;

if (!$id) {
    echo json_encode([]);
    exit;
}

$area = new TbArea();
$thisArea = $area->findOneBy(['cod_area' => $id]);

$json = [
    'cod_area' => $thisArea->getCodArea(),
    'nombre' => $thisArea->getNombre(),
    'estado' => $thisArea->getEstado(),
];

echo json_encode($json);