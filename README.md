# LetsEvent
Lets Event project yugioh team

* made in laravel 5.6
* php  7.2.3
* mysql 5.7.14

First download the project and place it in your webserver.

Then go in the folder myapp and open a commandline there (cmd on windows).
Make sure you have composer installed and make sure php is placed in your path variable.

Make your own .env file and make sure the values are set. For the app key run 'php artisan key:generate'.

Run 'composer install'.

When composer is done run these commands:

'php artisan migrate -seed' to create all the tables in the database and run the seeders to fill it with testdata (make sure your database connection is set in the .env file).

'php artisan storage:link' to link the storage to the map "public" to allow users to upload pictures for their event(s).
