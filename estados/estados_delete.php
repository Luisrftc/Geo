<?php
require_once 'config.php';

// Este script só processa requisições POST para evitar exclusão acidental via URL
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = getConnection();
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    if ($id > 0) {
        // Prepared statement para segurança
        $stmt = $conn->prepare("DELETE FROM ESTADOS WHERE Id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $message = "success|Estado e suas cidades associadas foram excluídos com sucesso!";
        } else {
            $message = "error|Erro ao excluir estado: " . $conn->error;
        }
        $stmt->close();
    } else {
        $message = "error|ID inválido para exclusão.";
    }
    
    $conn->close();
    // Redireciona para a página principal com a mensagem de status
    header("Location: estados_index.php?msg=" . urlencode($message));
    exit();
} else {
    // Se não for POST, redireciona sem fazer nada
    header("Location: estados_index.php");
    exit();
}
?>