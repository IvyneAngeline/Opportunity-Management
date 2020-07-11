@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'posts'
])

@section('content')

    @if(\Illuminate\Support\Facades\Auth::user()->account_type=='user')

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
    @else
        <div class="content">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">

                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">
                                            {{$post_count}}
                                        </p>
                                        <p class="card-title">.
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class=""></i>  {{$post_count}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-single-02 text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">Total Users</p>
                                        <p class="card-title">{{$users}}
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class=""></i>Total Users
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-paper text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">Total Posts</p>
                                        <p class="card-title">{{count($posts)}}
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class=""></i>Total Posts
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-tap-01 text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">Views</p>
                                        <p class="card-title">{{$views}}
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class=""></i> Total Posts Viewings
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-7">
                    <div class="card ">
                        <div class="card-header ">
                            <h5 class="card-title">Posts</h5>
                            <p class="card-category">Category  Performance</p>
                        </div>
                        <div class="card-body ">
                            <canvas id="canvas"></canvas>
                        </div>
                        <div class="card-footer ">

                            <hr>
                            <div class="stats">
                                <i class="fa fa-calendar"></i> Number of emails sent
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    @endif



@endsection
@push('scripts')
    <script>
        var url = "{{url('category_chart')}}";
        var Years = new Array();
        var Labels = new Array();
        var Prices = new Array();
        $(document).ready(function(){
            $.get(url, function(response){
                response.forEach(function(data){
                    Years.push(data.name);
                    Labels.push(data.total);
                    Prices.push(data.total);
                });
                var ctx = document.getElementById("canvas").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels:Years,

                        datasets: [{
                            label: 'Performance',
                            data: Prices,
                            borderWidth: 1
                        }],

                        backgroundColor: [
                            "#DEB887",
                            "#A9A9A9",
                            "#DC143C",
                            "#F4A460",

                        ],
                    },

                });
            });
        });
    </script>
@endpush
