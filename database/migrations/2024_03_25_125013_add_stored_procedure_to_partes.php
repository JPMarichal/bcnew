<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddStoredProcedureToPartes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE PROCEDURE ActualizarOrdenPartesPorPrimerCapitulo()
        BEGIN
            DECLARE hecho INT DEFAULT FALSE;
            DECLARE _parteId BIGINT;
            DECLARE _primerCapituloId BIGINT;

            DECLARE partesCursor CURSOR FOR
                SELECT p.id, MIN(c.id) AS primerCapituloId
                FROM partes p
                JOIN capitulos c ON p.id = c.parte_id
                GROUP BY p.id;

            DECLARE CONTINUE HANDLER FOR NOT FOUND SET hecho = TRUE;

            OPEN partesCursor;

            bucle: LOOP
                FETCH partesCursor INTO _parteId, _primerCapituloId;
                IF hecho THEN
                    LEAVE bucle;
                END IF;

                UPDATE partes SET orden = _primerCapituloId WHERE id = _parteId;
            END LOOP;

            CLOSE partesCursor;
        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ActualizarOrdenPartesPorPrimerCapitulo");
    }
}
