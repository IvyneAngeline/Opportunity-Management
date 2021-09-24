@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'opportunity'
])

@section('content')
<div class="content">

    @if(\Illuminate\Support\Facades\Auth::user()->account_type=='admin')
        <div class="row">
            <div class="col-md-8">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Comments</h5>
                        <p class="card-category">Comments  Performance per month</p>
                    </div>
                    <div class="card-body ">
                        <canvas id="comments"></canvas>
                    </div>
                    <div class="card-footer ">

                        <hr>
                        <div class="stats">
                            <i class="fa fa-calendar"></i> Number of comments per month
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

    <div class="card" style="padding: 20px">
        <div class="card-header row">
            <div style="-moz-border-radius: 50px;
                        -webkit-border-radius: 60px;width: 50px;height: 50px;
                         border-radius: 50px;background-color: orange"></div>
            <span style="width: 20px"></span>
            <p class="card-title" style="text-align: center;font-weight: bold">{{$post->user_name}}</p>
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
                           style=" font-weight: bold">{{$comment->comment_name}}</p>
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
@push('scripts')
    <script>
        $(document).ready(function () {
            comments()
            function comments() {
                var post_id = {!! $post->post_id !!};
                var base_url='post_comments_stats/'+post_id;

                var url = "http://127.0.0.1:8000/post_comments_stats/"+post_id;
                var months = new Array();
                var total= new Array();
                $.get(url, function(response){
                    response.forEach(function(data){
                        months.push(data.months);
                        total.push(data.sums);
                    });
                    var ctx = document.getElementById("comments").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {

                            labels:months,

                            datasets: [{
                                label: 'comments',
                                data: total,
                                borderWidth: 2,
                                borderColor: "#3e95cd",
                                fill: false
                            }],


                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }


                    });
                });

            }
        })
    </script>
@endpush
