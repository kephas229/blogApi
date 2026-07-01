#!/usr/bin/env bash
set -e

# Render injecte DATABASE_URL sous la forme :
# postgresql://user:password@host:port/dbname
# Laravel ne la lit pas nativement — on parse et on exporte les variables séparées
if [ -n "$DATABASE_URL" ]; then
    echo "==> Parsing DATABASE_URL..."

    # Extrait chaque composant de l'URL
    export DB_CONNECTION=pgsql
    export DB_HOST=$(echo "$DATABASE_URL"     | sed -E 's|.*@([^:/]+).*|\1|')
    export DB_PORT=$(echo "$DATABASE_URL"     | sed -E 's|.*:([0-9]+)/.*|\1|')
    export DB_DATABASE=$(echo "$DATABASE_URL" | sed -E 's|.*/([^?]+).*|\1|')
    export DB_USERNAME=$(echo "$DATABASE_URL" | sed -E 's|.*://([^:]+):.*|\1|')
    export DB_PASSWORD=$(echo "$DATABASE_URL" | sed -E 's|.*://[^:]+:([^@]+)@.*|\1|')

    echo "    Host     : $DB_HOST"
    echo "    Port     : $DB_PORT"
    echo "    Database : $DB_DATABASE"
    echo "    User     : $DB_USERNAME"
fi

echo "==> Caching config, routes and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Seeding database if empty..."
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tail -n1 | tr -d '[:space:]')
if [ "$USER_COUNT" = "0" ]; then
    echo "    Aucun utilisateur trouvé — lancement du seeder..."
    php artisan db:seed --force
    echo "    Seeder terminé."
else
    echo "    Données existantes (${USER_COUNT} utilisateur(s)) — seed ignoré."
fi

echo "==> Starting Apache..."
apache2-foreground
