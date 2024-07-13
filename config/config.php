<?php
include_once __DIR__ . '/../classes/Database.php'; // Caminho ajustado para o arquivo Database.php

$dataBase = new DataBase();
$db = $dataBase->getConnection();
?>
