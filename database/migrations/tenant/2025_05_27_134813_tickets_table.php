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
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('ticket_number');
            $table->longText('description');
            $table->enum('status', ['open', 'in_progress', 'closed'])->default('open');
            $table->string('type')->default('general'); // general, bug, feature_request
            $table->enum('level', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('accepted_by')->nullable()->constrained('users')->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_number')->constrained('tickets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onUpdate('cascade');
            $table->string('file_type'); // image, video, document, etc.
            $table->string('file_path');
            $table->string('file_name');
            $table->timestamps();
        });
        
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_number')->constrained('tickets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sender_id')->constrained('users')->onUpdate('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onUpdate('cascade');
            $table->longText('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('ticket_attachments');
        Schema::dropIfExists('messages');
    }
};
