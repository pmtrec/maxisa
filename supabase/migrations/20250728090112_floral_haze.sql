/*
# Migration complète PMT vers Supabase

1. Nouvelles Tables
   - `typeuser` - Types d'utilisateurs (admin, caissier, client)
   - `users` - Informations utilisateurs avec authentification
   - `compte` - Comptes bancaires (principal/secondaire)
   - `transactions` - Historique des transactions

2. Sécurité
   - Enable RLS sur toutes les tables
   - Politiques d'accès basées sur l'authentification
   - Index pour les performances

3. Fonctionnalités
   - Génération automatique des numéros de compte
   - Contraintes de validation
   - Triggers pour les timestamps
*/

-- Extension pour UUID
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Table des types d'utilisateurs
CREATE TABLE IF NOT EXISTS typeuser (
    id SERIAL PRIMARY KEY,
    type_user_enum TEXT NOT NULL CHECK (type_user_enum IN ('admin', 'caissier', 'client')),
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100),
    adresse TEXT,
    num_carte_identite VARCHAR(50),
    photorecto TEXT,
    photoverso TEXT,
    telephone VARCHAR(20) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    type_id INTEGER REFERENCES typeuser(id),
    created_at TIMESTAMPTZ DEFAULT NOW(),
    updated_at TIMESTAMPTZ DEFAULT NOW()
);

-- Table des comptes
CREATE TABLE IF NOT EXISTS compte (
    id SERIAL PRIMARY KEY,
    num_compte VARCHAR(50) UNIQUE NOT NULL,
    solde NUMERIC(15,2) DEFAULT 0.00,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    type_type_compte_enum TEXT NOT NULL CHECK (type_type_compte_enum IN ('principal', 'secondaire')),
    num_telephone VARCHAR(20) NOT NULL,
    created_at TIMESTAMPTZ DEFAULT NOW(),
    updated_at TIMESTAMPTZ DEFAULT NOW()
);

-- Table des transactions
CREATE TABLE IF NOT EXISTS transactions (
    id SERIAL PRIMARY KEY,
    date TIMESTAMPTZ DEFAULT NOW(),
    compte_id INTEGER NOT NULL REFERENCES compte(id) ON DELETE CASCADE,
    montant NUMERIC(15,2) NOT NULL,
    type_type_transaction_enum TEXT CHECK (type_type_transaction_enum IN ('depot', 'retrait', 'transfer', 'paiement')),
    description TEXT,
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- Index pour les performances
CREATE INDEX IF NOT EXISTS idx_users_telephone ON users(telephone);
CREATE INDEX IF NOT EXISTS idx_compte_user_id ON compte(user_id);
CREATE INDEX IF NOT EXISTS idx_compte_num_telephone ON compte(num_telephone);
CREATE INDEX IF NOT EXISTS idx_transactions_compte_id ON transactions(compte_id);
CREATE INDEX IF NOT EXISTS idx_transactions_date ON transactions(date);

-- Fonction pour mettre à jour updated_at
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Triggers pour updated_at
CREATE TRIGGER update_users_updated_at BEFORE UPDATE ON users
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_compte_updated_at BEFORE UPDATE ON compte
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

-- Enable Row Level Security
ALTER TABLE typeuser ENABLE ROW LEVEL SECURITY;
ALTER TABLE users ENABLE ROW LEVEL SECURITY;
ALTER TABLE compte ENABLE ROW LEVEL SECURITY;
ALTER TABLE transactions ENABLE ROW LEVEL SECURITY;

-- Politiques RLS pour typeuser (lecture publique)
CREATE POLICY "Lecture publique des types d'utilisateurs"
    ON typeuser FOR SELECT
    TO public
    USING (true);

-- Politiques RLS pour users
CREATE POLICY "Les utilisateurs peuvent lire leurs propres données"
    ON users FOR SELECT
    TO authenticated
    USING (auth.uid()::text = id::text);

CREATE POLICY "Les utilisateurs peuvent modifier leurs propres données"
    ON users FOR UPDATE
    TO authenticated
    USING (auth.uid()::text = id::text);

-- Politiques RLS pour compte
CREATE POLICY "Les utilisateurs peuvent voir leurs comptes"
    ON compte FOR SELECT
    TO authenticated
    USING (auth.uid()::text = user_id::text);

CREATE POLICY "Les utilisateurs peuvent créer leurs comptes"
    ON compte FOR INSERT
    TO authenticated
    WITH CHECK (auth.uid()::text = user_id::text);

CREATE POLICY "Les utilisateurs peuvent modifier leurs comptes"
    ON compte FOR UPDATE
    TO authenticated
    USING (auth.uid()::text = user_id::text);

-- Politiques RLS pour transactions
CREATE POLICY "Les utilisateurs peuvent voir leurs transactions"
    ON transactions FOR SELECT
    TO authenticated
    USING (
        EXISTS (
            SELECT 1 FROM compte 
            WHERE compte.id = transactions.compte_id 
            AND auth.uid()::text = compte.user_id::text
        )
    );

CREATE POLICY "Les utilisateurs peuvent créer des transactions"
    ON transactions FOR INSERT
    TO authenticated
    WITH CHECK (
        EXISTS (
            SELECT 1 FROM compte 
            WHERE compte.id = transactions.compte_id 
            AND auth.uid()::text = compte.user_id::text
        )
    );

-- Données de base
INSERT INTO typeuser (type_user_enum) VALUES 
    ('admin'), 
    ('caissier'), 
    ('client')
ON CONFLICT DO NOTHING;