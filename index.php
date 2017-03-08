<?php
    //error_reporting(0);
    spl_autoload_register(function($class_name){
        require_once 'classes/' . $class_name . '.php';
    });
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Compre Já</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
        <?php

        $landing = new Landings();

        if(isset($_POST['salvar'])){
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $dataNasc = $_POST['dataNasc'];
            $telefone = $_POST['telefone'];
            $token = isset($_POST['token'])?$_POST['token']:'92ec877d9401e79dc91e042546bdb55e';
            $regiao = isset($_POST['regiao'])?$_POST['regiao']:1;
            $unidade = isset($_POST['unidade'])?$_POST['unidade']:2;

            $landing->setNome($nome);
            $landing->setEmail($email);
            $landing->setDataNasc($dataNasc);
            $landing->setTelefone($telefone);
            $landing->setToken($token);
            $landing->setRegiao($regiao);
            $landing->setUnidade($unidade);
            $landing->calculaScore($regiao, $unidade);
            $landing->calculaIdade($dataNasc);
            $landing->salvar();
        }
        /*

        */
    ?>
            <div class="row" style="margin:30px 0">
                <div class="col-lg-3">
                    <img src="img/logo.png" class="img-thumbnail">
                </div>
                <div class="col-lg-9">
                    <h3>Nome do Produto</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6" id="form-container">

                    <form method="post" action="">
                        <div id="step_1" class="form-step" >
                            <div class="panel panel-info">
                                <input type="hidden" name="token" value="92ec877d9401e79dc91e042546bdb55e">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Preencha seus dados para receber contato
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <fieldset>
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label>Nome Completo</label>
                                                <input class="form-control" type="text" name="nome">
                                            </div>

                                            <div class="col-lg-6">
                                                <label>Data de Nascimento</label>
                                                <input class="form-control" type="text" name="dataNasc">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label>Email</label>
                                                <input class="form-control" type="text" name="email">
                                            </div>

                                            <div class="col-lg-6">
                                                <label>Telefone</label>
                                                <input class="form-control" type="text" name="telefone">
                                            </div>
                                        </div>

                                        <div>
                                            <button id="step_2" class="btn btn-lg btn-info next-step">Próximo Passo</button>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    <!--</form>-->

                    <!--<form id="step_2" class="form-step" style="display:none">-->
                        <div id="step_2" class="form-step" style="display:none">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Preencha seus dados para receber contato
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <fieldset>
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label>Região</label>
                                                <select class="form-control" id="regiao" name="regiao">
                                                    <option value="0">Selecione a sua região</option>
                                                    <?php foreach($landing->regiao() as $key => $value){ ?>
                                                    <option value="<?php echo $value->id_regiao; ?>">
                                                        <?php echo $value->regiao; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-lg-6">
                                                <label>Unidade</label>
                                                <select class="form-control" id="unidade" name="unidade">
                                                    <option value="">Selecione a unidade mais próxima</option>
                                                    
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <input type="submit" name="salvar" value="Salvar" class="btn btn-lg btn-info"/>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div id="step_sucesso" class="form-step" style="display:none">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Obrigado pelo cadastro!
                                </div>
                            </div>
                            <div class="panel-body">
                                Em breve você receberá uma ligação com mais informações!
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h1>Chamada interessante para o produto</h1>
                    <h2>Mais uma informação relevante</h2>
                </div>
            </div>
        </div>
        <script>
            $(function () {
                $('.next-step').click(function (event) {
                    event.preventDefault();
                    $(this).parents('.form-step').hide().next().show();
                });
            });
        </script>
        <script type="text/javascript">
            $('#regiao').change(function () {
                var valor = document.getElementById("regiao").value;
                $.get('classes/cidade.php?buscar=' + valor, function (data) {
                    $('#unidade').find("option").remove();
                    $('#unidade').append(data);
                });
            });
        </script>
    </body>
</html>
