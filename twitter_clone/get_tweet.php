<?php

        session_start();

        if(!isset($_SESSION['usuario'])) {
            header('Location: index.php?erro=1');
        }

        require_once('db.class.php');

        $id_usuario = $_SESSION['id_usuario'];

        $objDb = new db();
        $link = $objDb->conecta_mysql();


        $sql = "SELECT DATE_FORMAT(t.data_inclusao, '%d %b %Y %T') as data_inclusao ,t.tweet, u.usuario,u.id, t.id_tweet  FROM tweet AS t join usuarios as u ON(t.id_usuario = u.id)";
        $sql.= "where id_usuario = $id_usuario ";
        $sql.= "OR id_usuario IN (select seguindo__id_usuario from usuario_seguidores where id_usuario = $id_usuario)";
        $sql.= "ORDER BY data_inclusao DESC";




        $resultado_id = mysqli_query($link,$sql);

        if($resultado_id){
            while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
               echo '<a href="#" class="list-group-item">';
                 echo '<h4 class="list-group-item-heading">'.$registro['usuario'].'<small> - '.$registro['data_inclusao'].'</small></h4>';
                 echo '<p class="list-group-item-text">'.$registro['tweet'].'</p>';
                 if ($registro['id'] == $id_usuario){
                     echo '<button class="btn btn-danger pull-right btn_excluir" id="btn-excluir_'.$registro['id_tweet'].'"
                     data-id_tweet="'.$registro['id_tweet'].'">Excluir Post</button>';
                     echo '<div class="clearfix"></div>';

                 }


               echo '</a>';
            }

        } else {
            echo 'houve erro na consulta';
        }