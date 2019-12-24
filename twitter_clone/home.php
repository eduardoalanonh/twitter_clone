<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header('Location: index.php?erro=1');
}

$id_usuario = $_SESSION['id_usuario'];

require_once('db.class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();



?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <title>Twitter clone</title>

    <!-- jquery - link cdn -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

    <!-- bootstrap - link cdn -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <script type="text/javascript">
        $(document).ready( function () {
            $('#btn_tweet').click( function () {


                if($('#text_tweet').val().length > 0){
                    $.ajax({
                        url:'inclui_tweet.php',
                        method: 'post',
                        data: $('#form_tweet').serialize(),
                        success: function (data) {
                            $('#text_tweet').val('') ;
                            atualizaTweet();
                            atualizaQtdTweet();


                        }
                    });
            }

            })

            function atualizaTweet() {
               $.ajax({
                   url: 'get_tweet.php',
                   success: function (data) {
                       $('#tweets').html(data);

                       $('.btn_excluir').click(function () {
                           var id_tweet = $(this).data('id_tweet');
                           $.ajax({
                              url: 'excluir_tweet.php',
                              method: 'post',
                              data: { id_excluir: id_tweet},
                              success: function (data) {
                                  atualizaTweet();
                                  atualizaQtdTweet();
                                  alert('post excluido com sucesso');
                              }
                          })

                       })

                   }
               });
            }

            function atualizaQtdTweet() {
                $.ajax({
                    url: 'get_qtd_tweet.php',
                    success: function (data) {
                        $('#tweetsqtd').html(data);

                    }
                });
            }

            function atualizaSeguidores() {
                $.ajax({
                    url: 'get_seguidores.php',
                    success: function (data) {
                        $('#seguidores').html(data);

                    }
                });
            }

            atualizaQtdTweet();

            atualizaTweet();

            atualizaSeguidores();

        });

    </script>

</head>

<body>

<!-- Static navbar -->
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img src="imagens/icone_twitter.png" />
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><span><?php echo $_SESSION['usuario']; ?> <a href="sair.php">Sair</a></span></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>


<div class="container">
<div class="row">


    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
              <h4>  <?= $_SESSION['usuario']?></h4>
              <hr>
                <div class="col-md-6" ">
                <div id="tweetsqtd" class="list-group">

                </div>

                </div>
                <div class="col-md-6">
                    <div id="seguidores" class="list-group">

                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="col-md-6">
        <div class="panel panel-default">

            <div class="panel-body">
                <form id="form_tweet">
                <div class="input-group">
                    <input type="text" id="text_tweet" name="texto_tweet" class="form-control" placeholder="O que esta acontecendo agora?" maxlength="140">
                    <span class="input-group-btn">
                        <button class="btn btn-default" id="btn_tweet" type="button">Tweet</button>
                    </span>

                </div>
                </form>
            </div>
        </div>


        <div id="tweets" class="list-group">

        </div>



    </div>


<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-body">
            <h4><a href="procurar_pessoas.php">Procurar por Pessoas</a></h4>
        </div>
    </div>
</div>

</div>
</div>

</body>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>
</html>