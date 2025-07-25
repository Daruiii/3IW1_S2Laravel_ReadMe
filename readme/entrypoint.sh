#!/bin/bash

echo "ReadMe - Setup automatique du projet Laravel"
echo "================================================"

# Vérifier si Docker est installé
if ! command -v docker &> /dev/null; then
    echo "Docker n'est pas installé. Veuillez l'installer avant de continuer."
    exit 1
fi

# Vérifier si Docker Compose est installé
if ! command -v docker-compose &> /dev/null; then
    echo "Docker Compose n'est pas installé. Veuillez l'installer avant de continuer."
    exit 1
fi

echo "✅ Vérification des prérequis OK"

# Créer le fichier .env si il n'existe pas
if [ ! -f .env ]; then
    echo "Création du fichier .env..."
    cp .env.example .env
    
    # Configuration pour MySQL
    sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env
    sed -i 's/# DB_HOST=127.0.0.1/DB_HOST=mysql/' .env
    sed -i 's/# DB_PORT=3306/DB_PORT=3306/' .env
    sed -i 's/# DB_DATABASE=laravel/DB_DATABASE=readme/' .env
    sed -i 's/# DB_USERNAME=root/DB_USERNAME=sail/' .env
    sed -i 's/# DB_PASSWORD=/DB_PASSWORD=password/' .env
fi

echo "Démarrage des conteneurs Docker..."
./vendor/bin/sail up -d

echo "Attente du démarrage de MySQL (30s)..."
sleep 30

echo "Génération de la clé d'application..."
./vendor/bin/sail artisan key:generate

echo "Exécution des migrations..."
./vendor/bin/sail artisan migrate:fresh

echo "Génération des données de test..."
./vendor/bin/sail artisan db:seed

echo "Installation des dépendances Node.js..."
./vendor/bin/sail npm install

echo "Build des assets..."
./vendor/bin/sail npm run dev &

echo ""
echo "Setup terminé avec succès !"
echo ""
echo "Accès à l'application:"
echo "   - Frontend: http://localhost"
echo "   - Base de données: localhost:3306"
echo ""
echo "🛠Commandes utiles:"
echo "   - Arrêter: ./vendor/bin/sail down"
echo "   - Logs: ./vendor/bin/sail logs"
echo "   - Shell: ./vendor/bin/sail shell"
echo "   - Artisan: ./vendor/bin/sail artisan"
echo ""
