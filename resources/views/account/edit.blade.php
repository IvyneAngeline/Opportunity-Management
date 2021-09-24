@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'account'
])

@section('content')


    <div class="content">

        <div class="card">
            <div class="card-header">
                <h6>Edit Category</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('account.update',$category->id)}}">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="title">Enter category</label>
                        <input type="text" class="form-control" id="category" name="category"
                               placeholder="Category Name" required value="{{$category->name}}">
                    </div>


                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>

    </div>
@endsection
