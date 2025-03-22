# Projet d'Authentification Google avec PHP

## Description du projet

Ce projet est une application PHP permettant l'authentification des utilisateurs via Google OAuth 2.0. Il offre une solution complète pour intégrer l'authentification Google dans une application web PHP, avec gestion des utilisateurs en base de données PostgreSQL.

### Fonctionnalités principales

- Authentification des utilisateurs via Google OAuth 2.0
- Stockage des informations utilisateur en base de données
- Gestion des sessions utilisateur
- Page d'accueil publique et page privée accessible uniquement après authentification
- Interface utilisateur avec Bootstrap 5

## Prérequis

### Configuration Google Cloud Platform

1. Créer un projet sur [Google Cloud Console](https://console.cloud.google.com/)
2. Activer l'API Google+ API
3. Configurer l'écran de consentement OAuth dans "APIs & Services > OAuth consent screen"
4. Créer des identifiants OAuth 2.0 dans "APIs & Services > Credentials"
   - Type d'application : Application Web
   - Nom : Votre nom d'application
   - URI de redirection autorisés : `http://localhost:3000/config/callback.php` (à adapter selon votre environnement)
5. Noter votre **Client ID** et **Client Secret** générés par Google

### Environnement de développement

- PHP 7.4 ou supérieur
- Serveur web (Apache, Nginx)
- PostgreSQL
- Composer (gestionnaire de dépendances PHP)

## Installation

1. Cloner le dépôt:

   ```bash
   git clone [URL_DU_DÉPÔT]
   cd auth-google-php
   ```

2. Installer les dépendances:

   ```bash
   composer install
   ```

3. Configurer la base de données:

   - Créer une base de données PostgreSQL
   - Modifier les paramètres de connexion dans `config/database.php`

4. Configurer l'authentification Google:

   - Remplacer les identifiants dans `config/google.php` par vos propres identifiants:
     ```php
     define('GOOGLE_CLIENT_ID', 'VOTRE_CLIENT_ID');
     define('GOOGLE_CLIENT_SECRET', 'VOTRE_CLIENT_SECRET');
     define('GOOGLE_REDIRECT_URI', 'http://localhost:3000/config/callback.php');
     ```
   - Adapter l'URI de redirection selon votre configuration de serveur

5. Lancer un serveur de développement(en utilisant un serveur local intégré à PHP):
   ```bash
   php -S localhost:3000
   ```

## Structure du projet

- `auth/` : Classes pour la gestion des utilisateurs et des sessions
- `config/` : Fichiers de configuration (base de données, authentification Google)
- `src/` : Code source de l'application
- `public/` : Ressources publiques (CSS, JS, images)
- `vendor/` : Dépendances externes (installées via Composer)
- `index.php` : Page d'accueil
- `private.php` : Page accessible uniquement après authentification

## Fonctionnement

1. L'utilisateur accède à l'application et clique sur "Se connecter avec Google"
2. Il est redirigé vers l'écran d'authentification Google
3. Après authentification réussie, Google redirige vers l'URL de callback
4. L'application récupère les informations utilisateur et crée/met à jour l'entrée en base de données
5. Une session est créée pour maintenir l'utilisateur connecté
6. L'utilisateur peut accéder aux pages protégées

## Sécurité

- Les informations sensibles (Client ID, Client Secret) doivent être protégées
- Pour un environnement de production, il est recommandé de:
  - Utiliser HTTPS
  - Stocker les secrets dans des variables d'environnement plutôt que dans le code
  - Implémenter la validation et la rotation des jetons

## Dépendances

Le projet utilise:

- `google/apiclient` v2.15.0 : Client PHP officiel pour l'API Google
- Bootstrap 5 (via CDN) pour l'interface utilisateur
