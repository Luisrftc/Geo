<?php
require_once 'config.php';
require_once 'functions.php';

$conn = getConnection();
$estados_list = getEstados($conn);

// Processamento do formulário de inserção
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cidade = $conn->real_escape_string($_POST['cidade']);
    $estado_id = (int)$_POST['estado_id'];

    // Prepared statement para segurança
    $stmt = $conn->prepare("INSERT INTO CIDADES (Cidade, EstadoId) VALUES (?, ?)");
    $stmt->bind_param("si", $cidade, $estado_id);

    if ($stmt->execute()) {
        $message = "success|Cidade '{$cidade}' criada com sucesso!";
    } else {
        $message = "error|Erro ao criar cidade: " . $conn->error;
    }
    $stmt->close();
    
    $conn->close();
    // Redireciona para a página principal com a mensagem de status
    header("Location: cidades_index.php?msg=" . urlencode($message));
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Cidade</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen p-4 md:p-8">

    <div class="max-w-xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-indigo-400 pb-2">
            Adicionar Nova Cidade
        </h1>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border border-indigo-100">
            <form method="POST" action="cidades_insert.php" class="space-y-4">
                
                <!-- Campo Cidade -->
                <div>
                    <label for="cidade" class="block text-sm font-medium text-gray-700">Nome da Cidade</label>
                    <input type="text" name="cidade" id="cidade" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                </div>

                <!-- Dropdown Estado -->
                <div>
                    <label for="estado_id" class="block text-sm font-medium text-gray-700">Estado e País</label>
                    <select name="estado_id" id="estado_id" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                        <option value="">-- Selecione o Estado --</option>
                        <?php foreach ($estados_list as $estado): ?>
                            <option value="<?php echo htmlspecialchars($estado['Id']); ?>">
                                <?php echo htmlspecialchars($estado['Estado'] . ' (' . $estado['Pais'] . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent bg-indigo-600 py-2 px-6 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                        Cadastrar Cidade
                    </button>
                    <a href="cidades_index.php" class="w-full text-center inline-flex justify-center rounded-lg border border-gray-300 bg-white py-2 px-6 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition duration-150">
                        Voltar
                    </a>
                </div>
            </form>
        </div>

    </div>
</body>
</html>