<?php
  require_once 'User.php';

/**
 * Classe pour gérer les sessions
 */
class Session {
    /**
     * Démarrer la session si elle n'est pas déjà démarrée
     */
    public static function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Définir une variable de session
     */
    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }
    
    /**
     * Récupérer une variable de session
     */
    public static function get($key, $default = null) {
        self::start();
        $userModel = new User();
        
        if ($key === 'user' && isset($_SESSION[$key])) {
        // Récupérer l'utilisateur de la base de données          
        return $userModel->findById($_SESSION[$key]['id']) ?? $default;
        }
       return null;
    }
    
    /**
     * Vérifier si une variable de session existe
     */
    public static function has($key) {
        self::start();
        return isset($_SESSION[$key]);
    }
    
    /**
     * Supprimer une variable de session
     */
    public static function remove($key) {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * Détruire la session
     */
    public static function destroy() {
        self::start();
        session_unset();
        session_destroy();
    }
    
    /**
     * Vérifier si l'utilisateur est connecté
     */
    public static function isLoggedIn() {
        return self::has('user');
    }
    
    /**
     * Définir l'utilisateur connecté
     */
    public static function setUser($user) {
        self::set('user', $user);
    }
    
    /**
     * Récupérer l'utilisateur connecté
     */
    public static function getUser() {
        return self::get('user');
    }
} 