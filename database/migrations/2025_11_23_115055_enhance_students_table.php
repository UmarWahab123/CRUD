<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnhanceStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->nullable()->after('user_id')->constrained()->onDelete('set null');
            $table->foreignId('section_id')->nullable()->after('class_id')->constrained()->onDelete('set null');
            $table->string('admission_number')->unique()->after('section_id');
            $table->string('roll_number')->nullable()->after('admission_number');
            $table->date('date_of_birth')->nullable()->after('name');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            $table->string('blood_group')->nullable()->after('gender');
            $table->string('email')->nullable()->after('blood_group');
            $table->string('phone')->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            $table->date('admission_date')->nullable()->after('address');
            $table->enum('status', ['active', 'inactive', 'graduated', 'transferred'])->default('active')->after('admission_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['class_id']);
            $table->dropForeign(['section_id']);
            $table->dropColumn(['user_id', 'class_id', 'section_id', 'admission_number', 'roll_number', 'date_of_birth', 'gender', 'blood_group', 'email', 'phone', 'address', 'admission_date', 'status']);
        });
    }
}
