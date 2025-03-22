<?php
/**
 * Classe pour gérer l'authentification avec Google
 */
class GoogleAuth {
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    
    public function __construct($clientId, $clientSecret, $redirectUri) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
    }
    
    /**
     * Génère l'URL d'authentification Google
     */
    //authorization endpoint
    public function getAuthUrl() {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => 'email profile openid',            
            'access_type' => 'online',
            'prompt' => 'select_account'
        ];
        
        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    }
    
    /**
     * Échange le code d'autorisation reçu contre un jeton d'accès
     */
    public function getAccessToken($authCode) {
        $url = 'https://oauth2.googleapis.com/token';
        
        $data = [
            'code' => $authCode,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code'
        ];
        
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            return null;
        }
        
        return json_decode($response, true);
    }
    
    /**
     * Récupère les informations de l'utilisateur avec le jeton d'accès
     */
    //userinfo endpoint
    public function getUserInfo($accessToken) {
        // Endpoint pour récuperer les informations de l'utilisateur
        $url = 'https://www.googleapis.com/oauth2/v3/userinfo';
        
        $options = [
            'http' => [
                'header' => "Authorization: Bearer $accessToken\r\n"
            ]
        ];
        
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            return null;
        }
        
        return json_decode($response, true);
    }
}