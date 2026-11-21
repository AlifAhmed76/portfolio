<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->nullable()->constrained('workspaces')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->json('metadata')->nullable();
            $table->string('ip_hash', 64)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['workspace_id', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->cascadeOnDelete();
            $table->string('setting_key');
            $table->longText('setting_value')->nullable();
            $table->string('value_type')->default('string'); // string, json, boolean, integer
            $table->timestamps();

            $table->unique(['workspace_id', 'setting_key']);
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->unique()->constrained('workspaces')->cascadeOnDelete();
            $table->string('name');
            $table->string('designation');
            $table->string('headline');
            $table->longText('bio')->nullable();
            $table->unsignedBigInteger('profile_image_id')->nullable();
            $table->unsignedBigInteger('avatar_image_id')->nullable();
            $table->unsignedBigInteger('resume_media_id')->nullable();
            $table->timestamps();
        });

        Schema::create('contact_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->unique()->constrained('workspaces')->cascadeOnDelete();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('location')->nullable();
            $table->string('availability_status')->default('available');
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->cascadeOnDelete();
            $table->string('platform');
            $table->string('label');
            $table->text('url');
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();

            $table->index(['workspace_id', 'sort_order']);
        });

        Schema::create('seo_metadata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->cascadeOnDelete();
            $table->string('seoable_type');
            $table->unsignedBigInteger('seoable_id');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->unsignedBigInteger('og_image_id')->nullable();
            $table->timestamps();

            $table->unique(['workspace_id', 'seoable_type', 'seoable_id'], 'seo_workspace_morph_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_metadata');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('contact_details');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('activity_logs');
    }
};
