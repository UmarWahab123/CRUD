<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnhanceTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->string('employee_id')->unique()->after('user_id');
            $table->string('qualification')->nullable()->after('phone');
            $table->string('designation')->nullable()->after('qualification');
            $table->string('department')->nullable()->after('designation');
            $table->date('date_of_joining')->nullable()->after('department');
            $table->decimal('salary', 10, 2)->nullable()->after('date_of_joining');
            $table->text('address')->nullable()->after('salary');
            $table->string('profile_image')->nullable()->after('address');
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active')->after('profile_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'employee_id', 'qualification', 'designation', 'department', 'date_of_joining', 'salary', 'address', 'profile_image', 'status']);
        });
    }
}
