<?php
    include 'funcoes.php';
?>

<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<head>

<section class="p-4">

    <h1 class="text-center mb-3">Merge Base</h1>
    <?if(!$conection){?>

        <form onsubmit="conectar()" method="POST" class="mt-4">
            <input type="hidden" name="conectar" value="true" /> 
            <div class="d-flex justify-content-center align-items-center">
                
                <div class="p-4 border">
                    
                    <h5 class="mb-4">Base de dados Mysql de Consulta</h5>

                    <div>
                        <label for="db_host_r">HOST</label><br>
                        <input class="form-control mb-2" required type="text" id="db_host_r" name="db_host_r" value="<?echo $db_host_r?>"/>
                    </div>

                    <div>
                        <label for="db_user_r">USER</label><br>
                        <input class="form-control mb-2" required type="text" id="db_user_r" name="db_user_r" value="<?echo $db_user_r?>"/>
                    </div>

                    <div>
                        <label for="db_schema_r">SCHEMA</label><br>
                        <input class="form-control mb-2" required type="text" id="db_schema_r" name="db_schema_r" value="<?echo $db_schema_r?>"/>
                    </div>

                    <div>
                        <label for="db_password_r">PORT</label><br>
                        <input class="form-control mb-2" required type="port" id="db_port_r" name="db_port_r" value="<?echo $db_port_r?>"/>
                    </div>

                    <div>
                        <label for="db_password_r">PASSWORD</label><br>
                        <input class="form-control mb-2" required type="password" id="db_password_r" name="db_password_r" value="<?echo $db_password_r?>"/>
                    </div>

                </div>

                <div class="mx-3">
                    <i class="bi bi-arrow-repeat h4 spin_animate"></i>
                </div>

                <div class="p-4 border">

                    <h5 class="mb-4">Base de dados Mysql para Atualizar</h5>

                    <div>
                        <label for="db_host_d">HOST</label><br>
                        <input class="form-control mb-2" required type="text" id="db_host_d" name="db_host_d" value="<?echo $db_host_d?>"/>
                    </div>

                    <div>
                        <label for="db_user_d">USER</label><br>
                        <input class="form-control mb-2" required type="text" id="db_user_d" name="db_user_d" value="<?echo $db_user_d?>"/>
                    </div>

                    <div>
                        <label for="db_schema_d">SCHEMA</label><br>
                        <input class="form-control mb-2" required type="text" id="db_schema_d" name="db_schema_d" value="<?echo $db_schema_d?>"/>
                    </div>

                    <div>
                        <label for="db_password_r">PORT</label><br>
                        <input class="form-control mb-2" required type="port" id="db_port_d" name="db_port_d" value="<?echo $db_port_d?>"/>
                    </div>

                    <div>
                        <label for="db_password_d">PASSWORD</label><br>
                        <input class="form-control mb-2" required type="password" id="db_password_d" name="db_password_d" value="<?echo $db_password_d?>"/>
                    </div>

                </div>

            </div>

            <div class="text-center">
                <button type="submit" class="mx-auto btn btn-success mt-4 d-flex align-items-center">
                    <i class="bi bi-check-circle me-2"></i> 
                    Conectar Bases
                </button>
            </div>

        </form>
        
        <?if ($erro) {?>
            <div class="alert alert-danger" role="alert">
                <?echo $erro_log?>
            </div>
        <?}?>

    <?}else{?>
        
        <div>
            
            <div class="d-flex mb-4 justify-content-center align-items-center">

                <div class="border p-3">
                    <?echo $db_host_r."@".$db_schema_r?>
                </div>

                <div class="mx-3">
                    <i class="bi bi-arrow-repeat h4 spin_animate"></i>
                </div>

                <div class="border p-3">
                    <?echo $db_host_d."@".$db_schema_d?>
                </div>

            </div>

            <!-- Nav tabs -->

            <div class="mb-2 text-end">
                <button class="btn btn-info btn-sm" onclick="window.location.href = ''">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Mudar conexões
                </button>
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#tab-1" type="button" role="tab" aria-controls="home" aria-selected="true">Tabelas não encontradas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab-2" type="button" role="tab" aria-controls="profile" aria-selected="false">Tabelas Sicronizadas</button>
                </li>
            </ul>

            <div class="tab-content">
                
                <div class="tab-pane active" id="tab-1" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                    <div class="">
                        <div class="accordion" id="accordionExample">

                            <?php
                            
                                $tabelas_r = $conexao_r->query("SHOW TABLES");
                                $tabelas_r = $tabelas_r->fetchAll(PDO::FETCH_COLUMN);

                                $tabelas_d = $conexao_d->query("SHOW TABLES");
                                $tabelas_d = $tabelas_d->fetchAll(PDO::FETCH_COLUMN);

                                $diferenca = array_diff($tabelas_r, $tabelas_d);

                                $contador = 1;
                                foreach ($diferenca as $key => $value) 
                                {
                            ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?echo $contador?>" aria-expanded="true" aria-controls="collapse<?echo $contador?>">
                                            <?echo $value?>
                                        </button>
                                        </h2>
                                        <div id="collapse<?echo $contador?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <label>Script de criação:</label><br><br>
                                                <pre><?php echo(gerarCreateTable($conexao_r, $value)) ?></pre>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                    $contador++;
                                }

                                $diferenca1 = array_diff($tabelas_r, $diferenca);
                                $diferenca2 = array_diff($diferenca, $tabelas_r);

                                $tabelas_verificar = array_merge($diferenca1, $diferenca2);
                            ?>

                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="tab-2" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

                    <div class="">
                        <div class="accordion" id="accordionExample2">

                            <?php
                                $contador = 1;
                                foreach ($tabelas_verificar as $key => $value) 
                                {
                                    $tabela = $value;
                                    $sicronizado = false;
                                    $script_sicronizacao = '';
                                    // Obter informações sobre a estrutura da tabela da primeira base de dados
                                    $stmt1 = $conexao_r->prepare("SHOW CREATE TABLE $tabela");
                                    $stmt1->execute();
                                    $resultado1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                    $estrutura1 = $resultado1['Create Table'];

                                    // Obter informações sobre a estrutura da tabela da segunda base de dados
                                    $stmt2 = $conexao_d->prepare("SHOW CREATE TABLE $tabela");
                                    $stmt2->execute();
                                    $resultado2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                    $estrutura2 = $resultado2['Create Table'];

                                    $definicoes1 = explode(',', preg_replace('/\s+/', '', $estrutura1));
                                    $definicoes2 = explode(',', preg_replace('/\s+/', '', $estrutura2));
                                    // Comparar as estruturas e gerar script ALTER TABLE
                                    $diferenca = array_diff($definicoes1, $definicoes2);
                                    if (!empty($diferenca)) 
                                    {
                                        $scriptAlterTable = "ALTER TABLE $tabela ";
                                        foreach ($diferenca as $campo => $definicao) {
                                            $scriptAlterTable .= "ADD $definicao, ";
                                        }
                                        $scriptAlterTable = rtrim($scriptAlterTable, ", ");
                                        $script_sicronizacao = $scriptAlterTable . ";";
                                    } else {
                                        $sicronizado = true;
                                    }
                            ?>
                                    <div class="accordion-item" table_sicronizado="<?if($sicronizado){echo 1;}else{echo 0;}?>">
                                        <h2 class="accordion-header" id="headingOne">
                                            
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_table_divergencia<?echo $contador?>" aria-expanded="true" aria-controls="collapse_table_divergencia<?echo $contador?>">
                                            <?echo $value?>
                                            <?if($sicronizado){?>
                                                <i class="ms-2 bi bi-check-circle-fill text-success" title="Tabela Sicronizada"></i>
                                            <?}else{?>
                                                <i class="ms-2 bi bi-x-circle-fill text-danger" title="Tabela com Divergência"></i>
                                            <?}?>
                                        </button>
                                        </h2>
                                        <div id="collapse_table_divergencia<?echo $contador?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample2">
                                            <div class="accordion-body">
                                                <?
                                                    if($sicronizado)
                                                    {
                                                ?>          
                                                        <div class="alert alert-success mb-0" role="alert">
                                                            Nenhuma divergência encontrada
                                                        </div>
                                                <?php
                                                    }
                                                    else
                                                    {
                                                ?>
                                                    <label>Script de Sicronização:</label><br><br>
                                                    <pre><?echo $script_sicronizacao?></pre>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                    $contador++;
                                }
                            ?>

                        </div>
                    </div>
                                
                </div>

            </div>

        </div>
    <?}?>

</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="main.js"></script>
