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
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            MigrationHelper::addUserReferences($table);
            $table->date('flight_date');
            $table->integer('duration_of_stay');
            $table->string('client_name');
            $table->string('client_relatives')->nullable();
            $table->string('tariff_name');
            $table->string('room_type');
            $table->string('transportation');
            $table->decimal('exchange_rate', total:8, places:2);
            $table->decimal('total_price', total:15, places:2);
            $table->decimal('payment_paid', total:15, places:2);
            $table->json('phone_numbers');
            $table->boolean('previous_agreement_taken_away')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
            
            // $table->bigInteger('responsible_user_id')->unsigned(); // Foreign key
            // $table->bigInteger('created_by')->unsigned(); // Foreign key
            // Define foreign key constraints
            // $table->foreign('responsible_user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
