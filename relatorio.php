<?php

$host = 'localhost';
$dbname = 'cadastro_dos_clientes'; 
$user = 'root'; 
$senha = ''; 


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT v.id, u.nome AS usuario_nome, j.nome AS jogo_nome 
            FROM votos v
            JOIN usuarios u ON v.usuario_id = u.id
            JOIN jogos j ON v.jogo_id = j.id
            ORDER BY v.id DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $votos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql_contagem = "SELECT j.nome AS jogo_nome, COUNT(v.id) AS total_votos
                     FROM votos v
                     JOIN jogos j ON v.jogo_id = j.id
                     GROUP BY j.id";
    $stmt_contagem = $pdo->prepare($sql_contagem);
    $stmt_contagem->execute();
    $contagem_votos = $stmt_contagem->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
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
    <link rel="stylesheet" href="style_relatorio.css">
</head>
<body>

    <header>
        <h1>Relatório de Votos Registrados</h1>
    </header>

    <div class="cabecalho">
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
                        <td><?= htmlspecialchars($voto['id']) ?></td>
                        <td><?= htmlspecialchars($voto['usuario_nome']) ?></td>
                        <td><?= htmlspecialchars($voto['jogo_nome']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Contagem de Votos por Jogo</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome do Jogo</th>
                    <th>Total de Votos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contagem_votos as $voto): ?>
                    <tr>
                        <td><?= htmlspecialchars($voto['jogo_nome']) ?></td>
                        <td><?= htmlspecialchars($voto['total_votos']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
