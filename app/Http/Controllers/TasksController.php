<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    // getでTask/にアクセスされた場合の「一覧表示処理」
    public function index()
    {

        $task = Task::all();

        return view('task.index', [
            'task' => $task,
        ]);
    }
    // getでTask/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new task;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    // postでTask/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        $task = new task;
        $task->content = $request->content;
        $task->save();

        return redirect('/');
    }

    // getでTask/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        $task = Task::find($id);

        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    // getでTask/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        $task = Task::find($id);

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    // putまたはpatchでTask/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->content = $request->content;
        $task->save();

        return redirect('/');
    }

    // deleteでTask/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        return redirect('/');
    }
}