<?php

use App\Helpers\MigrationHelper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_id')->constrained('agreements')->onDelete('cascade');
            MigrationHelper::addUserReferences($table);
            $table->string('name');
            $table->string('room_type');
            $table->date('passport_issue_date');
            $table->date('passport_expire_date');
            $table->string('passport_number');
            $table->string('country_of_issue');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('costume_size')->nullable();
            $table->string('passport_image_type')->nullable();
            $table->string('hotel');
            $table->string('visa_type')->nullable();
            $table->string('transportation');
            // $table->bigInteger('created_by');
            // $table->bigInteger('responsible_user_id');
            $table->text('comments')->nullable();
            $table->string('status');
            $table->timestamps();

            // $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('responsible_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_lists');
    }
};
