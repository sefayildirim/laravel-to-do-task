<div>
    <div class="container">
        <div class="row">

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            @if($updateMode)
                    <form wire:submit.prevent="updateTodo">
                        <div class="container">
                            <div class="row">
                                <h4>Update Todo</h4>
                                <div class="col-md-10">
                                    <input wire:model="todo" type="text" class="form-control">
                                    <input type="hidden" name="">
                                    @error('todo')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-plus"></i> Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
            @else
                    <form wire:submit.prevent="addTodo">
                        <div class="container">
                            <div class="row">
                                <h4>New Todo</h4>
                                <div class="col-md-10">
                                    <input wire:model="todo" type="text" class="form-control">
                                    <input type="hidden" name="">
                                    @error('todo')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add</button>
                                </div>
                            </div>
                        </div>
                    </form>
            @endif
                <form wire:submit.prevent="addTodo"class="mt-4">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2">
                                <h6>Search Todo</h6>
                                <input class="form-control" wire:model="search" type="search" placeholder="Search Todo...">
                            </div>
                        </div>
                    </div>
                </form>

                <div class="text-center mt-4">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Todo</th>
                        <th scope="col">Transactions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($todos as $todo)
                        <tr>
                        <td wire:click="changeDone({{ $todo->id }})" style="cursor: pointer; text-decoration: {{ $todo->done==1 ? 'line-through' : '' }}">{{ $todo->todo }}</td>
                        <td>
                            <a wire:click.prevent="editTodo({{ $todo->id }})" href="#"><button class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button></a>
                            <a wire:click.prevent="destroyTodo({{ $todo->id }})" href="#"><button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $todos->links() }}
            </div>
        </div>
    </div>
</div>
