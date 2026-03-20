<?php
require_once 'config.php';
require_once 'functions.php';

// Conexão
$conn = getConnection();
// Usa a função que retorna estados com o nome do país
$estados = getEstadosWithPaisName($conn); 
$conn->close();

// Mensagem de status via parâmetro GET após redirecionamento
$status_message = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Estados</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen p-4 md:p-8">

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6 border-b-4 border-green-500 pb-2">
            <h1 class="text-4xl font-extrabold text-gray-800">
                Gestão de Estados 📍
            </h1>
            <a href="index.php" class="text-sm font-medium text-green-600 hover:text-green-800 transition duration-150">
                ← Voltar ao Início
            </a>
        </div>

        <!-- Botão de Criação -->
        <div class="mb-6 flex justify-end">
            <a href="estados_insert.php" class="inline-flex justify-center rounded-lg border border-transparent bg-green-600 py-2 px-6 text-sm font-medium text-white shadow-sm hover:bg-green-700 transition duration-150">
                + Adicionar Novo Estado
            </a>
        </div>

        <!-- Área de Mensagens de Status -->
        <?php if (!empty($status_message)): 
            list($type, $message) = explode('|', $status_message, 2);
            $bgColor = $type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
            $icon = $type === 'success' ? '✅' : '❌';
        ?>
        <div class="p-4 mb-6 border-l-4 rounded-lg shadow-md <?php echo $bgColor; ?>" role="alert">
            <p class="font-bold"><?php echo $icon; ?> <?php echo ($type === 'success' ? 'Sucesso' : 'Erro'); ?></p>
            <p><?php echo html_entity_decode($message); ?></p>
        </div>
        <?php endif; ?>

        <!-- Tabela de Listagem (READ) -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-green-100 overflow-x-auto">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Estados Cadastrados</h2>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">País</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($estados)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Nenhum estado encontrado.
                            </td>
                        </tr>
                    <?php endif; ?>
                    
                    <?php foreach ($estados as $estado): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?php echo htmlspecialchars($estado['Id']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo htmlspecialchars($estado['Estado']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo htmlspecialchars($estado['Pais']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <!-- Link para UPDATE -->
                            <a href="estados_update.php?id=<?php echo htmlspecialchars($estado['Id']); ?>" class="text-indigo-600 hover:text-indigo-900 transition duration-150">
                                Editar
                            </a>
                            <!-- Formulário de DELETE -->
                            <form method="POST" action="estados_delete.php" class="inline-block" onsubmit="return confirm('ATENÇÃO: Excluir o estado \'<?php echo htmlspecialchars($estado['Estado']); ?>\' também excluirá todas as suas cidades associadas. Deseja continuar?');">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($estado['Id']); ?>">
                                <button type="submit" class="text-red-600 hover:text-red-900 transition duration-150">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>