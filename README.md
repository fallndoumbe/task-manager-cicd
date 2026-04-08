# Task Manager CI/CD

![CI](https://github.com/fallndoumbe/task-manager-cicd/actions/workflows/ci.yml/badge.svg)
![Docker](https://github.com/fallndoumbe/task-manager-cicd/actions/workflows/docker-publish.yml/badge.svg)
![Laravel](https://img.shields.io/badge/Framework-Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)

Application Laravel de gestion de tâches avec pipeline CI/CD complète.

---

## 📌 Table des matières

- [Description](#description)
- [Prérequis](#prérequis)
- [Installation locale](#installation-locale)
- [Installation Docker](#installation-docker)
- [Documentation API](#documentation-api)
- [Commandes utiles](#commandes-utiles)
- [Structure de la pipeline CI/CD](#structure-de-la-pipeline-cicd)
- [Workflow Git](#workflow-git)
- [Fonctionnalités](#fonctionnalités)
- [Équipe](#équipe)

---

## Description

Task Manager est une application web développée avec Laravel permettant de gérer des tâches avec différents statuts et priorités. Le projet intègre une pipeline CI/CD complète avec GitHub Actions, Docker et des outils d'analyse de code.

---

## Prérequis

- PHP 8.2
- Composer
- Node.js 20
- Docker & Docker Compose
- MySQL 8.0
- Git

---

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

---

## Installation Docker

```bash
# Lancer tous les services
docker-compose up -d

# Lancer les migrations
docker-compose exec app php artisan migrate

# Accéder à l'application
http://localhost
```

---

## Documentation API

L'API REST est sécurisée via **Laravel Sanctum** (authentification par token Bearer).

### Base URL

```
http://localhost/api
```

### Authentification

Toutes les routes de tâches nécessitent un token d'authentification dans le header :

```
Authorization: Bearer {token}
```

---

### 🔐 Auth

#### Register — Créer un compte

```http
POST /api/register
```

**Body (JSON)**

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

**Réponse `201`**

```json
{
  "token": "1|abc123...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

---

#### Login — Se connecter

```http
POST /api/login
```

**Body (JSON)**

```json
{
  "email": "john@example.com",
  "password": "password"
}
```

**Réponse `200`**

```json
{
  "token": "1|abc123...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

---

#### Logout — Se déconnecter

```http
POST /api/logout
```

> 🔒 Requiert un token Bearer.

**Réponse `200`**

```json
{
  "message": "Déconnexion réussie"
}
```

---

### 📋 Tâches

> 🔒 Toutes les routes ci-dessous requièrent un token Bearer.

#### GET /api/tasks — Lister toutes les tâches

```http
GET /api/tasks
```

**Paramètres de requête (optionnels)**

| Paramètre | Type | Description |
|-----------|------|-------------|
| `status` | `string` | Filtrer par statut : `todo`, `in_progress`, `done` |
| `priority` | `string` | Filtrer par priorité : `low`, `medium`, `high` |

**Exemple**

```http
GET /api/tasks?status=in_progress&priority=high
```

**Réponse `200`**

```json
[
  {
    "id": 1,
    "title": "Mettre en place le CI/CD",
    "description": "Configurer GitHub Actions avec Docker",
    "status": "in_progress",
    "priority": "high",
    "due_date": "2024-12-31",
    "created_at": "2024-11-01T10:00:00Z",
    "updated_at": "2024-11-05T14:30:00Z"
  }
]
```

---

#### GET /api/tasks/{id} — Voir une tâche

```http
GET /api/tasks/{id}
```

**Réponse `200`**

```json
{
  "id": 1,
  "title": "Mettre en place le CI/CD",
  "description": "Configurer GitHub Actions avec Docker",
  "status": "in_progress",
  "priority": "high",
  "due_date": "2024-12-31",
  "created_at": "2024-11-01T10:00:00Z",
  "updated_at": "2024-11-05T14:30:00Z"
}
```

**Réponse `404`**

```json
{
  "message": "Tâche introuvable"
}
```

---

#### POST /api/tasks — Créer une tâche

```http
POST /api/tasks
```

**Body (JSON)**

```json
{
  "title": "Rédiger les tests unitaires",
  "description": "Couvrir les controllers et models",
  "status": "todo",
  "priority": "medium",
  "due_date": "2024-12-15"
}
```

**Champs**

| Champ | Type | Requis | Description |
|-------|------|--------|-------------|
| `title` | `string` | ✅ | Titre de la tâche (max 255) |
| `description` | `string` | ❌ | Description détaillée |
| `status` | `string` | ✅ | `todo` · `in_progress` · `done` |
| `priority` | `string` | ✅ | `low` · `medium` · `high` |
| `due_date` | `date` | ❌ | Date limite (format `YYYY-MM-DD`) |

**Réponse `201`**

```json
{
  "id": 2,
  "title": "Rédiger les tests unitaires",
  "description": "Couvrir les controllers et models",
  "status": "todo",
  "priority": "medium",
  "due_date": "2024-12-15",
  "created_at": "2024-11-10T09:00:00Z",
  "updated_at": "2024-11-10T09:00:00Z"
}
```

---

#### PUT /api/tasks/{id} — Modifier une tâche

```http
PUT /api/tasks/{id}
```

**Body (JSON)** — tous les champs sont optionnels

```json
{
  "status": "done",
  "priority": "low"
}
```

**Réponse `200`**

```json
{
  "id": 2,
  "title": "Rédiger les tests unitaires",
  "description": "Couvrir les controllers et models",
  "status": "done",
  "priority": "low",
  "due_date": "2024-12-15",
  "created_at": "2024-11-10T09:00:00Z",
  "updated_at": "2024-11-12T16:45:00Z"
}
```

---

#### DELETE /api/tasks/{id} — Supprimer une tâche

```http
DELETE /api/tasks/{id}
```

**Réponse `204`** — No Content

---

### ⚠️ Codes d'erreur

| Code | Signification |
|------|---------------|
| `200` | Succès |
| `201` | Ressource créée |
| `204` | Succès sans contenu |
| `401` | Non authentifié — token manquant ou invalide |
| `403` | Accès interdit |
| `404` | Ressource introuvable |
| `422` | Erreur de validation des données |
| `500` | Erreur serveur |

---

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

---

## Structure de la pipeline CI/CD

La pipeline se déclenche automatiquement sur chaque push et PR vers main :

1. **Tests** — exécution des tests avec couverture minimum 70%
2. **PHPStan** — analyse statique du code niveau 5
3. **PHP CS Fixer** — vérification du style du code
4. **Frontend** — build des assets avec Vite
5. **Docker** — publication de l'image sur GHCR

---

## Workflow Git

Nous utilisons **GitHub Flow** :

1. Chaque fonctionnalité est développée dans une branche séparée depuis main
2. Une Pull Request est créée vers main
3. La PR est reviewée par l'équipe
4. Une fois approuvée elle est mergée dans main
5. La pipeline CI/CD se déclenche automatiquement

---

## Fonctionnalités

- Créer une tâche avec titre, description, statut, priorité et date limite
- Modifier une tâche existante
- Supprimer une tâche
- Lister toutes les tâches avec filtres par statut
- Voir les détails d'une tâche

---

## Équipe

- [fallndoumbe](https://github.com/fallndoumbe)
- [Askia0SN](https://github.com/Askia0SN)
- [MeyDoneta29](https://github.com/MeyDoneta29)
- [Lindor05](https://github.com/Lindor05)
