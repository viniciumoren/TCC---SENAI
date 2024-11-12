<?php
session_start();
include_once('config.php');

// Verificar se a sessão está ativa
if (!isset($_SESSION["email"]) || !isset($_SESSION["senha"])) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['status'])) {
    $id = intval($data['id']);
    $status = $data['status'];

    $sql = "UPDATE listaencomenda SET status = ? WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('si', $status, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
}

// Fechar a conexão com o banco de dados
mysqli_close($conexao);
?>
