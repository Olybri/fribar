# FriBar
Site web recensant les bars de la ville de Fribourg (CH).

### Installation

- Cloner le dépôt à la racine des documents web.
- Installer les dépendances.
```bash
composer install
```
- Initialiser Phinx et indiquer les identifiants de connexion à la base de donnée dans le fichier *phinx.yml*.
```bash
vendor/bin/phinx init
vim phinx.yml
```
- Appliquer les migrations pour générer le schéma de la base de donnée.
```bash
vendor/bin/phinx migrate
```
- Optionnel : remplir la base de donnée avec quelques valeurs pour les tests.
```bash
vendor/bin/phinx seed:run
```