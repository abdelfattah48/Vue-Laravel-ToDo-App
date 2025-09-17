Application To-Do List (Laravel + Vue.js)

Cette application est une To-Do List Full Stack avec authentification sécurisée (JWT), gestion des tâches (CRUD), et notifications en temps réel via Pusher.

### Technologies utilisées

Backend : Laravel + MySQL

Frontend : Vue.js + Pinia

API Calls : Axios

WebSockets : Pusher + Laravel Echo

Authentification : JWT

### Installation du projet

 Configuration du Backend (Laravel)
cd backend
composer install

php artisan key:generate

## Configuration du fichier .env

Créer une base de données vide dans MySQL todo_app.



Exécuter les migrations :

php artisan migrate

## JWT (Authentification)

Générer un secret JWT :

php artisan jwt:secret

### Pusher (Notifications en temps réel)

Créer un compte sur Pusher.

Créer une nouvelle application "Channels" nommée "tasks"  dans cluster selectioner m1 .

Récupérer vos identifiants (App ID, Key, Secret, Cluster) et les ajouter dans .env :

PUSHER_APP_ID=your_app_id

PUSHER_APP_KEY=your_key

PUSHER_APP_SECRET=your_secret

PUSHER_APP_CLUSTER=mt1

BROADCAST_DRIVER=pusher

QUEUE_CONNECTION=sync


### Lancer le serveur Laravel
php artisan serve

Assurez-vous que le dossier vendor/ est présent après composer install.