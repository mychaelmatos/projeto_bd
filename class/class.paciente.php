<?php
include 'conection.php';

class paciente
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

    public function getPaciente()
    {
        $query = "SELECT * FROM pacientes";
        return $this->executeQuery($query);
    }

    public function getPacienteId($id)
    {
        $query = "SELECT * FROM pacientes WHERE id_paciente = :id";
        $params = [
            ':id' => $id
        ];
        return $this->executeQuery($query, $params);
    }

    public function getPacienteEmail($email)
    {
        $query = "SELECT * FROM pacientes WHERE email = :email";
        $params = [
            ':email' => $email
        ];
        return $this->executeQuery($query, $params);
    }
    

    public function insertPaciente($nome, $sobrenome, $data_nascimento, $sexo, $endereco, $telefone, $email)
    {
        $query = "INSERT INTO pacientes (primeiro_nome, sobrenome, data_nascimento, sexo, endereco, telefone, email, ativo) VALUES (:nome, :sobrenome, :data_nascimento, :sexo, :endereco, :telefone, :email, 'Y')";
        $params = [
            ':nome' => $nome,
            ':sobrenome' => $sobrenome,
            ':data_nascimento' => $data_nascimento,
            ':sexo' => $sexo,
            ':endereco' => $endereco,
            ':telefone' => $telefone,
            ':email' => $email
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
