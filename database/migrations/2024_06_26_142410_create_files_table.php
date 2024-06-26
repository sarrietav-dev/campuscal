<?php

use App\Models\Campus;
use App\Models\File;
use App\Models\Space;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
            $table->string("path");
            $table->string("type");
        });

        Schema::create('spaces_images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Space::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(File::class)->constrained()->cascadeOnDelete();
        });

        Schema::create('campuses_images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Campus::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(File::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
        Schema::dropIfExists('spaces_images');
        Schema::dropIfExists('campuses_images');
    }
};
