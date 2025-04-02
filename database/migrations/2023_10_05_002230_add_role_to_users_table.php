<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reverse the previous migration (delete role column).
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role'); // Supprime la colonne `role`
        });
    }

    /**
     * Reverse the changes if necessary.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user'); // Ajout de la colonne si rollback
        });
    }
};
