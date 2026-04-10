<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('subco');
            $table->string('religion')->nullable()->after('gender');
            $table->string('division')->nullable()->after('religion');
            $table->string('organization_unit')->nullable()->after('division');
            $table->string('position')->nullable()->after('organization_unit');
            $table->string('job_family')->nullable()->after('position');
            $table->string('work_location')->nullable()->after('job_family');
            $table->string('employment_status')->nullable()->after('work_location');
            $table->string('employee_status')->nullable()->after('employment_status');
            $table->string('immediate_supervisor')->nullable()->after('employee_status');
            $table->string('immediate_manager')->nullable()->after('immediate_supervisor');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'religion',
                'division',
                'organization_unit',
                'position',
                'job_family',
                'work_location',
                'employment_status',
                'employee_status',
                'immediate_supervisor',
                'immediate_manager',
            ]);
        });
    }
};
