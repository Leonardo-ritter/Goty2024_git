<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'cadastro_dos_clientes'; // Nome do banco de dados
$user = 'root'; // Usuário do banco
$senha = ''; // Senha do banco de dados (em ambiente local pode ser vazia)

// Conectar ao banco de dados usando PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obter os votos registrados
    $sql = "SELECT v.voto_id, u.nome AS usuario_nome, j.nome AS jogo_nome 
            FROM votos v
            JOIN usuarios u ON v.usuario_id = u.id
            JOIN jogos j ON v.jogo_id = j.id
            ORDER BY v.voto_id DESC";
    
    // Preparar e executar a consulta
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Recuperar os resultados da consulta
    $votos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Caso haja erro na conexão
    echo "Erro ao consultar votos: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Votos</title>
    <link rel="stylesheet" href="style_principal.css"> <!-- Estilos aplicados à página -->
</head>
<body>

    <!-- Cabeçalho da página -->
    <header>
        <h1>Relatório de Votos Registrados</h1>
    </header>

    <!-- Seção que exibe os votos -->
    <div class="relatorio-container">
        <table>
            <thead>
                <tr>
                    <th>ID do Voto</th>
                    <th>Nome do Usuário</th>
                    <th>Nome do Jogo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($votos as $voto): ?>
                    <tr>
                        <td><?= htmlspecialchars($voto['voto_id']) ?></td>
                        <td><?= htmlspecialchars($voto['usuario_nome']) ?></td>
                        <td><?= htmlspecialchars($voto['jogo_nome']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
