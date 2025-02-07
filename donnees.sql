--ici il me reste de recuperer la table des users
CREATE TABLE users (
    email VARCHAR(255) NOT NULL PRIMARY KEY,
    password VARCHAR(255) NOT NULL,  -- Assurez-vous de sécuriser les mots de passe !
    nom_utilisateur VARCHAR(255) NOT NULL,
    prenom_utilisateur VARCHAR(255) NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);
--ici la table des conversations
CREATE TABLE conversations (
    email_utilisateur1 VARCHAR(255) NOT NULL,
    email_utilisateur2 VARCHAR(255) NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (email_utilisateur1, email_utilisateur2),
    FOREIGN KEY (email_utilisateur1) REFERENCES users(email) ON DELETE CASCADE,
    FOREIGN KEY (email_utilisateur2) REFERENCES users(email) ON DELETE CASCADE
);
--ici la table des messages
CREATE TABLE messages (
    id_message INT AUTO_INCREMENT PRIMARY KEY,
    email_utilisateur1 VARCHAR(255) NOT NULL,
    email_utilisateur2 VARCHAR(255) NOT NULL,
    email_auteur VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (email_utilisateur1, email_utilisateur2)
        REFERENCES conversations(email_utilisateur1, email_utilisateur2)
        ON DELETE CASCADE,
    FOREIGN KEY (email_auteur) REFERENCES users(email) ON DELETE CASCADE
);
