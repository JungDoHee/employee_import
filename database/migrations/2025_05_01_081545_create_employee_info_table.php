<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_info', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('main_group', 50);
            $table->string('sub_group', 50);
            $table->string('phone_number', 12);
            $table->char('employeement_type', 1);
            $table->string('mail_address', 256);
            $table->string('employee_code', 12);
            $table->integer('salary');
            $table->integer('commuting_expense');
            $table->string('note');
            $table->date('employeement_date');
            $table->date('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_info');
    }
};
