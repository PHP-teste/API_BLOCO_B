<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include 'conexao.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method){
case 'GET':
    $where = [];
    $params = [];
    $tipos = '';

    // Filtro sala (texto com LIKE)
    if (isset($_GET['sala'])) {
        $where[] = "SALA LIKE ?";
        $params[] = "%" . $_GET['sala'] . "%";
        $tipos .= 's';
    }

    // Filtros para assentos
    if (isset($_GET['assentos_menor'])) {
        $where[] = "ASSENTOS < ?";
        $params[] = (int)$_GET['assentos_menor'];
        $tipos .= 'i';
    }

    if (isset($_GET['assentos_maior'])) {
        $where[] = "ASSENTOS > ?";
        $params[] = (int)$_GET['assentos_maior'];
        $tipos .= 'i';
    }

    // Filtro microfone
    if (isset($_GET['microfone'])) {
        if ($_GET['microfone'] === 'sim') {
            $where[] = "MICROFONES > 0";
        } elseif ($_GET['microfone'] === 'nao') {
            $where[] = "MICROFONES = 0";
        }
    }

    // Filtro monitor
    if (isset($_GET['monitor'])) {
        if ($_GET['monitor'] === 'sim') {
            $where[] = "MONITORES > 0";
        } elseif ($_GET['monitor'] === 'nao') {
            $where[] = "MONITORES = 0";
        }
    }

    // Filtro projetor
    if (isset($_GET['projetor'])) {
        if ($_GET['projetor'] === 'sim') {
            $where[] = "PROJETORES > 0";
        } elseif ($_GET['projetor'] === 'nao') {
            $where[] = "PROJETORES = 0";
        }
    }

    // Filtro lousa (mais de 1)
    if (isset($_GET['lousa_mais_de_um'])) {
        if ($_GET['lousa_mais_de_um'] === 'sim') {
            $where[] = "LOUSAS > 1";
        } elseif ($_GET['lousa_mais_de_um'] === 'nao') {
            $where[] = "LOUSAS <= 1";
        }
    }

    $sql = "SELECT * FROM Bloco_B";
    if (count($where) > 0) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }

    $stmt = $conn->prepare($sql);

    if (count($params) > 0) {
        $stmt->bind_param($tipos, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $Bloco_B = [];
    while ($row = $result->fetch_assoc()) {
        $Bloco_B[] = $row;
    }
    echo json_encode($Bloco_B);
    break;

    case 'POST':
        $dados = json_decode(file_get_contents('php://input'), true);
        if (!$dados) {
            echo json_encode(['error' => 'Dados inválidos.']);
            exit;
        }

        $sala = $dados['SALA'] ?? '';
        $andar = $dados['ANDAR'] ?? '';
        $assentos = $dados['ASSENTOS'] ?? 0;
        $monitores = $dados['MONITORES'] ?? 0;
        $projetores = $dados['PROJETORES'] ?? 0;
        $lousas = $dados['LOUSAS'] ?? 0;
        $microfones = $dados['MICROFONES'] ?? 0;

        $sql = "INSERT INTO Bloco_B (SALA, ANDAR, ASSENTOS, MONITORES, PROJETORES, LOUSAS, MICROFONES)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiiii", $sala, $andar, $assentos, $monitores, $projetores, $lousas, $microfones);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Registro criado com sucesso!']);
        } else {
            echo json_encode(['error' => 'Erro ao criar o registro.']);
        }
        break;

    case 'PUT':
       case 'PUT':
    parse_str($_SERVER['QUERY_STRING'], $query);
    $id = $query['ID'] ?? null;

    if (!$id) {
        echo json_encode(['error' => 'ID não informado para atualização.']);
        exit;
    }

    $dados = json_decode(file_get_contents('php://input'), true);
    if (!$dados) {
        echo json_encode(['error' => 'Dados inválidos para atualização.']);
        exit;
    }

    // Buscar registro atual
    $sql_select = "SELECT * FROM Bloco_B WHERE ID=?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['error' => 'Registro não encontrado para atualização.']);
        exit;
    }

    $registro_atual = $result->fetch_assoc();

    // Mesclar dados novos com os existentes
    $sala = $dados['SALA'] ?? $registro_atual['SALA'];
    $andar = $dados['ANDAR'] ?? $registro_atual['ANDAR'];
    $assentos = $dados['ASSENTOS'] ?? $registro_atual['ASSENTOS'];
    $monitores = $dados['MONITORES'] ?? $registro_atual['MONITORES'];
    $projetores = $dados['PROJETORES'] ?? $registro_atual['PROJETORES'];
    $lousas = $dados['LOUSAS'] ?? $registro_atual['LOUSAS'];
    $microfones = $dados['MICROFONES'] ?? $registro_atual['MICROFONES'];

    // Atualizar registro com os valores mesclados
    $sql_update = "UPDATE Bloco_B SET SALA=?, ANDAR=?, ASSENTOS=?, MONITORES=?, PROJETORES=?, LOUSAS=?, MICROFONES=? WHERE ID=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param(
        "ssiiiiii",
        $sala, $andar, $assentos, $monitores, $projetores, $lousas, $microfones, $id
    );

    if ($stmt_update->execute()) {
        echo json_encode(['message' => 'Registro atualizado com sucesso!']);
    } else {
        echo json_encode(['error' => 'Erro ao atualizar o registro.']);
    }

    $stmt_select->close();
    $stmt_update->close();
    break;

    case 'DELETE':
        parse_str($_SERVER['QUERY_STRING'], $query);
        $id = $query['ID'] ?? null;

        if (!$id) {
            echo json_encode(['error' => 'ID não informado para exclusão.']);
            exit;
        }

        $sql = "DELETE FROM Bloco_B WHERE ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Registro removido com sucesso!']);
        } else {
            echo json_encode(['error' => 'Erro ao remover o registro.']);
        }
        break;
}
$conn->close();
?>
