<?php

namespace App\Helpers;

use Illuminate\Database\Schema\Blueprint;

class MigrationHelper
{
    public static function addUserReferences(Blueprint $table)
    {
        $table->bigInteger('created_by_id')->unsigned();
        $table->bigInteger('responsible_user_id')->unsigned();

        $table->foreign('responsible_user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('created_by_id')->references('id')->on('users')->onDelete('cascade');
    }
}
