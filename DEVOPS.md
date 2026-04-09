# Documentation DevOps

## 1. Architecture de la pipeline CI/CD

La pipeline CI/CD est configurée avec GitHub Actions et se déclenche automatiquement sur chaque push et Pull Request vers la branche main.

### Jobs de la pipeline
- **tests** : exécute les tests unitaires et feature avec couverture minimum 70%
- **PHPStan** : analyse statique du code niveau 5
- **PHP CS Fixer** : vérifie le style et la mise en forme du code
- **frontend** : compile les assets CSS/JS avec Vite
- **docker-publish** : build et publie l'image Docker sur GHCR

---

## 2. Stratégie de branches Git

Nous utilisons **GitHub Flow** :

- La branche principale est main
- Chaque fonctionnalité est développée dans une branche séparée
- Les branches suivent la convention : feat/, fix/, docs/, chore/
- Une Pull Request est créée vers main pour chaque fonctionnalité
- La PR est reviewée par au moins un membre de l'équipe
- Une fois approuvée elle est mergée dans main

### Branches créées
- feature/CI — pipeline CI/CD GitHub Actions
- feat/task-model-migration — modèle et migration
- feat/task-controller — controller CRUD
- feat/task-routes — routes CRUD
- feat/task-edit-show — vues edit et show
- feat/task-create-and-list — vues create et index
- feature/Unit_test — tests unitaires et feature
- feature/analysecode — PHPStan et PHP CS Fixer
- feature/frontend-docker — vues Blade, Docker et job CI frontend
- feat/docker-publish — publication Docker sur GHCR
- feature/api-testing — routes API pour test Postman
- fix/dockerfile-clean — correction du Dockerfile
- docs/changelog — fichier CHANGELOG.md
- docs/readme-devops — README et DEVOPS
---

## 3. Processus de déploiement

1. Le développeur crée une branche depuis main
2. Il développe sa fonctionnalité avec des commits Conventional Commits
3. Il pousse sa branche sur GitHub
4. Il crée une Pull Request vers main
5. L'équipe fait la code review
6. Une fois approuvée la PR est mergée dans main
7. La pipeline CI/CD se déclenche automatiquement
8. Si tous les checks passent l'image Docker est publiée sur GHCR

---

## 4. Configuration Docker

### Dockerfile — Multi-stage build
- **Stage 1** : utilise composer:2.6 pour installer les dépendances PHP
- **Stage 2** : utilise php:8.2-fpm-alpine image légère pour la production

**Pourquoi ces choix :**
- Alpine réduit la taille de l'image
- Multi-stage évite d'inclure Composer dans l'image finale
- Utilisateur non-root pour la sécurité
- PHP-FPM sur le port 9000 pour communiquer avec Nginx

### Docker Compose — 4 services
- **app** : application Laravel avec notre Dockerfile
- **nginx** : serveur web qui reçoit les requêtes HTTP
- **mysql** : base de données MySQL 8.0
- **redis** : cache pour améliorer les performances

---

## 5. Outils utilisés

| Outil | Rôle |
|---|---|
| **GitHub Actions** | Automatisation de la pipeline CI/CD |
| **PHPStan** | Analyse statique du code PHP pour détecter les erreurs |
| **PHP CS Fixer** | Vérification et correction du style du code |
| **Tailwind CSS CDN** | Style et mise en forme de l'interface utilisateur |
| **Docker** | Conteneurisation de l'application |
| **GHCR** | Registry pour stocker les images Docker |
| **MySQL** | Base de données relationnelle |
| **Redis** | Système de cache |
| **Composer** | Gestionnaire de dépendances PHP |

---

## 6. Difficultés rencontrées et solutions

### Problème 1 : Vite manifest not found
**Problème** : Les tests échouaient sur GitHub Actions car @vite dans le layout cherchait des fichiers compilés inexistants.

**Solution** : Remplacement de @vite par un CDN Tailwind directement dans le layout app.blade.php.

### Problème 2 : Conflits entre branches
**Problème** : Des conflits sont apparus lors du merge de plusieurs branches qui modifiaient les mêmes fichiers.

**Solution** : Faire git pull origin main avant de pusher pour récupérer les dernières modifications.

### Problème 3 : Coverage insuffisant
**Problème** : La couverture de code était inférieure à 70% requis.

**Solution** : Ajout de tests supplémentaires et activation de pcov dans le CI pour mesurer la couverture.
