<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("details");
            $table->string('external_details')->nullable();
            $table->boolean("minors");
            $table->boolean("agreement_contract");
            $table->foreignIdFor(\App\Models\File::class, "agreement_contract_file")->nullable()->constrained()->cascadeOnDelete();
            $table->integer("assistance");
            $table->string("observations")->nullable();
            $table->enum("status", ["pending", "approved", "rejected"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
