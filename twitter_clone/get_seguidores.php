<?php
session_start();

if(!isset($_SESSION['usuario'])) {
    header('Location: index.php?erro=1');
}

require_once('db.class.php');

$id_usuario = $_SESSION['id_usuario'];

$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "SELECT COUNT(*) AS qtde_seguidores FROM usuario_seguidores where seguindo__id_usuario = $id_usuario";

$resultado_id = mysqli_query($link, $sql);

$qtde_seguidores = 0;

if($resultado_id){
    $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
    $qtde_seguidores = $registro['qtde_seguidores'];
    echo 'SEGUIDORES<br>'.$qtde_seguidores;

} else {
    echo 'erro ao executar';
}
