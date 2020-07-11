@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'posts'
])

@section('content')

    <div class="content">
        <div class="form-content card">

            <div class="card-header">
                <h5 class="card-title">Create and Share</h5>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data"
                      id="create_post_form" method="POST" action="{{route('post.store')}}">
               @csrf
                    <div class="form-group">
                        <label for="category">Select Category</label>
                        <select class="form-control" id="category" name="category">
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach

                        </select>
                    </div>
                <div class="form-group">
                    <label for="title">Enter Title</label>
                    <input type="text" class="form-control" id="title" name="title"
                           placeholder="Title" required>
                </div>

                <div class="form-group">
                    <label for="description">Enter Description</label>
                    <textarea required class="form-control"
                              id="description" name="description" rows="3"></textarea>
                </div>

                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file" name="file">
                        <label class="custom-file-label" for="file">Choose file</label>
                    </div>
                <button type="submit" class="btn btn-primary">Create</button>
                </form>

            </div>

        </div>
    </div>

@endsection
