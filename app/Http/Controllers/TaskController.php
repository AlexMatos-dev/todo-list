<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

 class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
{
    $tasks = Task::all();
    return view('tasks.index', compact('tasks'));
}
    /**
     * Show the form for creating a new task.
     *
     * @return \Illuminate\View\View
     */
public function create()
{
    return view('tasks.create');
}
    /**
     * Store a newly created task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    Task::create($request->all());

    return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
}
    /**
     * Show the form for editing the specified task.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\View\View
     */
public function edit(Task $task)
{
    return view('tasks.edit', compact('task'));
}
    /**
     * Update the specified task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, Task $task)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $task->update($request->all());

    return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
}
    /**
     * Remove the specified task from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
public function destroy(Task $task)
{
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Tarefa deletada com sucesso!');
}


}
