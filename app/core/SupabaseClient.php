<?php

namespace PMT\APP\CORE;

use Exception;

class SupabaseClient {
    private static ?SupabaseClient $instance = null;
    private string $supabaseUrl;
    private string $supabaseKey;
    private string $serviceRoleKey;

    private function __construct() {
        // Charger les variables d'environnement
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->safeLoad();

        $this->supabaseUrl = $_ENV['SUPABASE_URL'] ?? '';
        $this->supabaseKey = $_ENV['SUPABASE_ANON_KEY'] ?? '';
        $this->serviceRoleKey = $_ENV['SUPABASE_SERVICE_ROLE_KEY'] ?? '';

        if (empty($this->supabaseUrl) || empty($this->supabaseKey)) {
            throw new Exception("Configuration Supabase manquante. Vérifiez votre fichier .env");
        }
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Effectue une requête GET vers Supabase
     */
    public function select(string $table, array $filters = [], array $select = ['*']): array {
        $url = $this->supabaseUrl . "/rest/v1/" . $table;
        
        // Construire les paramètres de sélection
        $params = [
            'select' => implode(',', $select)
        ];

        // Ajouter les filtres
        foreach ($filters as $column => $value) {
            if (is_array($value)) {
                // Pour les opérateurs comme eq, gt, lt, etc.
                $operator = $value['operator'] ?? 'eq';
                $params[$column] = $operator . '.' . $value['value'];
            } else {
                $params[$column] = 'eq.' . $value;
            }
        }

        $url .= '?' . http_build_query($params);

        return $this->makeRequest('GET', $url);
    }

    /**
     * Effectue une requête POST vers Supabase (INSERT)
     */
    public function insert(string $table, array $data): array {
        $url = $this->supabaseUrl . "/rest/v1/" . $table;
        
        return $this->makeRequest('POST', $url, $data, [
            'Prefer: return=representation'
        ]);
    }

    /**
     * Effectue une requête PATCH vers Supabase (UPDATE)
     */
    public function update(string $table, array $data, array $filters): array {
        $url = $this->supabaseUrl . "/rest/v1/" . $table;
        
        // Ajouter les filtres dans l'URL
        $params = [];
        foreach ($filters as $column => $value) {
            $params[$column] = 'eq.' . $value;
        }
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $this->makeRequest('PATCH', $url, $data, [
            'Prefer: return=representation'
        ]);
    }

    /**
     * Effectue une requête DELETE vers Supabase
     */
    public function delete(string $table, array $filters): array {
        $url = $this->supabaseUrl . "/rest/v1/" . $table;
        
        // Ajouter les filtres dans l'URL
        $params = [];
        foreach ($filters as $column => $value) {
            $params[$column] = 'eq.' . $value;
        }
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $this->makeRequest('DELETE', $url);
    }

    /**
     * Authentification avec Supabase Auth
     */
    public function signInWithPassword(string $email, string $password): array {
        $url = $this->supabaseUrl . "/auth/v1/token?grant_type=password";
        
        $data = [
            'email' => $email,
            'password' => $password
        ];

        return $this->makeRequest('POST', $url, $data);
    }

    /**
     * Effectue une requête HTTP vers Supabase
     */
    private function makeRequest(string $method, string $url, array $data = null, array $additionalHeaders = []): array {
        $headers = [
            'apikey: ' . $this->supabaseKey,
            'Authorization: Bearer ' . $this->supabaseKey,
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        // Ajouter les en-têtes supplémentaires
        $headers = array_merge($headers, $additionalHeaders);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30
        ]);

        if ($data !== null && in_array($method, ['POST', 'PATCH', 'PUT'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception("Erreur cURL: " . $error);
        }

        if ($httpCode >= 400) {
            $errorData = json_decode($response, true);
            $errorMessage = $errorData['message'] ?? 'Erreur HTTP ' . $httpCode;
            throw new Exception("Erreur Supabase: " . $errorMessage);
        }

        return json_decode($response, true) ?? [];
    }

    public function getSupabaseUrl(): string {
        return $this->supabaseUrl;
    }

    public function getSupabaseKey(): string {
        return $this->supabaseKey;
    }
}