<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Você precisa estar logado para votar.";
    exit;
}

$host = 'localhost';
$dbname = 'cadastro_dos_clientes';
$user = 'root';
$senha = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $usuario_id = $_SESSION['user_id'];
    $jogo_id = $_POST['jogo_id'];

    //VERIFICA SE VOTOU EM ALGUM OUTRO JOGO
    $sqlVerificarVoto = "SELECT COUNT(*) FROM votos WHERE usuario_id = :usuario_id";
    $stmt = $pdo->prepare($sqlVerificarVoto);
    $stmt->execute([':usuario_id' => $usuario_id]);
    $votoExistente = $stmt->fetchColumn();

    if ($votoExistente > 0) {
        echo "Você já votou em outro jogo. Você pode votar apenas uma vez.";
        exit;
    }

    //SE NAO HOUVER VOTO IRÁ REGISTRAR O VOTO.
    $sqlRegistrarVoto = "INSERT INTO votos (usuario_id, jogo_id) VALUES (:usuario_id, :jogo_id)";
    $stmt = $pdo->prepare($sqlRegistrarVoto);
    $stmt->execute([':usuario_id' => $usuario_id, ':jogo_id' => $jogo_id]);

    echo "Voto registrado com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao conectar ou registrar o voto: " . $e->getMessage();
}
?>
