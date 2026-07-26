<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // De-duplicate any existing colliding invoice numbers BEFORE adding the
        // unique index, so the migration cannot fail on legacy data. Historic
        // numbers are preserved for the first occurrence; later collisions get a
        // "-Dn" disambiguation suffix (rare, and only touches already-broken rows).
        $seen = [];
        foreach (DB::table('payments')->whereNotNull('invoice_number')->orderBy('id')->get() as $row) {
            $inv = $row->invoice_number;
            if ($inv === null || $inv === '') {
                continue;
            }
            if (isset($seen[$inv])) {
                $seen[$inv]++;
                DB::table('payments')->where('id', $row->id)
                    ->update(['invoice_number' => $inv . '-D' . $seen[$inv]]);
            } else {
                $seen[$inv] = 0;
            }
        }

        Schema::table('payments', function (Blueprint $table) {
            $table->unique('invoice_number');
            $table->index('status');
            $table->index('paid_at');
            $table->index('due_date');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropUnique(['invoice_number']);
            $table->dropIndex(['status']);
            $table->dropIndex(['paid_at']);
            $table->dropIndex(['due_date']);
        });
    }
};
