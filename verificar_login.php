<?php
session_start();

header('Content-Type: application/json');

//VERIFICA SE ESTA CORRETO NA SESSAO
if (isset($_SESSION['user_id'])) {
    echo json_encode(['logado' => true, 'usuario_id' => $_SESSION['user_id']]);
} else {
    echo json_encode(['logado' => false]);
}
?>
