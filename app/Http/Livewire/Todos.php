<?php

namespace App\Http\Livewire;

use App\Models\Todo;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Todos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $todo;
    public $updateMode = false;
    public $selected_id;

    public $search;
    protected $queryString = ['search'];

    protected $rules = [
        'todo' => 'required',
    ];
    /*protected $messages = [
        'todo.required' => 'Lütfen bir görev ekleyin'
    ];*/

    /**
     *  Livewire Lifecycle Hook
     */
    public function updatingSearch(): void
    {
        $this->gotoPage(1);
    }

    public function render()
    {
        $auth_admin = Auth::user()->is_admin;
        if ($auth_admin == 1){
            $todos = Todo::where('todo', 'like', '%'.$this->search.'%')
                ->orderBy('todos.id','DESC')
                ->paginate(10);
        }else{
            $todos = Todo::where([
                ['user_id',Auth::id()],
                ['todo', 'like', '%'.$this->search.'%'],
            ])->orderBy('id','DESC')
              ->paginate(10);
        }

        return view('livewire.todos',compact('todos'));
    }

    public function addTodo()
    {
        $this->validate();
        $todo = new Todo();
        $todo->user_id = Auth::id();
        $todo->todo = $this->todo;
        $todo->done = 0;
        $todo->save();

        session()->flash('message','Todo oluşturuldu');

    }

    public function editTodo($id)
    {
        if ($id){
            $todo = Todo::where('id',$id)->first();
            $this->todo = $todo->todo;
            $this->updateMode = true;
            $this->selected_id = $todo->id;
        }
    }

    public function updateTodo()
    {
        $todo = Todo::where('id',$this->selected_id)->first();
        //$todo->user_id = Auth::id();
        $todo->todo = $this->todo;
        $todo->save();
        session()->flash('message','Todo güncellendi');
    }

    public function changeDone($id)
    {
        $todos = Todo::where('id',$id)->first();
        if ($todos->done == 1){
            $todos->done = 0;
        }else{
            $todos->done = 1;
        }
        $todos->save();
    }


    public function destroyTodo($id)
    {
        if ($id){
            $todo = Todo::where('id',$id)->first();
            $todo->delete();
        }
    }

}
