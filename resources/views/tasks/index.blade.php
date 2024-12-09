@extends('layout')

@section('content')
    <h2>Minhas Tarefas</h2>
    <a href="{{ route('tasks.create') }}" class="btn">Criar Nova Tarefa</a>

    @if($tasks->isEmpty())
        <p>Não há tarefas no momento. Que tal criar uma?</p>
    @else
        <ul class="task-list">
            @foreach($tasks as $task)
                <li>
                    <div>
                        <strong>{{ $task->title }}</strong>
                        <p>{{ $task->description }}</p>
                        <p><em>{{ $task->completed ? 'Concluída' : 'Pendente' }}</em></p>
                    </div>
                    <div class="task-actions">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn">Editar</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background-color: #f44336;">Deletar</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
