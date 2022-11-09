<?php
    //Variables
    $hostDB = '127.0.0.1';
    $nombreDB = 'igkluba';
    $usuarioDB = 'root';
    $contrasenyaDB = '';

    //Conecta con base de datos
    $hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
    $miPDO = new PDO($hostPDO, $usuarioDB, $contrasenyaDB);

   
?>