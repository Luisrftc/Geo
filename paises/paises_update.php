<?php
require_once 'config.php';
require_once 'functions.php';

$conn = getConnection();
$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
$pais_data = [];

// Busca dados existentes para preencher o formulário
if ($id > 0) {
    $pais_data = getPaisById($conn, $id);
    if (!$pais_data) {
        $message = "error|País não encontrado.";
        $conn->close();
        header("Location: paises_index.php?msg=" . urlencode($message));
        exit();
    }
} else {
    $message = "error|ID inválido para edição.";
    $conn->close();
    header("Location: paises_index.php?msg=" . urlencode($message));
    exit();
}

// Processamento do formulário de atualização
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pais = $conn->real_escape_string($_POST['pais']);

    // Prepared statement para segurança
    $stmt = $conn->prepare("UPDATE PAISES SET Pais = ? WHERE Id = ?");
    $stmt->bind_param("si", $pais, $id);

    if ($stmt->execute()) {
        $message = "success|País '{$pais}' atualizado com sucesso!";
    } else {
        $message = "error|Erro ao atualizar país: " . $conn->error;
    }
    $stmt->close();
    
    $conn->close();
    // Redireciona para a página principal com a mensagem de status
    header("Location: paises_index.php?msg=" . urlencode($message));
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar País</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen p-4 md:p-8">

    <div class="max-w-xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-red-400 pb-2">
            Editar País: <?php echo htmlspecialchars($pais_data['Pais']); ?>
        </h1>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border border-red-100">
            <form method="POST" action="paises_update.php" class="space-y-4">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($pais_data['Id']); ?>">
                
                <!-- Campo País -->
                <div>
                    <label for="pais" class="block text-sm font-medium text-gray-700">Nome do País</label>
                    <input type="text" name="pais" id="pais" value="<?php echo htmlspecialchars($pais_data['Pais']); ?>" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 p-2 border">
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent bg-green-600 py-2 px-6 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150">
                        Salvar Alterações
                    </button>
                    <a href="paises_index.php" class="w-full text-center inline-flex justify-center rounded-lg border border-gray-300 bg-white py-2 px-6 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition duration-150">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

    </div>
</body>
</html>