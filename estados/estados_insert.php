<?php
require_once 'config.php';
require_once 'functions.php';

$conn = getConnection();
$paise_list = getPaise($conn); // Busca a lista de países para o dropdown

// Processamento do formulário de inserção
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $estado = $conn->real_escape_string($_POST['estado']);
    $pais_id = (int)$_POST['pais_id'];

    // Prepared statement para segurança
    $stmt = $conn->prepare("INSERT INTO ESTADOS (Estado, PaisId) VALUES (?, ?)");
    $stmt->bind_param("si", $estado, $pais_id);

    if ($stmt->execute()) {
        $message = "success|Estado '{$estado}' criado com sucesso!";
    } else {
        $message = "error|Erro ao criar estado: " . $conn->error;
    }
    $stmt->close();
    
    $conn->close();
    // Redireciona para a página principal de Estados com a mensagem de status
    header("Location: estados_index.php?msg=" . urlencode($message));
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Estado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen p-4 md:p-8">

    <div class="max-w-xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-green-400 pb-2">
            Adicionar Novo Estado
        </h1>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border border-green-100">
            <form method="POST" action="estados_insert.php" class="space-y-4">
                
                <!-- Campo Estado -->
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700">Nome do Estado</label>
                    <input type="text" name="estado" id="estado" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-2 border">
                </div>

                <!-- Dropdown País -->
                <div>
                    <label for="pais_id" class="block text-sm font-medium text-gray-700">País</label>
                    <select name="pais_id" id="pais_id" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-2 border">
                        <option value="">-- Selecione o País --</option>
                        <?php foreach ($paise_list as $pais): ?>
                            <option value="<?php echo htmlspecialchars($pais['Id']); ?>">
                                <?php echo htmlspecialchars($pais['Pais']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent bg-green-600 py-2 px-6 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150">
                        Cadastrar Estado
                    </button>
                    <a href="estados_index.php" class="w-full text-center inline-flex justify-center rounded-lg border border-gray-300 bg-white py-2 px-6 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition duration-150">
                        Voltar
                    </a>
                </div>
            </form>
        </div>

    </div>
</body>
</html>