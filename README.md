# Projeto ToDo List

## O que é o Projeto ToDo List?
O ToDo List é uma aplicação para gerenciar tarefas, permitindo que o usuário crie, leia, atualize e exclua tarefas. Esse tipo de aplicação envolve as operações básicas de um sistema CRUD (Create, Read, Update, Delete).

Com Laravel, estamos explorando:

- Rotas básicas
- Controladores e modelos
- Operações com o banco de dados via Eloquent ORM
- Visualizações dinâmicas com Blade

Agora, vou detalhar cada etapa do que foi implementado.

## 1. Estrutura do Projeto Laravel
Quando criamos o projeto com `laravel new todo-list`, o Laravel gerou uma estrutura organizada com pastas e arquivos. Aqui estão os principais diretórios usados:

- `routes/web.php`: Onde definimos as rotas HTTP.
- `app/Models`: Contém os modelos, que representam as tabelas do banco.
- `app/Http/Controllers`: Contém os controladores, onde fica a lógica do negócio.
- `resources/views`: Contém as visualizações (páginas do front-end) usando Blade.
- `database/migrations`: Contém os arquivos para criar e modificar tabelas no banco de dados.

## 2. Configuração do Banco de Dados
No arquivo `.env`, configuramos o banco de dados para que o Laravel possa se conectar a ele. Por exemplo:

-`env
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=todo_list
- DB_USERNAME=root
- DB_PASSWORD=

Isso garante que as operações com o banco sejam realizadas corretamente.
## 3. Criação da Tabela de Tarefas
Usamos o comando php artisan make:migration create_tasks_table para criar um arquivo de migração. Esse arquivo define como a tabela tasks será estruturada no banco de dados. No arquivo de migração, adicionamos colunas como title e description:
php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->timestamps(); // Cria 'created_at' e 'updated_at'
});

Depois, executamos php artisan migrate para aplicar a migração e criar a tabela no banco de dados.
## 4. Criamos o Modelo Task
O modelo é a representação da tabela no código. Criamos o modelo Task com o comando:
bash
php artisan make:model Task

No modelo, podemos configurar os atributos que podem ser manipulados pelo Laravel:
php
class Task extends Model
{
    protected $fillable = ['title', 'description'];
}

Isso permite que possamos inserir e atualizar dados no banco com o Eloquent ORM.
## 5. Criamos o Controlador TaskController
O controlador gerencia a lógica de negócios. Criamos o TaskController com:
bash
php artisan make:controller TaskController

Dentro dele, implementamos os métodos para o CRUD:
index(): Lista todas as tarefas.
create(): Exibe o formulário para criar uma nova tarefa.
store(): Salva uma nova tarefa no banco de dados.
edit(): Exibe o formulário para editar uma tarefa existente.
update(): Atualiza os dados de uma tarefa.
destroy(): Remove uma tarefa.
Exemplo do método store para salvar uma nova tarefa:
php
  public function store(Request $request)
  {
    $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable'
    ]);

    Task::create($request->all());
    return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
}

## 6. Rotas do Sistema
No arquivo routes/web.php, conectamos as URLs da aplicação com os métodos do controlador. Por exemplo:
php
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Essas rotas tornam o sistema navegável.
## 7. Visualizações com Blade
No diretório resources/views, criamos as páginas usando o Blade, o mecanismo de templates do Laravel. Por exemplo:
index.blade.php: Exibe uma lista de tarefas.
create.blade.php: Exibe o formulário de criação.
edit.blade.php: Exibe o formulário de edição.
Um exemplo da página index.blade.php:
text
@extends('layout')

@section('content')
<h1>Lista de Tarefas</h1>
<a href="{{ route('tasks.create') }}">Criar Nova Tarefa</a>
<ul>
    @foreach ($tasks as $task)
        <li>
            <strong>{{ $task->title }}</strong>: {{ $task->description }}
            <a href="{{ route('tasks.edit', $task) }}">Editar</a>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Remover</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection
