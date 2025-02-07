<?php
class User {
    // Propriétés privées
    private string $email;
    private string $password;
    private string $nom;
    private string $prenom;
    private string $genre;
    private string $phone;
    private string $profilePhoto;

    // Constructeur
    public function __construct(string $email, string $password, string $nom, string $prenom, string $genre,string $phone,$profilePhoto ) {
        $this->email = $email;
        $this->password = $password;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->genre = $genre;$this->phone=$phone;
        $this->profilePhoto=$profilePhoto;
    }

    // Getters
    public function getEmail(): string {
        return $this->email;
    }

    public function getPhone(): string {
        return $this->phone;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function getGenre(): string {
        return $this->genre;
    }

    // Setters
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }

    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }

    public function setGenre(string $genre): void {
        $this->genre = $genre;
    }


    public function getProfilePhoto() {
        return $this->profilePhoto; // Retourne le chemin de la photo
    }

    // Méthode pour définir le chemin de la photo de profil
    public function setProfilePhoto($profilePhoto) {
        $this->profilePhoto = $profilePhoto;
    }

    // Méthode pour afficher les informations de l'utilisateur
    public function displayInfo(): void {
        echo "Nom : " . $this->nom . "<br>";
        echo "Prénom : " . $this->prenom . "<br>";
        echo "Genre : " . $this->genre . "<br>";
        echo "Email : " . $this->email . "<br>";
    }
}
?>
