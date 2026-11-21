<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('version')->default('1.0.0');
            $table->json('manifest_json');
            $table->foreignId('preview_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('status')->default('active'); // active, disabled
            $table->timestamps();
        });

        Schema::create('workspace_themes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->cascadeOnDelete();
            $table->foreignId('theme_id')->constrained('themes')->cascadeOnDelete();
            $table->boolean('is_active')->default(false);
            $table->timestamp('activated_at')->nullable();
            $table->timestamps();

            $table->unique(['workspace_id', 'theme_id']);
            $table->index(['workspace_id', 'is_active']);
        });

        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->cascadeOnDelete();
            $table->foreignId('theme_id')->constrained('themes')->cascadeOnDelete();
            $table->json('settings_json')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['workspace_id', 'theme_id']);
        });

        Schema::create('theme_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->cascadeOnDelete();
            $table->foreignId('theme_id')->constrained('themes')->cascadeOnDelete();
            $table->integer('revision_number');
            $table->json('settings_snapshot')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['workspace_id', 'theme_id', 'revision_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theme_revisions');
        Schema::dropIfExists('theme_settings');
        Schema::dropIfExists('workspace_themes');
        Schema::dropIfExists('themes');
    }
};
