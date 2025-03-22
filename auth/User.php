<?php
require_once __DIR__ . '/../config/google.php';
require_once __DIR__ . '/../config/database.php';

/**
 * Classe pour gérer les utilisateurs
 */
class User {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    /**
     * Crée la table utilisateurs si elle n'existe pas
     */
    public function createTable() {
        $sql = 'CREATE TABLE IF NOT EXISTS "users" (
            id SERIAL PRIMARY KEY,
            google_id VARCHAR(255) UNIQUE,
            email VARCHAR(255) UNIQUE,
            name VARCHAR(255),
            picture TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )';
        $this->db->exec($sql);
    }
    
    /**
     * Récupère un utilisateur par son google_id
     */
    public function getByGoogleId($googleId) {
        $stmt = $this->db->prepare('SELECT * FROM "users" WHERE google_id = ?');
        $stmt->execute([$googleId]);
        return $stmt->fetch();
    }
    public function findById($id) {
        $stmt = $this->db->prepare('SELECT * FROM "users" WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Crée ou met à jour un utilisateur après connexion Google
     */
    public function createOrUpdateFromGoogle($googleUser) {
        $googleId = $googleUser['sub'] ?? null;
        $email = $googleUser['email'] ?? null;
        $name = $googleUser['name'] ?? null;
        $picture = $googleUser['picture'] ?? null;
        
        if (!$googleId || !$email) {
            return false;
        }
        
        // Vérifier si l'utilisateur existe déjà
        $existingUser = $this->getByGoogleId($googleId);
        
        if ($existingUser) {
            // Mettre à jour l'utilisateur
            $stmt = $this->db->prepare('UPDATE "users" SET email = ?, name = ?, picture = ? WHERE google_id = ?');
            $stmt->execute([$email, $name, $picture, $googleId]);
            return $this->getByGoogleId($googleId);
        } else {
            // Créer un nouvel utilisateur
            $stmt = $this->db->prepare('INSERT INTO "users" (google_id, email, name, picture) VALUES (?, ?, ?, ?)');
            $stmt->execute([$googleId, $email, $name, $picture]);
            return $this->getByGoogleId($googleId);
        }
    }
} 