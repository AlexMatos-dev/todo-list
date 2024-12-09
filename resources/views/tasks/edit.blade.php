@extends('layout')

@section('content')
    <h2>{{ isset($task) ? 'Editar Tarefa' : 'Criar Nova Tarefa' }}</h2>

    <form action="{{ isset($task) ? route('tasks.update', $task) : route('tasks.store') }}" method="POST">
        @csrf
        @if(isset($task))
            @method('PUT')
        @endif

        <div>
            <label for="title">Título:</label><br>
            <input type="text" name="title" id="title" value="{{ $task->title ?? '' }}" required style="width: 100%; padding: 10px; margin: 5px 0;">
        </div>

        <div>
            <label for="description">Descrição:</label><br>
            <textarea name="description" id="description" rows="4" style="width: 100%; padding: 10px; margin: 5px 0;">{{ $task->description ?? '' }}</textarea>
        </div>

        <div>
            <label for="completed">Status:</label><br>
            <select name="completed" id="completed" style="width: 100%; padding: 10px; margin: 5px 0;">
                <option value="0" {{ isset($task) && !$task->completed ? 'selected' : '' }}>Pendente</option>
                <option value="1" {{ isset($task) && $task->completed ? 'selected' : '' }}>Concluída</option>
            </select>
        </div>

        <button type="submit" class="btn">{{ isset($task) ? 'Atualizar' : 'Salvar' }}</button>
    </form>
@endsection
