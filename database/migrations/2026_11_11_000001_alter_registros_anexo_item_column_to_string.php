<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('registros_anexo')) {
            return;
        }

        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('DROP INDEX IF EXISTS registros_anexo_anexo_id_item_unique');
            DB::statement('DROP INDEX IF EXISTS registros_anexo_anexo_id_estado_entregable_index');
            DB::statement('DROP INDEX IF EXISTS registros_anexo_visitado_efectividad_index');
            DB::statement('PRAGMA foreign_keys = OFF');
            DB::statement('ALTER TABLE registros_anexo RENAME TO registros_anexo_old');

            Schema::create('registros_anexo', function (Blueprint $table) {
                $table->id();
                $table->foreignId('anexo_id')->constrained('anexos')->cascadeOnDelete();
                $table->string('item', 50);
                $table->string('codigo_unidad', 100)->nullable();
                $table->string('expediente_siged', 100)->nullable();
                $table->date('fecha_asignacion')->nullable();
                $table->string('numero_documento', 100)->nullable();
                $table->string('codigo_osinergmin', 100)->nullable();
                $table->string('codigo_actividad', 100)->nullable();
                $table->string('razon_social_agente')->nullable();
                $table->string('tipo_supervision', 150)->nullable();
                $table->string('tipo_entregable', 150)->nullable();
                $table->string('numero_informe', 100)->nullable();
                $table->boolean('visitado')->default(false);
                $table->boolean('efectividad')->default(false);
                $table->date('fecha_visita')->nullable();
                $table->date('fecha_derivacion')->nullable();
                $table->string('estado_entregable', 100)->nullable();
                $table->string('personal_es', 150)->nullable();
                $table->text('observaciones')->nullable();
                $table->text('comentarios')->nullable();
                $table->timestamps();

                $table->unique(['anexo_id', 'item']);
                $table->index(['anexo_id', 'estado_entregable']);
                $table->index(['visitado', 'efectividad']);
            });

            DB::statement('INSERT INTO registros_anexo (id, anexo_id, item, codigo_unidad, expediente_siged, fecha_asignacion, numero_documento, codigo_osinergmin, codigo_actividad, razon_social_agente, tipo_supervision, tipo_entregable, numero_informe, visitado, efectividad, fecha_visita, fecha_derivacion, estado_entregable, personal_es, observaciones, comentarios, created_at, updated_at) SELECT id, anexo_id, CAST(item AS TEXT), codigo_unidad, expediente_siged, fecha_asignacion, numero_documento, codigo_osinergmin, codigo_actividad, razon_social_agente, tipo_supervision, tipo_entregable, numero_informe, visitado, efectividad, fecha_visita, fecha_derivacion, estado_entregable, personal_es, observaciones, comentarios, created_at, updated_at FROM registros_anexo_old');
            DB::statement('DROP TABLE registros_anexo_old');
            DB::statement('PRAGMA foreign_keys = ON');

            return;
        }

        Schema::table('registros_anexo', function (Blueprint $table) {
            $table->string('item', 50)->change();
        });
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('DROP INDEX IF EXISTS registros_anexo_anexo_id_item_unique');
            DB::statement('DROP INDEX IF EXISTS registros_anexo_anexo_id_estado_entregable_index');
            DB::statement('DROP INDEX IF EXISTS registros_anexo_visitado_efectividad_index');
            DB::statement('PRAGMA foreign_keys = OFF');
            DB::statement('ALTER TABLE registros_anexo RENAME TO registros_anexo_old');

            Schema::create('registros_anexo', function (Blueprint $table) {
                $table->id();
                $table->foreignId('anexo_id')->constrained('anexos')->cascadeOnDelete();
                $table->unsignedInteger('item');
                $table->string('codigo_unidad', 100)->nullable();
                $table->string('expediente_siged', 100)->nullable();
                $table->date('fecha_asignacion')->nullable();
                $table->string('numero_documento', 100)->nullable();
                $table->string('codigo_osinergmin', 100)->nullable();
                $table->string('codigo_actividad', 100)->nullable();
                $table->string('razon_social_agente')->nullable();
                $table->string('tipo_supervision', 150)->nullable();
                $table->string('tipo_entregable', 150)->nullable();
                $table->string('numero_informe', 100)->nullable();
                $table->boolean('visitado')->default(false);
                $table->boolean('efectividad')->default(false);
                $table->date('fecha_visita')->nullable();
                $table->date('fecha_derivacion')->nullable();
                $table->string('estado_entregable', 100)->nullable();
                $table->string('personal_es', 150)->nullable();
                $table->text('observaciones')->nullable();
                $table->text('comentarios')->nullable();
                $table->timestamps();

                $table->unique(['anexo_id', 'item']);
                $table->index(['anexo_id', 'estado_entregable']);
                $table->index(['visitado', 'efectividad']);
            });

            DB::statement('INSERT INTO registros_anexo (id, anexo_id, item, codigo_unidad, expediente_siged, fecha_asignacion, numero_documento, codigo_osinergmin, codigo_actividad, razon_social_agente, tipo_supervision, tipo_entregable, numero_informe, visitado, efectividad, fecha_visita, fecha_derivacion, estado_entregable, personal_es, observaciones, comentarios, created_at, updated_at) SELECT id, anexo_id, CAST(item AS INTEGER), codigo_unidad, expediente_siged, fecha_asignacion, numero_documento, codigo_osinergmin, codigo_actividad, razon_social_agente, tipo_supervision, tipo_entregable, numero_informe, visitado, efectividad, fecha_visita, fecha_derivacion, estado_entregable, personal_es, observaciones, comentarios, created_at, updated_at FROM registros_anexo_old');
            DB::statement('DROP TABLE registros_anexo_old');
            DB::statement('PRAGMA foreign_keys = ON');

            return;
        }

        Schema::table('registros_anexo', function (Blueprint $table) {
            $table->unsignedInteger('item')->change();
        });
    }
};
