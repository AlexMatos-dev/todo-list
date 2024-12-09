<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{    public function up()
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();                  // ID único
        $table->string('title');       // Título da tarefa
        $table->text('description')->nullable();  // Descrição opcional
        $table->boolean('completed')->default(false); // Status concluído
        $table->timestamps();          // Created_at e Updated_at
    });
}
};
