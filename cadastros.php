<?php

    //CONFIGURAÇÕES DO BANCO DE DADOS
    $host = 'localhost';
    $dbname = 'cadastro_dos_clientes';
    $user = 'root';
    $senha = '';

    try {
        //CONEXÃO INICIAL SEM SELECIONAR O BANCO DE DADOS
        $pdo = new PDO("mysql:host=$host", $user, $senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //CRIAR BANCO DE DADO CASO NÃO EXISTA
        $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");

        //RECONECTAR AGORA SELECIONANDO O BANCO DE DADOS
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //CRIAR TABELA PRINCIPAL PARA ARMAZENAR AS INFORMAÇÕES DOS USUÁRIOS
        $sqlTabelaPrincipal = "CREATE TABLE IF NOT EXISTS 
        usuarios( 
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(20) NOT NULL,
            sobrenome VARCHAR(20) NOT NULL,
            username VARCHAR(50) UNIQUE NOT NULL,
            telefone VARCHAR(13),
            email VARCHAR(100) UNIQUE NOT NULL,
            senha VARCHAR(255) NOT NULL); 
        ";
        $pdo->exec($sqlTabelaPrincipal);

        //CRIAR TABELA SECUNDÁRIA PARA OS DADOS ESPECÍFICOS DOS USUÁRIOS
        $sqlTabelaSecundaria = "CREATE TABLE IF NOT EXISTS dados_usuario (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            descricao TEXT,
            FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
        );";
        $pdo->exec($sqlTabelaSecundaria);

        //VERIFICA OS DADOS DO FORM.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $sobrenome = $_POST['sobrenome'];
            $username = $_POST['username'];
            $telefone = $_POST['telefone'];
            $email = $_POST['email'];
            $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); //CRIPTOGRAFANDO A SENHA

            //INSERÇÃO NO BANCO DE DADOS [TABELA PRINCIPAL];
            $sqlInsercao = "INSERT INTO usuarios(nome, sobrenome, username, telefone, email, senha) VALUES (:nome, :sobrenome, :username, :telefone, :email, :senha)";
            $stmt = $pdo->prepare($sqlInsercao);
            $stmt->execute([
                ':nome' => $nome,
                ':sobrenome' => $sobrenome,
                ':username' => $username,
                ':telefone' => $telefone,
                ':email' => $email,
                ':senha' => $senha,
            ]);

            //OBTER O ID DO USUÁRIO CADASTRADO
            $userId = $pdo->lastInsertId();

            //INSERIR UM REGISTRO INICIAL NA TABELA SECUNDÁRIA
            $sqlInserirDados = "INSERT INTO dados_usuario(user_id, descricao) VALUES (:user_id, :descricao)";
            $stmt = $pdo->prepare($sqlInserirDados);
            $stmt->execute([
                ':user_id' => $userId,
                ':descricao' => "Conta criada para o usuário $username.",
            ]);

            echo "Usuário cadastrado com sucesso e dados adicionais registrados!";
        }

    } catch (PDOException $e) {
        die("Erro ao conectar ou configurar o banco de dados: " . $e->getMessage());  
    }

?>
