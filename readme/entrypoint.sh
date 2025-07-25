#!/bin/bash

echo "ReadMe - Setup automatique du projet Laravel"
echo "================================================"

# Attendre que MySQL soit prêt
echo "Attente de MySQL..."
until php artisan migrate:status &>/dev/null; do
    echo "MySQL pas encore prêt, attente..."
    sleep 2
done

echo "✅ MySQL est prêt"

# Créer le fichier .env si il n'existe pas
if [ ! -f .env ]; then
    echo "Création du fichier .env..."
    cp .env.example .env
fi

echo "Génération de la clé d'application..."
php artisan key:generate --force

echo "Exécution des migrations..."
php artisan migrate:fresh --force

echo "Génération des données de test..."
php artisan db:seed --force

echo "Installation des dépendances Node.js..."
npm install

echo "Build des assets..."
npm run dev &

echo ""
echo "Setup terminé avec succès !"
echo ""
echo "Accès à l'application:"
echo "   - Frontend: http://localhost"
echo "   - Base de données: localhost:3306"
echo ""

# Lancer le serveur Laravel
echo "Démarrage du serveur Laravel..."
php artisan serve --host=0.0.0.0 --port=80
