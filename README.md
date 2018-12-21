# LetsEvent
Lets Event project yugioh team

* made in laravel 5.6
* php  7.2.3
* mysql 5.7.14

First download the project and place it in your webserver


Make your own .env file and make sure the values are set for the api key by running
php artisan key:generate 

Make sure php is placed in your path variable

Then go in the folder myapp and open a commandline there (cmd on windows)
Make sure you have composer installed and run composer install

Then after that is done run the commands

php artisan migrate -seed
makes the database and runs the seeders

php artisan storage:link
link the storage to public to allow users to upload tumbnails and pictures for their event(s)