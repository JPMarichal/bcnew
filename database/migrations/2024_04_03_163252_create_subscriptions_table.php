<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index(); // Identificador del usuario suscrito
            $table->string('type'); // Tipo de suscripción (noticias, plan de estudio, etc.)
            $table->boolean('is_verified')->default(false); // Gestión del consentimiento
            $table->string('verification_token')->nullable(); // Token para la verificación del correo electrónico
            $table->timestamp('verified_at')->nullable(); // Fecha de verificación
            $table->timestamp('unsubscribed_at')->nullable(); // Permitir al usuario cancelar la suscripción
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
