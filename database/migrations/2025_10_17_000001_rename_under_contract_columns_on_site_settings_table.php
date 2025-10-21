<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'page_under_contract')) {
                $table->renameColumn('page_under_contract', 'page_under_maintenance');
            }
            if (Schema::hasColumn('site_settings', 'under_contract_message')) {
                $table->renameColumn('under_contract_message', 'under_maintenance_message');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'page_under_maintenance')) {
                $table->renameColumn('page_under_maintenance', 'page_under_contract');
            }
            if (Schema::hasColumn('site_settings', 'under_maintenance_message')) {
                $table->renameColumn('under_maintenance_message', 'under_contract_message');
            }
        });
    }
};
