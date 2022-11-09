<?php
include('database/conexion.php');
session_start();

if ($_GET['opinion'] != "") {
    $consulta = $miPDO->prepare('INSERT INTO opiniones (nickname , opinion, validado, id_libro)
                    VALUES (:nickname, :opinion, :validado, :id_libro)');
    if ($_SESSION['tipo'] == 'Alumno') {
        $consulta->execute(
            [
                'nickname' => $_SESSION['nickname'],
                'opinion' => $_GET['opinion'],
                'validado' => 0,
                'id_libro' => $_GET['libro']
            ]
        );
    } else {
        $consulta->execute(
            [
                'nickname' => $_SESSION['nickname'],
                'opinion' => $_GET['opinion'],
                'validado' => 1,
                'id_libro' => $_GET['libro']
            ]
        );
    }
}
header('Location: fichalibro.php?liburua=' . $_GET['libro']);
