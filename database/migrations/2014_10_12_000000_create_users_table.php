<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('dob')->nullable();
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->enum('gender',['Male','Female'])->default('Male');
            $table->enum('theme',['dark','light'])->default('light');
            $table->string('two_factor_code')->nullable();
            $table->dateTime('two_factor_expires_at')->nullable();
            $table->boolean('is_authenticate')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
        // User::create(['name' => 'Nabeel Baig','dob'=>'2000-10-10','email' => 'admin@technosavvyllc.com','password' => Hash::make('123456'),'email_verified_at'=>'2022-01-02 17:04:58','avatar' => 'images/avatar-1.jpg','created_at' => now(),]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
