@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'posts'
])

@section('content')

    <div class="content">

        <div class="row">
            <div class="col-md-6">
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
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Posts Per Month</h5>
                        <p class="card-category">Posts  Performance per month</p>
                    </div>
                    <div class="card-body ">
                        <canvas id="post_chart"></canvas>
                    </div>
                    <div class="card-footer ">

                        <hr>
                        <div class="stats">
                            <i class="fa fa-calendar"></i> Number of Posts per month
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Views Per Month</h5>
                        <p class="card-category">Views  Performance per month</p>
                    </div>
                    <div class="card-body ">
                        <canvas id="views_chart"></canvas>
                    </div>
                    <div class="card-footer ">

                        <hr>
                        <div class="stats">
                            <i class="fa fa-calendar"></i> Number of Views per month
                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>

@endsection
@push('scripts')
    <script>

        $(document).ready(function(){
            comments();
            posts();
            views_chart();
            function comments() {

                var url = "{{url('comments_stats')}}";
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

                    });
                });

            }

            function posts() {

                var url = "{{url('posts_stats')}}";
                var months = new Array();
                var total= new Array();
                $.get(url, function(response){
                    response.forEach(function(data){
                        months.push(data.months);
                        total.push(data.sums);
                    });
                    var ctx = document.getElementById("post_chart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {

                            labels:months,

                            datasets: [{
                                label: 'Posts',
                                data: total,
                                borderWidth: 2,
                                borderColor: "#3e95cd",
                                fill: false
                            }],


                        },

                    });
                });

            }
            function views_chart() {

                var url = "{{url('views_stats')}}";
                var months = new Array();
                var total= new Array();
                $.get(url, function(response){
                    response.forEach(function(data){
                        months.push(data.months);
                        total.push(data.sums);
                    });
                    var ctx = document.getElementById("views_chart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {

                            labels:months,

                            datasets: [{
                                label: 'Views',
                                data: total,
                                borderWidth: 2,
                                borderColor: "#3e95cd",
                                fill: false
                            }],


                        },

                    });
                });

            }

        });
    </script>
@endpush


