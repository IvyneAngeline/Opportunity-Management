@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'posts'
])

@section('content')

    <div class="content">
        <div class="form-content card">

            <div class="card-header">
                <h5 class="card-title">Edit Category</h5>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data"
                      id="create_post_form" method="POST" action="{{route('post.update',$post->id)}}">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="category">Select Category</label>
                        <select class="form-control" id="category" name="category">

                            @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                    {{ $post->category == $category->id ?
                                   'selected="selected"' : '' }}>{{$category->name}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Enter Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                               placeholder="Title" required value="{{$post->title}}">
                    </div>

                    <div class="form-group">
                        <label for="description">Enter Description</label>
                        <textarea required class="form-control"
                                  id="description" name="description" rows="3">{{$post->description}}</textarea>
                    </div>


                    <button type="submit" class="btn btn-primary">UPDATE</button>
                </form>

            </div>

        </div>
    </div>

@endsection
