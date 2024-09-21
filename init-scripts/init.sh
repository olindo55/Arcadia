#!/bin/bash
set -e

# Fonction getEnv pour obtenir une variable d'environnement
getEnv() {
    local var_name="$1"
    local var_value="${!var_name}"
    
    if [ -z "$var_value" ]; then
        echo "Erreur : La variable d'environnement $var_name n'est pas définie." >&2
        exit 1
    fi
    
    echo "$var_value"
}

# Récupération des variables d'environnement
DB_ROOT_PASSWORD=$(getEnv "MYSQL_ROOT_PASSWORD")
DB_NAME=$(getEnv "MYSQL_DATABASE")
INIT_SQL_FILE=$(getEnv "INIT_SQL_FILE")

# Vérifiez si la base de données est déjà initialisée
if [ ! -f /var/lib/mysql/init_done ]; then
    echo "Initialisation de la base de données avec $INIT_SQL_FILE"
    
    # Utilisation de l'option --password sans espace pour éviter les problèmes de sécurité
    mysql -u root --password="$DB_ROOT_PASSWORD" "$DB_NAME" < "$INIT_SQL_FILE"
    
    touch /var/lib/mysql/init_done
else
    echo "La base de données est déjà initialisée"
fi