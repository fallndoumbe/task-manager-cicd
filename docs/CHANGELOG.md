# Changelog

Tous les changements notables de ce projet sont documentés ici.

## [Unreleased]



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

### Added
- feat(ci): ajout de la configuration `phpstan.neon` (niveau 5) avec prise en charge Laravel via Larastan
- feat(ci): ajout de la configuration PHP CS Fixer via `.php-cs-fixer.dist.php`
- feat(ci): ajout des commandes Composer `phpstan` et `php-cs-fixer`

### Changed
- chore(ci): mise à jour du workflow GitHub Actions pour exécuter PHPStan et PHP CS Fixer avant les migrations et les tests
- chore(deps): ajout des dépendances de qualité de code (`phpstan/phpstan`, `larastan/larastan`, `friendsofphp/php-cs-fixer`)