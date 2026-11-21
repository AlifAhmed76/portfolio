<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('code_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->cascadeOnDelete();
            $table->string('relative_path');
            $table->string('file_type', 30)->default('blade'); // blade, css, js, json
            $table->string('current_hash', 64)->nullable();
            $table->foreignId('last_modified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['workspace_id', 'relative_path']);
        });

        Schema::create('code_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('code_file_id')->constrained('code_files')->cascadeOnDelete();
            $table->unsignedInteger('revision_number');
            $table->longText('content');
            $table->string('hash', 64);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['code_file_id', 'revision_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('code_revisions');
        Schema::dropIfExists('code_files');
    }
};
