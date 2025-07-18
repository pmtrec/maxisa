<?php
require_once 'app/core/Database.php';

use PMT\APP\CORE\Database;

$db = Database::getInstance()->getPDO();
echo "✅ Connexion réussie à la base de données PostgreSQL.";
