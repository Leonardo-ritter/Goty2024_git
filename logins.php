<?php

// CONFIGURAÇÕES DO BANCO DE DADOS
$host  = 'localhost';
$dbname = 'cadastro_dos_clientes';
$user = 'root';
$senha = ''; // Senha correta ou vazia para localhost sem senha

try {
    // CONECTAR AO BANCO DE DADOS
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // VERIFICAR OS DADOS DE LOGIN DO FORM.
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = trim($_POST['login']); // Remove espaços em branco
        $senha = $_POST['senha'];

        // VERIFICA SE OS CAMPOS ESTÃO VAZIOS
        if (empty($login) || empty($senha)) {
            echo "Por favor, preencha todos os campos.";
            exit;
        }

        // CONSULTAR O BANCO DE DADOS PARA VERIFICAR O USUÁRIO
        $sqlVerificarUsuario = "
            SELECT * 
            FROM usuarios 
            WHERE email = :login OR username = :login
        ";
        $stmt = $pdo->prepare($sqlVerificarUsuario);
        $stmt->execute([':login' => $login]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // VERIFICAR SE O USUÁRIO EXISTE E SE A SENHA ESTÁ CORRETA
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // INICIAR SESSÃO PARA ARMAZENAR OS DADOS DO USUÁRIO
            session_start();
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['username'] = $usuario['username'];

            // REDIRECIONAR PARA A PÁGINA DE DESTINO
            header("Location: principal.php");
            exit;
        } else {
            echo "Email/Username ou senha incorretos.";
        }
    }
} catch (PDOException $e) {
    die("Erro ao conectar ou configurar o banco de dados: " . $e->getMessage());
}
?>
