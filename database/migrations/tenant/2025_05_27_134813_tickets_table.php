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
            $table->id('ticket_number');
            $table->longText('description');
            $table->foreignId('status_id')->constrained('ticket_status', 'id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('level_id')->constrained('ticket_levels', 'id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_id')->constrained('ticket_types', 'id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('accepted_by')->nullable()->constrained('users')->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('file_type'); // image, video, document, etc.
            $table->string('file_path');
            $table->string('file_name');
            $table->foreignId('ticket_number')->constrained('tickets', 'ticket_number')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->longText('content');
            $table->foreignId('ticket_number')->constrained('tickets', 'ticket_number')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sender_id')->constrained('users')->onUpdate('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onUpdate('cascade');
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
