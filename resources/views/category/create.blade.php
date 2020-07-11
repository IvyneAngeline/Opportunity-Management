@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'category'
])

@section('content')

    <div class="content">
        <div class="form-content card">

            <div class="card-header">
                <h5 class="card-title">Create new Category</h5>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data"
                      id="create_post_form" method="POST" action="{{route('category.store')}}">
               @csrf

                <div class="form-group">
                    <label for="title">Enter category</label>
                    <input type="text" class="form-control" id="category" name="category"
                           placeholder="Category Name" required>
                </div>


                <button type="submit" class="btn btn-primary">Create</button>
                </form>

            </div>

        </div>
    </div>

@endsection
