<?php
// Certifique-se de que a conexão esteja disponível
require_once 'config.php';

// ---------------------------------------------------------------------
// FUNÇÕES DE CIDADES
// ---------------------------------------------------------------------

// Função para buscar todos os estados (com nome do país) para dropdowns de Cidade/Estado
function getEstados(mysqli $conn) {
    // Consulta para listar estados juntamente com seus países
    $sql = "SELECT E.Id, E.Estado, P.Pais 
            FROM ESTADOS E 
            JOIN PAISES P ON E.PaisId = P.Id 
            ORDER BY P.Pais, E.Estado";
    
    $result = $conn->query($sql);
    // Retorna um array associativo de todos os resultados ou um array vazio em caso de falha
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

// Função para buscar dados de uma cidade específica
function getCidadeById(mysqli $conn, $id) {
    $stmt = $conn->prepare("SELECT Id, Cidade, EstadoId FROM CIDADES WHERE Id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cidade = $result->fetch_assoc();
    $stmt->close();
    return $cidade;
}

// ---------------------------------------------------------------------
// FUNÇÕES DE PAÍSES
// ---------------------------------------------------------------------

// Função para buscar todos os países
function getPaise(mysqli $conn) {
    $sql = "SELECT Id, Pais FROM PAISES ORDER BY Pais";
    $result = $conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

// Função para buscar dados de um país específico
function getPaisById(mysqli $conn, $id) {
    $stmt = $conn->prepare("SELECT Id, Pais FROM PAISES WHERE Id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pais = $result->fetch_assoc();
    $stmt->close();
    return $pais;
}

// ---------------------------------------------------------------------
// FUNÇÕES DE ESTADOS
// ---------------------------------------------------------------------

// Função para buscar dados de um estado específico (incluindo o PaisId)
function getEstadoById(mysqli $conn, $id) {
    $stmt = $conn->prepare("SELECT Id, Estado, PaisId FROM ESTADOS WHERE Id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $estado = $result->fetch_assoc();
    $stmt->close();
    return $estado;
}

// Função para listar estados com nomes de países para a tabela de ESTADOS
function getEstadosWithPaisName(mysqli $conn) {
    $sql = "SELECT E.Id, E.Estado, P.Pais 
            FROM ESTADOS E 
            JOIN PAISES P ON E.PaisId = P.Id 
            ORDER BY P.Pais, E.Estado";
    $result = $conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}
?>