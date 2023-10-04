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
        Schema::table('posts', function (Blueprint $table) {
            $table->index('reposted_id')->nullable()->constrained('posts');
            $table->foreignId('reposted_id')->nullable()->constrained('posts');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {

            $table->dropForeign('posts_reposted_id_foreign');
            $table->dropIndex(['reposted_id']);
            $table->dropColumn('reposted_id');
        });
    }
};
