<?php

use App\Models\Space;
use App\Models\SpaceResource;
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
        Schema::create('space_resources', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
        });

        Schema::create('space_space_resource', function (Blueprint $table) {
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
        Schema::dropIfExists('space_resources');
        Schema::dropIfExists('space_space_resource');
    }
};
