<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

![CI](https://github.com/fallndoumbe/task-manager-cicd/actions/workflows/ci.yml/badge.svg)
![Docker](https://github.com/fallndoumbe/task-manager-cicd/actions/workflows/docker-publish.yml/badge.svg)
![Laravel](https://img.shields.io/badge/Framework-Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)
<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

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
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

---

## Prérequis
Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

---

## Installation locale

```bash
# Cloner le projet
git clone https://github.com/fallndoumbe/task-manager-cicd.git
cd task-manager-cicd
Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

---

## Installation Docker

```bash
# Lancer tous les services
docker-compose up -d
## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

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
If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

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
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
