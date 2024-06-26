<?php

use App\Models\Booking;
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

        Schema::create('space_file', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Space::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(File::class)->constrained()->cascadeOnDelete();
        });

        Schema::create('campus_file', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Campus::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(File::class)->constrained()->cascadeOnDelete();
        });

        Schema::create('booking_file', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(File::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Booking::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
        Schema::dropIfExists('space_file');
        Schema::dropIfExists('campus_file');
        Schema::dropIfExists('booking_file');
    }
};
