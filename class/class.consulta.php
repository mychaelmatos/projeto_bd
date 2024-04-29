<?php
include 'conection.php';

class consultas
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

    public function getConsulta()
    {
        $query = "SELECT * FROM consultas_com_nomes;";
        return $this->executeQuery($query);
    }
    public function deleteConsulta($id_consulta)
    {
        $query = "DELETE FROM consultas WHERE id_consulta = :id_consulta";
        $params = [
            ':id_consulta' => $id_consulta
        ];
        $this->executeQuery($query, $params);
    }
    public function updateConsulta($id_consulta, $id_medico)
    {
        $query = "UPDATE consultas SET id_profissional = :id_medico WHERE id_consulta = :id_consulta";
        $params = [
            ':id_medico' => $id_medico,
            ':id_consulta' => $id_consulta
        ];
        return $this->executeQuery($query, $params);
    }
    public function getConsultaId($id)
    {
        $query = "SELECT * FROM consultas WHERE id_consulta = :id";
        $params = [
            ':id' => $id
        ];
        return $this->executeQuery($query, $params);
    }
    public function getConsultaY()
    {
        $query = "SELECT * FROM consultas_com_nomesY;";
        return $this->executeQuery($query);
    }

    public function insertConsulta($id_paciente, $id_medico, $motivo)
    {
        $query = "INSERT INTO consultas (id_paciente, id_profissional, data_consulta, motivo) VALUES (:id_paciente, :id_medico, now(), :motivo)";
        $params = [
            ':id_paciente' => $id_paciente,
            ':id_medico' => $id_medico,
            ':motivo' => $motivo
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
