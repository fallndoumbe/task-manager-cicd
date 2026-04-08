# Changelog

Tous les changements notables de ce projet sont documentés ici.

## [Unreleased]

### Added
- feat(vues): ajout de la vue index avec liste des tâches et filtres par statut
- feat(vues): ajout de la vue create avec formulaire de création de tâche
- feat(docker): ajout du Dockerfile multi-stage (Composer + PHP 8.2 FPM Alpine)
- feat(docker): ajout du docker-compose.yml avec les services app, nginx, mysql et redis
- feat(docker): ajout de la configuration Nginx pour servir Laravel via PHP-FPM
- feat(ci): ajout du job frontend dans la pipeline CI (build Vite + upload artifact)
- feat(ci): ajout du workflow docker-publish.yml pour la publication automatique sur GHCR

### Fixed
- fix(docker): correction du Dockerfile avec --no-scripts pour éviter l'erreur post-autoload-dump

## [1.0.0] - 2026-04-05

### Added
- feat(tasks): création du modèle Task et migration de la base de données
- feat(tasks): ajout du controller avec les méthodes CRUD
- feat(tasks): ajout des routes CRUD pour les tâches
- feat(tasks): ajout des vues edit et show
- feat(tasks): mise en place des tests unitaires et feature
- feat(ci): mise en place du pipeline CI/CD avec GitHub Actions
- feat(ci): ajout de l'analyse de code avec PHPStan et PHP CS Fixer
- feat(ci): ajout du build frontend avec Vite

### Changed
- refactor(tasks): amélioration du TaskController avec filtrage par statut
- refactor(tasks): amélioration du modèle Task avec cast sur due_date

### Fixed
- fix(tests): correction des erreurs dans TaskCreationTest
