<?php
include 'conection.php';

class tratamentos
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
    public function getTratamentoId($id_consulta)
    {
        $query = "SELECT * FROM tratamentos WHERE id_consulta = :id_consulta";
        $params = [
            ':id_consulta' => $id_consulta
        ];
        return $this->executeQuery($query, $params);
    }
    public function insertTratamento($id_consulta, $descricao, $data_fim, $valor,)
    {
        $query = "INSERT INTO tratamentos (id_consulta, descricao, data_inicio, data_fim, valor_tratamento, status) VALUES (:id_consulta, :descricao, now(), :data_fim, :valor, :status)";
        $params = [
            ':id_consulta' => $id_consulta,
            ':descricao' => $descricao,
            ':data_fim' => $data_fim,
            ':valor' => $valor,
            ':status' => 'Ativo'
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
