<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "cadastro_dos_clientes");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Dados enviados via POST
$usuario_id = intval($_POST['usuario_id']);
$jogo_id = intval($_POST['jogo_id']);

// Verifica se o usuário já votou nesse jogo
$sql_verificar = "SELECT * FROM votos WHERE usuario_id = ? AND jogo_id = ?";
$stmt = $conn->prepare($sql_verificar);
$stmt->bind_param("ii", $usuario_id, $jogo_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo "Voce já realizou o voto, Obrigado!";
} else {
    
    // Insere o voto no banco de dados
    $sql_inserir = "INSERT INTO votos (usuario_id, jogo_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql_inserir);
    $stmt->bind_param("ii", $usuario_id, $jogo_id);
    
    if ($stmt->execute()) {
        echo "Voto registrado com sucesso!";
    } else {
        echo "Erro ao registrar voto!";
    }
}

$stmt->close();
$conn->close();
?>
