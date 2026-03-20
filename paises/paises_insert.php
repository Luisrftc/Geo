<?php
require_once 'config.php';

// Processamento do formulário de inserção
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = getConnection();
    $pais = $conn->real_escape_string($_POST['pais']);

    // Prepared statement para segurança
    $stmt = $conn->prepare("INSERT INTO PAISES (Pais) VALUES (?)");
    $stmt->bind_param("s", $pais);

    if ($stmt->execute()) {
        $message = "success|País '{$pais}' criado com sucesso!";
    } else {
        $message = "error|Erro ao criar país: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
    
    // Redireciona para a página principal de Países com a mensagem de status
    header("Location: paises_index.php?msg=" . urlencode($message));
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar País</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen p-4 md:p-8">

    <div class="max-w-xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-red-400 pb-2">
            Adicionar Novo País
        </h1>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border border-red-100">
            <form method="POST" action="paises_insert.php" class="space-y-4">
                
                <!-- Campo País -->
                <div>
                    <label for="pais" class="block text-sm font-medium text-gray-700">Nome do País</label>
                    <input type="text" name="pais" id="pais" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 p-2 border">
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent bg-red-600 py-2 px-6 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150">
                        Cadastrar País
                    </button>
                    <a href="paises_index.php" class="w-full text-center inline-flex justify-center rounded-lg border border-gray-300 bg-white py-2 px-6 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition duration-150">
                        Voltar
                    </a>
                </div>
            </form>
        </div>

    </div>
</body>
</html>