<?php

class DatabaseConnection {
    // Propriétés privées pour la configuration
    private string $host;
    private string $dbname;
    private string $username;
    private string $password;
    private ?PDO $connection = null;

    // Constructeur pour initialiser les paramètres
    public function __construct(string $host = 'localhost', string $dbname='base1', string $username='root', string $password='root') {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    // Méthode pour établir la connexion
    public function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connexion réussie à la base de données : {$this->dbname}<br>";
            return $this->connection;
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
            exit();
        }
    }

    // Méthode pour obtenir l'objet PDO
    public function getConnection(): ?PDO {
        return $this->connection;
    }

    // Méthode pour fermer la connexion
    public function disconnect(): void {
        $this->connection = null;
        echo "Connexion fermée.<br>";
    }
}

?>
