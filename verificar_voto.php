<?php
session_start();

//VERIFICA SE ESTA LOCAGO NA SESSAO
if (!isset($_SESSION['user_id'])) {
    echo "Você precisa estar logado para verificar seu voto.";
    exit;
}

// CONECTAR BD
$host = 'localhost';
$dbname = 'cadastro_dos_clientes';
$user = 'root';
$senha = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //RECUPERA ID DO USUARIO
    $usuario_id = $_SESSION['user_id'];

    //VERIFICA SE O USUARIO JA VOTOU EM ALGUM JOGO
    $sqlVerificarVoto = "SELECT COUNT(*) FROM votos WHERE usuario_id = :usuario_id";
    $stmt = $pdo->prepare($sqlVerificarVoto);
    $stmt->execute([':usuario_id' => $usuario_id]);
    $votoExistente = $stmt->fetchColumn();

    if ($votoExistente > 0) {
        echo "Você já votou em outro jogo. Você pode votar apenas uma vez.";
    } else {
        echo "Pode votar!";
    }
} catch (PDOException $e) {
    echo "Erro ao verificar voto: " . $e->getMessage();
}
?>
