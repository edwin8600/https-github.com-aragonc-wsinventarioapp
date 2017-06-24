<?php

require 'base/Set.php';
require 'base/Model.php';
require 'base/Database.php';
require 'model/TbUsuario.php';

$login = $_REQUEST;

if (!$login) {
    echo json_encode([]);
    exit;
}

$usuario = new TbUsuario();

$usuarioLoginCheck = $usuario->findOneBy(['email' => $login['email'], 'pass' => $login['pass']]);

if ($usuarioLoginCheck) {
    $user = [
        'cod_user' => $usuarioLoginCheck->getCodUser(),
        'nombres'=> $usuarioLoginCheck->getNombres(),
        'apaterno' => $usuarioLoginCheck->getApaterno(),
        'amaterno' => $usuarioLoginCheck->getAmaterno(),
        'email' => $usuarioLoginCheck->getEmail(),
        'pass' => $usuarioLoginCheck->getPass(),
        'tipousuario' => $usuarioLoginCheck->getTipousuario(),
        'estado' => $usuarioLoginCheck->getEstado(),
    ];
    echo json_encode($user);
} else {
    echo json_encode([]);
}