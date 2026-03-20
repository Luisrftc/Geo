<?php
// ---------------------------------------------------------------------
// CONFIGURAÇÃO DO BANCO DE DADOS
// É NECESSÁRIO ALTERAR ESTAS VARIÁVEIS PARA SUAS CREDENCIAIS REAIS
// ---------------------------------------------------------------------
$servername = "localhost";
$username = "root";
$password = "";   // MUDE AQUI!
$dbname = "geo";

// ---------------------------------------------------------------------
// FUNÇÃO DE CONEXÃO
// ---------------------------------------------------------------------
function getConnection() {
    global $servername, $username, $password, $dbname;
    
    // Cria a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        // Em um ambiente de produção, registre o erro em vez de exibi-lo
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }
    
    // Define o charset para garantir o suporte a caracteres especiais
    $conn->set_charset("utf8mb4");
    return $conn;
}
?>