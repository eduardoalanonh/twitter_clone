<?php


session_start();

if(!$_SESSION['usuario']){
    header('Location: index.php?erro=1');
}

require_once('db.class.php');

$id_usuario = $_SESSION['id_usuario'];
$excluir_tweet = $_POST['id_excluir'];

$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "delete from tweet where id_tweet = $excluir_tweet ";

echo $sql;

mysqli_query($link,$sql);
