<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_conversations', function (Blueprint $table) {
            $table->foreignId('sender_id')->nullable()->after('title')->constrained('users')->nullOnDelete();
            $table->foreignId('receiver_id')->nullable()->after('sender_id')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('chat_conversations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sender_id');
            $table->dropConstrainedForeignId('receiver_id');
        });
    }
};
