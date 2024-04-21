<?php
include 'conection.php';

class medicos
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

    public function getMedico()
    {
        $query = "SELECT * FROM medico";
        return $this->executeQuery($query);
    }
    public function getMedicoId($id)
    {
        $query = "SELECT * FROM medico WHERE numero_licenca = :id";
        $params = [
            ':id' => $id
        ];
        return $this->executeQuery($query, $params);
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
