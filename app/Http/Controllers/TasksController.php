<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    // getでTask/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
      
        if (\Auth::check()) {
            
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
     

            return view('task.index', [
                'tasks' => $tasks,
            ]);
        }
        return view('welcome');
    }
    // getでTask/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        return view('task.create', [
            'task' => $task,
        ]);
    }

    // postでTask/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        $this->validate($request,[
            'status' => 'required|max:10',
            'content' => 'required|max:191',
        ]);
        
     
        
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
            ]);
            

        return redirect('/');
    }

    // getでTask/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        $task = Task::find($id);

        if(\Auth::id() === $task->user_id){ 
            return view('task.show', [
                'task' => $task,
            ]);
        }
        return redirect('/');       //追加
    }

    // getでTask/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        $task = Task::find($id);

        if(\Auth::id() === $task->user_id){//追加
            return view('task.edit', [
                'task' => $task,
            ]);
        }
        return redirect('/');       //追加
    }

    // putまたはpatchでTask/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        
        $task = Task::find($id);
        
        $this->validate($request, [
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:191',
            
        ]);
        
        if(\Auth::id() === $task->user_id){
            $task = Task::find($id);
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
        }

        return redirect('/');
    }

    // deleteでTask/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $task = Task::find($id);
        
        if(\Auth::id() === $task->user_id) {
        $task->delete();
        }

        return redirect('/');
    }
}
