# README - Guide d'installation et de test

## Prérequis

Avant de commencer, assurez-vous d'avoir installé sur votre machine :
- **PHP** (version 8.3 recommandée)
- **MySQL** ou un gestionnaire de base de données compatible
- Un client de gestion de base de données (MySQL Workbench, DBeaver, phpMyAdmin, etc.)

## Installation

### 1. Initialisation de la base de données

La première étape consiste à créer la structure de la base de données.

1. Ouvrez votre gestionnaire de base de données (MySQL Workbench, DBeaver, phpMyAdmin, etc.)
2. Créez une nouvelle base de données si nécessaire
3. Ouvrez le fichier `database.sql` situé dans le dossier sql (/sql/database.sql)
4. Copiez l'intégralité du code SQL
5. Exécutez ce code dans votre gestionnaire de base de données

Cela créera toutes les tables nécessaires au fonctionnement de l'application.

### 2. Insertion des données de test (seeding)

Pour peupler la base de données avec des données de démonstration :

1. Ouvrez le fichier `seed.sql` situé dans le dossier sql (/sql/database.sql)
2. Copiez l'intégralité du code SQL
3. Exécutez ce code dans votre gestionnaire de base de données

La base de données contiendra maintenant des données de test permettant de tester toutes les fonctionnalités.

### 3. Configuration de l'application

Modifiez le fichier `config.ini` à la racine du projet pour configurer les paramètres de l'application :

```ini
[mariadb]
dsn = "mysql:host=127.0.0.1;dbname=firemen;charset=utf8"
user = "firemen_user"
password = "1234"
```

**Note :** Assurez-vous également que les paramètres de connexion à la base de données dans le fichier de configuration correspondent à votre environnement local (host, nom de la base, utilisateur, mot de passe).

### 4. Lancement du serveur PHP

Depuis la racine du projet, ouvrez un terminal et exécutez la commande suivante :

```bash
php -S 127.0.0.1:8080 -t public/
```

Cette commande démarre un serveur PHP de développement qui écoute sur le port 8080.

### 5. Accès à l'application

Ouvrez votre navigateur et accédez à l'adresse :

```
http://127.0.0.1:8080
```

## Comptes de test

Pour tester l'application avec différents niveaux de privilèges, utilisez les identifiants suivants :

### Administrateur
- **Email :** `m.simon@gmail.com`
- **Mot de passe :** `motdepasse`

### Secrétaire
- **Email :** `p.lefebvre@gmail.com`
- **Mot de passe :** `motdepasse`

### Utilisateur standard
- **Email :** `l.garnier@gmail.com`
- **Mot de passe :** `motdepasse`

## Dépannage

Si vous rencontrez des problèmes :

- Vérifiez que le serveur PHP est bien démarré
- Assurez-vous que les scripts SQL ont été exécutés sans erreur
- Vérifiez les paramètres de connexion à la base de données dans le fichier de configuration
- Consultez les logs de l'application pour identifier les erreurs éventuelles

## Contact

Pour toute question concernant l'installation ou l'utilisation du projet, n'hésitez pas à me contacter.