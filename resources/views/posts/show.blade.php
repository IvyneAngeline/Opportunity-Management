@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'posts'
])

@section('content')
<div class="content">

    <div class="card" style="padding: 20px">
        <div class="card-header row">
            <div style="-moz-border-radius: 50px;
                        -webkit-border-radius: 60px;width: 50px;height: 50px;
                         border-radius: 50px;background-color: lightgrey"></div>
            <span style="width: 20px"></span>
            <p class="card-title" style="text-align: center">{{$post->user_name}}</p>
            <span style="width: 10px"></span>

            <p class="card-title"
               style="text-align: center;color: orange;font-size: 12px"> {{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</p>

        </div>
        <div class="card-body">
            <div class="">
                <h6 style="font-weight: bold" class="card-text">{{$post->title}}</h6>
                <p>{{$post->description}}</p>
            </div>
        </div>
        <div class="card-footer">
            Comments

            <div style="margin: 10px">
                @foreach($comments as $comment)

                    <div class="row">

                        <div style="-moz-border-radius: 50px;
                        -webkit-border-radius: 60px;width: 50px;height: 50px;
                         border-radius: 50px;background-color: lightgrey"></div>
                        <span style="width: 20px"></span>
                        <div class="col">
                        <p class="card-title"
                           style="">{{$comment->comment_name}}</p>
                        <p>{{$comment->actual_comment}}</p>
                            <hr style="opacity: 0.6">

                        </div>

                        <span style="width: 10px"></span>
                        <div class="col">
                            <p class="card-title"
                               style="
                           color: orange;font-size: 12px">
                                {{\Carbon\Carbon::parse($comment->commented_at)->diffForHumans()}}</p>


                        </div>




                    </div>


                @endforeach
            </div>
            <form action="{{route('comment')}}" method="post">
                @csrf
                <input type="hidden" name="post_id" id="post_id" value="{{$post->post_id}}">
                <div class="form-group">
                    <label for="comment">Example textarea</label>
                    <textarea required class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-sm btn-primary" >Comment</button>
                </div>
            </form>
        </div>
    </div>


</div>
@endsection
