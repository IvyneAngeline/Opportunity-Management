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
                        <canvas id="canvas"></canvas>
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
                        <canvas id="canvas"></canvas>
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
                        <canvas id="canvas"></canvas>
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

