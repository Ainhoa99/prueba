<?php
include('database/conexion.php');
session_start();
if ($_GET['nota'] != "" && $_GET['idioma'] != "" && $_GET['edad'] != "") {
    $consulta = $miPDO->prepare('INSERT INTO valoraciones (nota , edad, nickname, id_libro, id_idioma)
                    VALUES (:nota, :edad, :nickname, :id_libro, :id_idioma)');
    $consulta->execute(
        [
            'nota' => $_GET['nota'],
            'edad' => $_GET['edad'],
            'nickname' => $_SESSION['nickname'],
            'id_libro' => $_GET['libro'],
            'id_idioma' => $_GET['idioma']
        ]
    );
}
header('Location: fichalibro.php?liburua=' . $_GET['libro']);
