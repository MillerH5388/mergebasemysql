<?php
    session_start();

    // DB Rementente
    $db_host_r = $_POST['db_host_r'] ?? "";
    $db_user_r = $_POST['db_user_r'] ?? "";
    $db_schema_r = $_POST['db_schema_r'] ?? "";
    $db_port_r = $_POST['db_port_r'] ?? "";
    $db_password_r = $_POST['db_password_r'] ?? "";
    
    // DB Destino
    $db_host_d = $_POST['db_host_d'] ?? "";
    $db_user_d = $_POST['db_user_d'] ?? "";
    $db_schema_d = $_POST['db_schema_d'] ?? "";
    $db_port_d = $_POST['db_port_d'] ?? "3306";
    $db_password_d = $_POST['db_password_d'] ?? "";

    $conection = $_POST['conectar'] ? true : false;

    $erro_log = "";
    $erro = false;

    if($conection)
    {
        try 
        {
            $conexao_r = new PDO('mysql:host='.$db_host_r.':'.$db_port_r.';dbname='.$db_schema_r.'', $db_user_r, $db_password_r, null);
            $conexao_r->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexao_r->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $conexao_r->exec("set names utf8");

            $conexao_d = new PDO('mysql:host='.$db_host_d.':'.$db_port_d.';dbname='.$db_schema_d.'', $db_user_d, $db_password_d, null);
            $conexao_d->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexao_d->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $conexao_d->exec("set names utf8");

        } catch (Exception $e) 
        {
            $erro_log = $e->getMessage();
            $erro = true;
            $conection = false;
        }
    }

    function gerarCreateTable(PDO $conexao, $nomeDaTabela) {
        try {
            // Obtém informações sobre a estrutura da tabela
            $stmt = $conexao->prepare("SHOW CREATE TABLE $nomeDaTabela");
            $stmt->execute();
    
            // Obtém a linha de CREATE TABLE
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Extrai a linha de CREATE TABLE do resultado
            $createTableQuery = $resultado['Create Table'];

            $createTableQuery = preg_replace('/AUTO_INCREMENT=[0-9]+/', '', $createTableQuery);

            return $createTableQuery;
    
            // Exibe a linha de CREATE TABLE
            echo $createTableQuery;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

?>