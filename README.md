# Task Manager CI/CD

![CI](https://github.com/fallndoumbe/task-manager-cicd/actions/workflows/ci.yml/badge.svg)
![Docker](https://github.com/fallndoumbe/task-manager-cicd/actions/workflows/docker-publish.yml/badge.svg)

Application Laravel de gestion de tâches avec pipeline CI/CD complète.

## Description

Task Manager est une application web développée avec Laravel permettant de gérer des tâches avec différents statuts et priorités. Le projet intègre une pipeline CI/CD complète avec GitHub Actions, Docker et des outils d'analyse de code.

## Prérequis

- PHP 8.2
- Composer
- Node.js 20
- Docker & Docker Compose
- MySQL 8.0
- Git

## Installation locale
```bash
# Cloner le projet
git clone https://github.com/fallndoumbe/task-manager-cicd.git
cd task-manager-cicd

# Installer les dépendances PHP
composer install

# Installer les dépendances JS
npm install

# Configurer l'environnement
cp .env.example .env
php artisan key:generate

# Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=

# Lancer les migrations
php artisan migrate

# Compiler les assets
npm run build

# Lancer le serveur
php artisan serve
```

## Installation Docker
```bash
# Lancer tous les services
docker-compose up -d

# Lancer les migrations
docker-compose exec app php artisan migrate

# Accéder à l'application
http://localhost
```

## Commandes utiles
```bash
# Lancer les tests
php artisan test

# Lancer les tests avec couverture
php artisan test --coverage --min=70

# Analyser le code avec PHPStan
vendor/bin/phpstan analyse

# Vérifier le style du code
vendor/bin/php-cs-fixer fix --dry-run --diff
```

## Structure de la pipeline CI/CD

La pipeline se déclenche automatiquement sur chaque push et PR vers main :

1. **Tests** — exécution des tests avec couverture minimum 70%
2. **PHPStan** — analyse statique du code niveau 5
3. **PHP CS Fixer** — vérification du style du code
4. **Frontend** — build des assets avec Vite
5. **Docker** — publication de l'image sur GHCR

## Workflow Git

Nous utilisons **GitHub Flow** :

1. Chaque fonctionnalité est développée dans une branche séparée depuis main
2. Une Pull Request est créée vers main
3. La PR est reviewée par l'équipe
4. Une fois approuvée elle est mergée dans main
5. La pipeline CI/CD se déclenche automatiquement

## Fonctionnalités

- Créer une tâche avec titre, description, statut, priorité et date limite
- Modifier une tâche existante
- Supprimer une tâche
- Lister toutes les tâches avec filtres par statut
- Voir les détails d'une tâche

## Équipe

- fallndoumbe
- Askia0SN
- MeyDoneta29
- Lindor05
