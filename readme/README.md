# ReadMe - Système de Gestion de Bibliothèque

**Projet Laravel - ESGI Bachelor 3IW1 S2**

Application web de gestion de bibliothèque développée avec Laravel 12, permettant aux utilisateurs d'emprunter et retourner des livres, avec une interface d'administration complète.

## Description

ReadMe est une application de gestion de bibliothèque qui permet :

- Aux utilisateurs de consulter le catalogue, emprunter et retourner des livres
- Aux administrateurs de gérer les livres, auteurs, catégories et utilisateurs
- La gestion automatique des stocks et des contraintes métier

## Technologies utilisées

- **Backend** : Laravel 12.x, PHP 8.4
- **Base de données** : MySQL 8.0
- **Frontend** : Blade Templates, Tailwind CSS
- **Authentification** : Laravel Breeze
- **Environnement** : Docker avec Laravel Sail
- **Serveur web** : Nginx

## Modèle de données

### Entités principales

**Book (Livre)**
- id, title, summary, year, stock
- Relations : appartient à une catégorie, peut avoir plusieurs auteurs

**Author (Auteur)**
- id, first_name, last_name, bio
- Relations : peut écrire plusieurs livres

**Category (Catégorie)**
- id, name, description
- Relations : peut contenir plusieurs livres

**User (Utilisateur)**
- id, name, email, role
- Relations : peut avoir plusieurs emprunts

**Borrow (Emprunt)**
- id, user_id, book_id, date_start, date_end, status
- Relations : appartient à un utilisateur et concerne un livre

### Relations

- Un livre peut avoir plusieurs auteurs (relation many-to-many)
- Un livre appartient à une catégorie (relation one-to-many)
- Un utilisateur peut avoir plusieurs emprunts (relation one-to-many)

## Installation

### Prérequis

- Docker et Docker Compose installés
- Git

### Installation automatique

```bash
./entrypoint.sh
```

### Installation manuelle

1. Cloner le repository
```bash
git clone [url-du-repo]
cd readme
```

2. Démarrer l'environnement Docker
```bash
./vendor/bin/sail up -d
```

3. Installer les dépendances
```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

4. Configuration de l'environnement
```bash
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

5. Base de données
```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

6. Compilation des assets
```bash
./vendor/bin/sail npm run dev
```

L'application sera accessible sur http://localhost

## Fonctionnalités

### Pour les utilisateurs

- Inscription et connexion sécurisées
- Consultation du catalogue de livres
- Recherche et filtrage des livres
- Emprunt de livres (dans la limite des stocks disponibles)
- Retour de livres empruntés
- Consultation de l'historique des emprunts

### Pour les administrateurs

- Gestion complète des livres (CRUD)
- Gestion des auteurs et de leurs biographies
- Gestion des catégories
- Suivi des emprunts et des stocks
- Gestion des utilisateurs

### Contraintes métier

- Chaque utilisateur peut emprunter maximum 3 livres simultanément
- Durée d'emprunt limitée à 30 jours
- Impossible d'emprunter un livre si le stock est à zéro
- Mise à jour automatique des stocks lors des emprunts/retours

## Commandes utiles

### Docker
```bash
./vendor/bin/sail up -d          # Démarrer les conteneurs
./vendor/bin/sail down           # Arrêter les conteneurs
./vendor/bin/sail shell          # Accéder au conteneur
```

### Laravel
```bash
./vendor/bin/sail artisan migrate:fresh --seed    # Réinitialiser la DB
./vendor/bin/sail artisan make:model [Model]      # Créer un modèle
./vendor/bin/sail artisan route:list              # Lister les routes
```

### Assets
```bash
./vendor/bin/sail npm run dev      # Mode développement
./vendor/bin/sail npm run build    # Build production
```

## Comptes de test

Après avoir exécuté les seeders :

**Administrateur**
- Email : admin@readme.com
- Mot de passe : password

**Utilisateur standard**
- Email : user@readme.com
- Mot de passe : password

## Structure du projet

Le projet suit l'architecture standard de Laravel :

- `app/Models/` : Modèles Eloquent avec les relations
- `app/Http/Controllers/` : Contrôleurs pour la logique métier
- `app/Http/Requests/` : Classes de validation des formulaires
- `database/migrations/` : Fichiers de migration pour la structure de la DB
- `database/seeders/` : Génération de données de test
- `resources/views/` : Templates Blade pour l'interface utilisateur
- `routes/web.php` : Définition des routes web

## Développement

Le projet utilise Laravel Sail pour l'environnement de développement, permettant une configuration Docker standardisée et reproductible.

### Ajout de nouvelles fonctionnalités

1. Créer les migrations nécessaires
2. Développer les modèles avec leurs relations
3. Implémenter les contrôleurs et la logique métier
4. Créer les vues Blade
5. Ajouter les routes correspondantes
6. Écrire les tests si nécessaire

## Notes techniques

- Authentification gérée par Laravel Breeze
- Validation des données via les FormRequest
- Protection CSRF activée sur tous les formulaires
- Relations Eloquent pour la gestion des données
- Middleware d'authentification sur les routes protégées


Projet réalisé dans le cadre du cours Laravel - Semestre 2
