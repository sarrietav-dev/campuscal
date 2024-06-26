<?php

use App\Models\Campus;
use App\Models\File;
use App\Models\Space;
use App\Models\SpaceResource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spaces', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
            $table->foreignIdFor(Campus::class);
        });

        Schema::create('spaces_images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Space::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(File::class)->constrained()->cascadeOnDelete();
        });

        Schema::create('space_resources', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Space::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SpaceResource::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spaces');
        Schema::dropIfExists('spaces_images');
        Schema::dropIfExists('space_resources');
    }
};
