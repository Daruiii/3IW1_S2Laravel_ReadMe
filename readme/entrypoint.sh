#!/bin/bash

echo "ReadMe - Setup automatique du projet Laravel"
echo "================================================"

cd /var/www/html

if [ ! -f .env ]; then
    echo "Création du fichier .env..."
    cp .env.example .env
    
    sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env
    sed -i 's/# DB_HOST=127.0.0.1/DB_HOST=mysql/' .env
    sed -i 's/# DB_PORT=3306/DB_PORT=3306/' .env
    sed -i 's/# DB_DATABASE=laravel/DB_DATABASE=readme/' .env
    sed -i 's/# DB_USERNAME=root/DB_USERNAME=sail/' .env
    sed -i 's/# DB_PASSWORD=/DB_PASSWORD=password/' .env
fi

echo "Installation des dépendances Composer..."
composer install --optimize-autoloader --no-interaction

echo "Génération de la clé d'application..."
php artisan key:generate --force

echo "Attente de MySQL..."
attempt=0
max_attempts=30

until php -r "
try {
    \$pdo = new PDO('mysql:host=mysql;port=3306', 'sail', 'password');
    echo 'MySQL OK';
    exit(0);
} catch (Exception \$e) {
    exit(1);
}
" &>/dev/null; do
    attempt=$((attempt + 1))
    
    if [ $attempt -gt $max_attempts ]; then
        echo "❌ Timeout: MySQL non disponible après $max_attempts tentatives"
        echo "Vérifiez la configuration MySQL dans docker-compose.yml"
        exit 1
    fi
    
    echo "MySQL pas encore prêt... tentative $attempt/$max_attempts"
    sleep 2
done

echo "✅ MySQL est prêt"

echo "Migration de la base de données..."
php artisan migrate --force

echo "Vérification des données existantes..."
# Vérifier si la base contient déjà des données (table users avec plus de 0 enregistrements)
user_count=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tail -1)

if [ "$user_count" -eq 0 ] 2>/dev/null; then
    echo "Base de données vide, lancement du seeding..."
    php artisan db:seed --force
else
    echo "✅ Base de données déjà peuplée ($user_count utilisateurs), skip du seeding"
fi

echo "Cache des vues et routes..."
php artisan view:cache
php artisan route:cache

echo "Installation des dépendances Node.js..."
npm install

echo "Build des assets CSS/JS avec Tailwind..."
npm run build

echo "🚀 Setup terminé ! Lancement de Laravel..."

if [ "$#" -eq 0 ]; then
    echo "Démarrage du serveur Laravel sur 0.0.0.0:80..."
    
    npm run dev &
    
    sleep 3
    
    php artisan serve --host=0.0.0.0 --port=80
else
    exec "$@"
fi
