<?php
/**
 * Arquivo de conexão com o banco de dados MySQL
 * Sistema VERUS - Clima Organizacional
 */

// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'verus_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

/**
 * Classe para conexão com o banco de dados
 */
class Database {
    private $connection;
    private static $instance = null;
    
    /**
     * Construtor privado para implementar Singleton
     */
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
            
        } catch (PDOException $e) {
            error_log("Erro na conexão com o banco de dados: " . $e->getMessage());
            throw new Exception("Erro na conexão com o banco de dados");
        }
    }
    
    /**
     * Método para obter instância única (Singleton)
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Obter conexão PDO
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Executar query preparada
     */
    public function executeQuery($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erro na execução da query: " . $e->getMessage());
            throw new Exception("Erro na execução da query");
        }
    }
    
    /**
     * Buscar um registro
     */
    public function fetchOne($sql, $params = []) {
        $stmt = $this->executeQuery($sql, $params);
        return $stmt->fetch();
    }
    
    /**
     * Buscar múltiplos registros
     */
    public function fetchAll($sql, $params = []) {
        $stmt = $this->executeQuery($sql, $params);
        return $stmt->fetchAll();
    }
    
    /**
     * Inserir registro
     */
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        
        $stmt = $this->executeQuery($sql, $data);
        return $this->connection->lastInsertId();
    }
    
    /**
     * Atualizar registro
     */
    public function update($table, $data, $where, $whereParams = []) {
        $setClause = [];
        foreach (array_keys($data) as $column) {
            $setClause[] = "{$column} = :{$column}";
        }
        $setClause = implode(', ', $setClause);
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        $params = array_merge($data, $whereParams);
        
        $stmt = $this->executeQuery($sql, $params);
        return $stmt->rowCount();
    }
    
    /**
     * Deletar registro
     */
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->executeQuery($sql, $params);
        return $stmt->rowCount();
    }
    
    /**
     * Iniciar transação
     */
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    /**
     * Confirmar transação
     */
    public function commit() {
        return $this->connection->commit();
    }
    
    /**
     * Reverter transação
     */
    public function rollback() {
        return $this->connection->rollback();
    }
    
    /**
     * Verificar se está em transação
     */
    public function inTransaction() {
        return $this->connection->inTransaction();
    }
}

/**
 * Função helper para obter conexão
 */
function getDB() {
    return Database::getInstance();
}

/**
 * Função para criar as tabelas do banco de dados
 */
function createTables() {
    try {
        $db = getDB();
        $pdo = $db->getConnection();
        
        // Tabela de empresas
        $sqlEmpresas = "
        CREATE TABLE IF NOT EXISTS empresas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            cnpj VARCHAR(18) UNIQUE NOT NULL,
            nome VARCHAR(255) NOT NULL,
            setor VARCHAR(100),
            email VARCHAR(255),
            senha VARCHAR(255) NOT NULL,
            data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            ativo BOOLEAN DEFAULT TRUE
        )";
        
        // Tabela de funcionários
        $sqlFuncionarios = "
        CREATE TABLE IF NOT EXISTS funcionarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) UNIQUE NOT NULL,
            nome VARCHAR(255) NOT NULL,
            empresa_id INT,
            cargo VARCHAR(100),
            senha VARCHAR(255) NOT NULL,
            data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            ativo BOOLEAN DEFAULT TRUE,
            FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE SET NULL
        )";
        
        // Tabela de questionários
        $sqlQuestionarios = "
        CREATE TABLE IF NOT EXISTS questionarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            funcionario_id INT,
            empresa_id INT,
            satisfacaoGeral INT CHECK (satisfacaoGeral BETWEEN 1 AND 5),
            comunicacao INT CHECK (comunicacao BETWEEN 1 AND 5),
            ambiente INT CHECK (ambiente BETWEEN 1 AND 5),
            reconhecimento INT CHECK (reconhecimento BETWEEN 1 AND 5),
            crescimento INT CHECK (crescimento BETWEEN 1 AND 5),
            equilibrio INT CHECK (equilibrio BETWEEN 1 AND 5),
            sugestoes TEXT,
            data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            anonimo BOOLEAN DEFAULT TRUE,
            FOREIGN KEY (funcionario_id) REFERENCES funcionarios(id) ON DELETE SET NULL,
            FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE
        )";
        
        // Tabela de feedback sobre soluções
        $sqlFeedback = "
        CREATE TABLE IF NOT EXISTS feedback_solucoes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            empresa_id INT,
            funcionario_id INT,
            feedback TEXT NOT NULL,
            categoria VARCHAR(100),
            data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            anonimo BOOLEAN DEFAULT TRUE,
            FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE,
            FOREIGN KEY (funcionario_id) REFERENCES funcionarios(id) ON DELETE SET NULL
        )";
        
        // Tabela de sessões
        $sqlSessoes = "
        CREATE TABLE IF NOT EXISTS sessoes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT NOT NULL,
            tipo_usuario ENUM('funcionario', 'empresa') NOT NULL,
            token VARCHAR(255) UNIQUE NOT NULL,
            data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            data_expiracao TIMESTAMP NULL,
            ativo BOOLEAN DEFAULT TRUE
        )";
        
        // Executar criação das tabelas
        $pdo->exec($sqlEmpresas);
        $pdo->exec($sqlFuncionarios);
        $pdo->exec($sqlQuestionarios);
        $pdo->exec($sqlFeedback);
        $pdo->exec($sqlSessoes);
        
        return true;
        
    } catch (Exception $e) {
        error_log("Erro ao criar tabelas: " . $e->getMessage());
        return false;
    }
}

/**
 * Função para inserir dados de exemplo
 */
function insertSampleData() {
    try {
        $db = getDB();
        
        // Inserir empresa de exemplo
        $empresaData = [
            'cnpj' => '12.345.678/0001-90',
            'nome' => 'Empresa Teste LTDA',
            'setor' => 'Tecnologia',
            'email' => 'contato@empresateste.com',
            'senha' => '123456' // Senha em texto simples
        ];
        
        $empresaId = $db->insert('empresas', $empresaData);
        
        // Inserir funcionário de exemplo
        $funcionarioData = [
            'email' => 'funcionario@empresateste.com',
            'nome' => 'João Silva',
            'empresa_id' => $empresaId,
            'cargo' => 'Desenvolvedor',
            'senha' => '123456' // Senha em texto simples
        ];
        
        $funcionarioId = $db->insert('funcionarios', $funcionarioData);
        
        // Inserir questionário de exemplo
        $questionarioData = [
            'funcionario_id' => $funcionarioId,
            'empresa_id' => $empresaId,
            'comunicacao' => 4,
            'ambiente' => 5,
            'reconhecimento' => 3,
            'crescimento' => 4,
            'equilibrio' => 4,
            'sugestoes' => 'Gostaria de mais oportunidades de treinamento e desenvolvimento profissional.'
        ];
        
        $db->insert('questionarios', $questionarioData);
        
        return true;
        
    } catch (Exception $e) {
        error_log("Erro ao inserir dados de exemplo: " . $e->getMessage());
        return false;
    }
}

/**
 * Função para verificar se o banco de dados existe
 */
function checkDatabaseExists() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        
        $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . DB_NAME . "'");
        return $stmt->rowCount() > 0;
        
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Função para criar o banco de dados se não existir
 */
function createDatabaseIfNotExists() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        
        $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        return true;
        
    } catch (PDOException $e) {
        error_log("Erro ao criar banco de dados: " . $e->getMessage());
        return false;
    }
}

/**
 * Função para inicializar o banco de dados
 */
function initializeDatabase() {
    if (!checkDatabaseExists()) {
        if (!createDatabaseIfNotExists()) {
            throw new Exception("Não foi possível criar o banco de dados");
        }
    }
    
    if (!createTables()) {
        throw new Exception("Não foi possível criar as tabelas");
    }
    
    // Inserir dados de exemplo apenas se não existirem
    $db = getDB();
    $empresas = $db->fetchAll("SELECT COUNT(*) as total FROM empresas");
    
    if ($empresas[0]['total'] == 0) {
        insertSampleData();
    }
    
    return true;
}

// Inicializar banco de dados automaticamente
try {
    initializeDatabase();
} catch (Exception $e) {
    error_log("Erro na inicialização do banco de dados: " . $e->getMessage());
}
?>
