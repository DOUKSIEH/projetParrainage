# projetParrainage

On clone le dépot:

git clone https://github.com/DOUKSIEH/projectParrainage.git

 On se déplace dans le dossier :
 
cd parrainage

On installe les dépendances :

composer install

 On créé la base de données :
php bin/console d:d:c

On exécute les migrations:

php bin/console d:mig:m

On exécute la fixture :

php bin/console doctrine:fixtures:load --no-interaction

On lance le serveur:

php bin/console server:run
