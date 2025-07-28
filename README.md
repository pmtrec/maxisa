# PMT - Système de Paiement Mobile avec Supabase

## Configuration Supabase

### 1. Créer un projet Supabase
1. Allez sur [supabase.com](https://supabase.com)
2. Créez un nouveau projet
3. Notez votre URL de projet et votre clé API

### 2. Configuration des variables d'environnement
Copiez le fichier `.env.exemple` vers `.env` et remplissez les valeurs Supabase :

```env
SUPABASE_URL=https://votre-projet.supabase.co
SUPABASE_ANON_KEY=votre_cle_anon
SUPABASE_SERVICE_ROLE_KEY=votre_cle_service_role
```

### 3. Exécuter les migrations
1. Connectez-vous à votre dashboard Supabase
2. Allez dans l'éditeur SQL
3. Copiez et exécutez le contenu du fichier `migrations/SupabaseMigration.sql`

### 4. Configuration de l'authentification
Dans votre dashboard Supabase :
1. Allez dans Authentication > Settings
2. Désactivez "Enable email confirmations" si vous voulez des inscriptions directes
3. Configurez les URL de redirection si nécessaire

## Fonctionnalités

### API Supabase intégrée
- ✅ Authentification utilisateur
- ✅ Gestion des comptes (principal/secondaire)
- ✅ Historique des transactions
- ✅ Sécurité Row Level Security (RLS)

### Endpoints disponibles
- `POST /login` - Connexion utilisateur
- `GET /home` - Dashboard principal
- `GET /transaction` - Liste des transactions
- `POST /secondaire/store` - Création compte secondaire

## Structure de la base de données

### Tables principales
1. **typeuser** - Types d'utilisateurs
2. **users** - Informations utilisateurs
3. **compte** - Comptes bancaires
4. **transactions** - Historique des opérations

### Sécurité
- Row Level Security activé sur toutes les tables
- Politiques d'accès basées sur l'authentification
- Chiffrement des mots de passe avec `password_hash()`

## Installation

1. Clonez le projet
2. Installez les dépendances : `composer install`
3. Configurez votre fichier `.env`
4. Exécutez les migrations Supabase
5. Lancez le serveur : `php -S localhost:8088 -t public`

## Migration depuis PostgreSQL

Le projet a été migré de PostgreSQL vers Supabase avec les améliorations suivantes :
- API REST automatique
- Authentification intégrée
- Interface d'administration
- Sécurité renforcée avec RLS
- Scalabilité cloud native