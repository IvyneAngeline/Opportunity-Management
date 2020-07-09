@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'posts'
])

@section('content')

    <div class="content">
        <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
       <a href="{{route('post.create')}}" class="btn btn-primary">Create</a>
        <div class="posting">
            @foreach($posts as $post)

                <div class="card">
                    <div class="card-header row col-lg-10" style="padding-left: 30px">
                        <div style="-moz-border-radius: 50px;
                        -webkit-border-radius: 60px;width: 50px;height: 50px;
                         border-radius: 50px;background-color: lightgrey"></div>
                         <span style="width: 20px"></span>
                        <p class="card-title" style="text-align: center">{{$post->user_name}}</p>

                    </div>
                    <div class="card-body" style="padding: 20px">
                        <h6 class="card-title" style="font-weight: bold;color: black" >{{$post->title}}</h6>
                        <p class="card-text">
                            {{\Illuminate\Support\Str::limit($post->description,200,$end=' ...')}}
                            <span><a href="{{route('post.show',$post->post_id)}}">Read More</a></span></p>
                        @if($post->asset !=null)
                            <a  href="images/{{$post->asset}}">Download Attachment</a>
                        @endif

                    </div>
                    <div class="card-footer row col-lg-12" style="padding-left: 20px">
                        <div style="padding: 20px;" class="col-md-3 col-sm-2 col-lg-3" >
                            {{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}
                        </div>
                        <div style="padding: 20px"  class="col-md-3 col-sm-2 col-lg-3">
                            <i class="nc-icon nc-favourite-28"></i>

                            {{$post->likes}}
                        </div>
                        @if($post->asset !=null)
                        <div style="padding: 20px"  class="col-md-3 col-sm-2 col-lg-3">
                            <i class="nc-icon nc-cloud-download-93"></i>

                            {{$post->downloads}}
                        </div>

                        @endif
                        <div style="padding: 20px"  class="col-md-3 col-sm-2 col-lg-3">
                            <i class="nc-icon nc-chat-33"></i>

                            {{$post->comments}}
                        </div>


                    </div>
                </div>

            @endforeach

        </div>
    </div>



@endsection
