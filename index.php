<?php
// Arquivo principal para navegação entre os CRUDS
// Não precisa de conexão com o banco aqui, apenas links.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - CRUD Geográfico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-4 md:p-12">

    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-yellow-500 pb-2 text-center">
            Sistema de Registro de Localidades
        </h1>
        <p class="text-center text-gray-600 mb-10">
            Selecione a tabela que deseja gerenciar:
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Card CIDADES -->
            <a href="cidades_index.php" class="block bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl transition duration-300 transform hover:scale-[1.02] border-t-4 border-indigo-500">
                <div class="text-4xl mb-4 text-indigo-600">🏙️</div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Cidades</h2>
                <p class="text-gray-500">Gerenciar Cidades (relacionadas a Estados).</p>
            </a>

            <!-- Card ESTADOS -->
            <a href="estados_index.php" class="block bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl transition duration-300 transform hover:scale-[1.02] border-t-4 border-green-500">
                <div class="text-4xl mb-4 text-green-600">📍</div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Estados</h2>
                <p class="text-gray-500">Gerenciar Estados (relacionados a Países).</p>
            </a>

            <!-- Card PAÍSES -->
            <a href="paises_index.php" class="block bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl transition duration-300 transform hover:scale-[1.02] border-t-4 border-red-500">
                <div class="text-4xl mb-4 text-red-600">🌍</div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Países</h2>
                <p class="text-gray-500">Gerenciar Países (tabela base).</p>
            </a>
        </div>

        <p class="text-sm text-gray-400 mt-12 text-center">
            Estrutura de dados: CIDADES → ESTADOS → PAISES.
        </p>
    </div>
</body>
</html>