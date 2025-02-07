<?php
require_once 'DatabaseConnection.php';
require_once 'User.php';
class DAOUser {
    private string $tableName; // Nom de la table
    private PDO $connection;  // Connexion à la base de données

    // Constructeur pour initialiser le DAO
    public function __construct(string $tableName, PDO $connection) {
        $this->tableName = $tableName;
        $this->connection = $connection;
    }
    
    // Ajouter un utilisateur dans la table
    public function addUser(User $user): bool {
        try {
            $sql = "INSERT INTO {$this->tableName} (email, password, nom, prenom, genre, phone, profilePhoto) 
                    VALUES (:email, :password, :nom, :prenom, :genre, :phone, :profilePhoto)";
            $stmt = $this->connection->prepare($sql);

            return $stmt->execute([
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword(),
                ':nom' => $user->getNom(),
                ':prenom' => $user->getPrenom(),
                ':genre' => $user->getGenre(),
                ':phone' => $user->getPhone(),
                ':profilePhoto' => $user->getProfilePhoto()
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    // Lire tous les utilisateurs
    public function getAllUsers(): array {
        try {
            $sql = "SELECT * FROM {$this->tableName}";
            $stmt = $this->connection->query($sql);

            $users = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User(
                    $row['email'], 
                    $row['password'], 
                    $row['nom'], 
                    $row['prenom'], 
                    $row['genre'],
                    $row['phone'],
                    $row['profilePhoto']

                );
            }

            return $users;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
            return [];
        }
    }

    // Supprimer un utilisateur par email
    public function deleteUser(string $email): bool {
        try {
            $sql = "DELETE FROM {$this->tableName} WHERE email = :email";
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([':email' => $email]);
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    // Mettre à jour un utilisateur
    public function updateUser(User $user): bool {
        try {
            $sql = "UPDATE {$this->tableName} 
                    SET password = :password, nom = :nom, prenom = :prenom, genre = :genre , phone = :phone
                    WHERE email = :email";
            $stmt = $this->connection->prepare($sql);

            return $stmt->execute([
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword(),
                ':nom' => $user->getNom(),
                ':prenom' => $user->getPrenom(),
                ':genre' => $user->getGenre(),
                ':phone' => $user->getPhone(),
                ':profilePhoto' => $user->getProfilePhoto()
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    // Trouver un utilisateur par email
    public function findUserByEmail(string $email): ?User {
        try {
            $sql = "SELECT * FROM {$this->tableName} WHERE email = :email";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':email' => $email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new User(
                    $row['email'], 
                    $row['password'], 
                    $row['nom'], 
                    $row['prenom'], 
                    $row['genre'],
                    $row['phone'],
                    $row['phone'],
                );
            }
            return null;
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche de l'utilisateur : " . $e->getMessage();
            return null;
        }
    }
    // Vérifie si un utilisateur existe dans la table par email
public function userExists(string $email): bool {
    try {
        $sql = "SELECT COUNT(*) FROM {$this->tableName} WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':email' => $email]);
        $count = $stmt->fetchColumn();

        return $count > 0; // Renvoie vrai si au moins un utilisateur est trouvé
    } catch (PDOException $e) {
        echo "Erreur lors de la vérification de l'utilisateur : " . $e->getMessage();
        return false;
    }
}
   //verifier l'existence par phone
public function userExists1(string $phone): bool {
    try {
        $sql = "SELECT COUNT(*) FROM {$this->tableName} WHERE phone = :phone";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':phone' => $phone]);
        $count = $stmt->fetchColumn();

        return $count > 0; // Renvoie vrai si au moins un utilisateur est trouvé
    } catch (PDOException $e) {
        echo "Erreur lors de la vérification de l'utilisateur : " . $e->getMessage();
        return false;
    }
}

// Vérifie si un utilisateur existe par email et mot de passe
public function userExists2(string $email, string $password): bool {
    try {
        $sql = "SELECT COUNT(*) FROM {$this->tableName} WHERE email = :email AND password = :password";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':password' => $password
        ]);
        $count = $stmt->fetchColumn();

        return $count > 0; // Renvoie vrai si au moins un utilisateur correspond
    } catch (PDOException $e) {
        echo "Erreur lors de la vérification de l'utilisateur (email et mot de passe) : " . $e->getMessage();
        return false;
    }
}

 // Mettre à jour la base de données avec le token et sa date d'expiration
 public function updateResetToken($identifiant, $token, $expiry) {
    $query = "UPDATE users SET reset_token = :token, reset_token_expiry = :expiry WHERE email = :email OR phone = :phone";
    $stmt = $this->connection->prepare($query);
    $stmt->execute([
        ':token' => $token,
        ':expiry' => $expiry,
        ':email' => $identifiant,
        ':phone' => $identifiant
    ]);
}

// Ajouter les méthodes isValidToken et updatePasswordByToken dans DAOUser
public function isValidToken($token) {
    $query = "SELECT * FROM users WHERE reset_token = :token AND reset_token_expiry > NOW()";
    $stmt = $this->connection->prepare($query);
    $stmt->execute([':token' => $token]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function updatePasswordByToken($token, $nouveauMotDePasse) {
    $query = "UPDATE users SET password = :password, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = :token";
    $stmt = $this->connection->prepare($query);
    $stmt->execute([
        ':password' => $nouveauMotDePasse,
        ':token' => $token
    ]);
}

//mettre a jour le nom et le prenom
public function updateNPByEmail(string $email, string $nom, string $prenom): bool {
    try {
        $sql = "UPDATE {$this->tableName} SET nom = :nom,  prenom = :prenom WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':email' => $email,
            ':prenom' => $prenom,
            ':nom' => $nom,
        ]);
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour du genre : " . $e->getMessage();
        return false;
    }
}


//mettre a jour le telephon
public function updatePhoneByEmail(string $email, string $phone): bool {
    try {
        $sql = "UPDATE {$this->tableName} SET phone = :phone WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':email' => $email,
            ':phone' => $phone
        ]);
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour du téléphone : " . $e->getMessage();
        return false;
    }
}

//mettre a jour le mot de passe
public function updateMdpByEmail(string $email,string $password):bool {
    try {
        $sql = "UPDATE {$this->tableName} SET password = :password WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':email' => $email,
            ':password' => $password
        ]);
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour du téléphone : " . $e->getMessage();
        return false;
    }

}

//mettre a jour la photo
public function updateProfilePhoto(string $email,string $profilePhoto):bool{
    try {
        $sql = "UPDATE {$this->tableName} SET profilePhoto = :profilePhoto WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':email' => $email,
            ':profilePhoto' => $profilePhoto
        ]);
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour du téléphone : " . $e->getMessage();
        return false;
    }
}
}
?>
