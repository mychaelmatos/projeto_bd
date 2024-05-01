<?php
include 'conection.php';

class prescrisoes
{
    private $db;

    function __construct()
    {
        $this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if (mysqli_connect_errno()) {
            echo "Erro ao conectar com o banco de dados: " . mysqli_connect_error();
            exit();
        }
    }

    public function getPrescricao($id_consulta)
    {
        $query = "SELECT * FROM prescricoes WHERE id_consulta = :id_consulta";
        $params = [
            ':id_consulta' => $id_consulta
        ];
        return $this->executeQuery($query, $params);
    }

    public function ProcedimentoAtualizaFatura($id_consulta, $id_prescricao)
    {
        $query = "CALL atualizar_fatura(:id_consulta, :id_prescricao);";
        $params = [
            ':id_consulta' => $id_consulta,
            ':id_prescricao' => $id_prescricao
        ];
        return $this->executeQuery($query, $params);
    }
    public function insertPrescricao($id_consulta, $data_fim)
    {
        $query = "INSERT INTO prescricoes (id_consulta, data_inicio, data_fim, valor_prescricao) VALUES (:id_consulta, now(), :data_fim, 0)";
        $params = [
            ':id_consulta' => $id_consulta,
            ':data_fim' => $data_fim,
        ];

        $this->executeQuery($query, $params);
    }
    public function getPrescricaoInfo($id_prescricao)
    {
        $query = " SELECT * FROM prescricao_info WHERE id_prescricao = :id_prescricao";
        $params = [
            ':id_prescricao' => $id_prescricao
        ];
        return $this->executeQuery($query, $params);
    }

    public function insertPrescricaoAux($id_prescricao, $id_medicamento, $quantidade)
    {
        $query = "INSERT INTO prescricao_has_medicamento (id_prescricao, id_medicamento, quantidade) VALUES (:id_prescricao, :id_medicamento, :quantidade)";
        $params = [
            ':id_prescricao' => $id_prescricao,
            ':id_medicamento' => $id_medicamento,
            ':quantidade' => $quantidade,
        ];

        $this->executeQuery($query, $params);
    }

    public function executeQuery($query, $params = [])
    {
        global $pdo;

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
    
    private function executeQuerySingleResult($query)
    {
        $result = mysqli_query($this->db, $query);
        if ($result) {
            return mysqli_fetch_assoc($result);
        } else {
            echo "Erro ao executar consulta: " . mysqli_error($this->db);
            exit();
        }
    }
}
