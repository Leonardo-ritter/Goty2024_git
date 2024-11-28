<?php
session_start(); 

// CONFIGURAÇÕES DO BANCO DE DADOS
$host  = 'localhost';
$dbname = 'cadastro_dos_clientes';
$user = 'root';
$senha = ''; 

try {
    // CONECTAR AO BANCO DE DADOS
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //VERIFICA OS DADOS DE LOGIN
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = trim($_POST['login']); 
        $senha = $_POST['senha'];

        //VERIFICA CAMPOS VAZIOS
        if (empty($login) || empty($senha)) {
            echo "<p style='color: red;'>Por favor, preencha todos os campos.</p>";
            exit;
        }

        //CONSULTA NO BD PARA VERIFICAR USUARIO
        $sqlVerificarUsuario = "
            SELECT id, username, senha 
            FROM usuarios 
            WHERE username = :login OR email = :login
        ";
        $stmt = $pdo->prepare($sqlVerificarUsuario);
        $stmt->execute([':login' => $login]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        //VERIFICA SE USUARIO EXISTE E SENHA CORRETA
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['username'] = $usuario['username'];

            //REDIRECIONA PARA PRINCIPAL.PHP
            header("Location: principal.php");
            exit;
        } else {
            echo "<p style='color: red;'>Email/Username ou senha incorretos.</p>";
        }
    }
} catch (PDOException $e) {
    die("Erro ao conectar ou configurar o banco de dados: " . $e->getMessage());
}
?>
