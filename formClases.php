<?php
include('database/conexion.php');
session_start();

if ($_GET['nombre'] != "") {
    $consulta = $miPDO->prepare('INSERT INTO clase (fecha_limite, nivel)
                    VALUES (:fecha_limite, :nivel)');
    $consulta->execute(
        [
            'fecha_limite' => $_GET['fecha'],
            'nivel' => $_GET['nombre']
        ]
    );
}
header('Location: mis_clases.php');
