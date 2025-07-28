# PMT - Système de Paiement Mobile avec Supabase

## 🚀 Migration complète vers Supabase

Ce projet a été entièrement migré de PostgreSQL vers Supabase pour bénéficier d'une architecture cloud native moderne.

## ⚡ Configuration rapide

### 1. Créer un projet Supabase
1. Allez sur [supabase.com](https://supabase.com)
2. Créez un nouveau projet
3. Notez votre URL de projet et vos clés API

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
3. Copiez et exécutez le contenu du fichier `supabase/migrations/create_complete_schema.sql`

### 4. Seeder les données de test
```bash
php scripts/seed-supabase.php
```

### 5. Tester la connexion
```bash
php scripts/test-supabase.php
```

## 🎯 Fonctionnalités

### ✅ API Supabase intégrée
- Authentification utilisateur sécurisée
- Gestion des comptes (principal/secondaire)
- Historique des transactions en temps réel
- Row Level Security (RLS) pour la sécurité des données

### 🔐 Sécurité avancée
- Chiffrement des mots de passe avec `password_hash()`
- Politiques RLS pour l'isolation des données
- Validation des entrées utilisateur
- Gestion d'erreurs robuste

### 📱 Endpoints disponibles
- `GET /` - Page de connexion
- `POST /login` - Authentification utilisateur
- `GET /home` - Dashboard principal
- `GET /transaction` - Liste des transactions
- `GET /newcompte` - Formulaire création compte secondaire
- `POST /secondaire/store` - Création compte secondaire

## 🏗️ Architecture

### Structure de la base de données
1. **typeuser** - Types d'utilisateurs (admin, caissier, client)
2. **users** - Informations utilisateurs avec authentification
3. **compte** - Comptes bancaires (principal/secondaire)
4. **transactions** - Historique des opérations

### Couches applicatives
- **Controllers** - Gestion des requêtes HTTP
- **Services** - Logique métier
- **Repositories** - Accès aux données Supabase
- **Entities** - Modèles de données

## 🛠️ Installation

1. **Clonez le projet**
```bash
git clone [votre-repo]
cd pmt-supabase
```

2. **Installez les dépendances**
```bash
composer install
```

3. **Configurez Supabase**
- Créez votre projet sur supabase.com
- Configurez le fichier `.env`
- Exécutez les migrations SQL

4. **Seedez les données**
```bash
php scripts/seed-supabase.php
```

5. **Lancez le serveur**
```bash
php -S localhost:8088 -t public
```

## 🧪 Comptes de test

Après le seeding, vous pouvez vous connecter avec :
- **Téléphone:** 770000001, **Mot de passe:** pass1
- **Téléphone:** 770000002, **Mot de passe:** pass2
- **Téléphone:** 770000003, **Mot de passe:** pass3

## 🔧 Scripts utiles

```bash
# Tester la connexion Supabase
php scripts/test-supabase.php

# Seeder les données de test
php scripts/seed-supabase.php

# Lancer le serveur de développement
php -S localhost:8088 -t public
```

## 📊 Avantages de Supabase

- **API REST automatique** - Pas besoin de créer des endpoints manuellement
- **Authentification intégrée** - Système d'auth prêt à l'emploi
- **Interface d'administration** - Dashboard pour gérer les données
- **Sécurité renforcée** - RLS et politiques de sécurité
- **Scalabilité** - Infrastructure cloud native
- **Temps réel** - Synchronisation en temps réel des données

## 🚨 Dépannage

### Erreur de connexion Supabase
1. Vérifiez vos variables d'environnement dans `.env`
2. Assurez-vous que votre projet Supabase est actif
3. Testez avec `php scripts/test-supabase.php`

### Erreurs de permissions
1. Vérifiez que RLS est activé sur vos tables
2. Contrôlez vos politiques de sécurité dans Supabase
3. Assurez-vous d'utiliser la bonne clé API

### Problèmes de migration
1. Exécutez le script SQL complet dans l'éditeur Supabase
2. Vérifiez les logs d'erreur dans le dashboard
3. Assurez-vous que toutes les extensions sont activées

## 📝 Changelog

### v2.0.0 - Migration Supabase
- ✅ Migration complète vers Supabase
- ✅ Nouveau client Supabase avec gestion d'erreurs
- ✅ Repositories adaptés pour l'API REST
- ✅ Sécurité renforcée avec RLS
- ✅ Scripts de test et seeding
- ✅ Documentation complète

## 🤝 Contribution

1. Fork le projet
2. Créez votre branche feature (`git checkout -b feature/AmazingFeature`)
3. Committez vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.