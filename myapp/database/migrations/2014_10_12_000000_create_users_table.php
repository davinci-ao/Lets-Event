<<<<<<< HEAD
<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateUsersTable extends Migration {

	    /**
	     * Run the migrations.
	     *
	     * @return void
	     */
	    public function up() {
		    Schema::create('users', function (Blueprint $table) {
			    $table->increments('id');
			    $table->string('student_nr');
			    $table->string('firstname');
			    $table->string('lastname');
			    $table->integer('education_location_id');
			    $table->string('email')->unique();
			    $table->string('email-hash-user');
			    $table->datetime('email-hash');
			    $table->string('password');
			    $table->enum('role', ['leerling', 'leeraar']);
			    $table->enum('activated', ['geactivateerd', 'niet geactiveerd']);
			    $table->rememberToken();
			    $table->timestamps();
		    });
	    }

	    /**
	     * Reverse the migrations.
	     *
	     * @return void
	     */
	    public function down() {
		    Schema::dropIfExists('users');
	    }

    }
    
=======
<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateUsersTable extends Migration {

	    /**
	     * Run the migrations.
	     *
	     * @return void
	     */
	    public function up() {
		    Schema::create('users', function (Blueprint $table) {
			    $table->increments('id');
			    $table->string('student_nr');
			    $table->string('firstname');
			    $table->string('lastname');
			    $table->integer('education_location_id');
			    $table->string('email')->unique();
			    $table->string('email-hash-user');
			    $table->string('password');
			    $table->enum('role', ['leerling', 'leeraar']);
			    $table->enum('activated', ['geactivateerd', 'niet geactiveerd']);
			    $table->rememberToken();
			    $table->timestamps();
		    });
	    }

	    /**
	     * Reverse the migrations.
	     *
	     * @return void
	     */
	    public function down() {
		    Schema::dropIfExists('users');
	    }

    }
    
>>>>>>> 69a981a70367703a5f65b37cde26dcbd2c48dd49
