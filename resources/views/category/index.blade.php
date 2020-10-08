@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'category'
])

@section('content')

    <div class="content">
        @if(\Illuminate\Support\Facades\Auth::user()->account_type=='admin')

       <a href="{{route('category.create')}}" class="btn btn-primary">Create</a>
        <div class="row">
            <div class="col-md-5">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Category Performance</h5>
                        <p class="card-category">Category  Performance</p>
                    </div>
                    <div class="card-body ">
                        <canvas id="canvas"></canvas>
                    </div>
                    <div class="card-footer ">

                        <hr>
                        <div class="stats">
                            <i class="fa fa-circle-thin"></i>
                            Graph data of category performance
                        </div>
                    </div>
                </div>
            </div>
            <div class="card col-lg-7">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Categories') }}</h3>
                        </div>

                    </div>
                </div>



                <div class="table-responsive card-body">
                    <table class="table " id="table">
                        <thead class="text-dark">
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Created At') }}</th>

                        <th scope="col">{{__('Actions')}}</th>


                        </thead>
                        <tbody style="padding: 20px">
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>

                                <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>

                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="nc-align-left-2 nc-icon"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item"
                                               href="{{ route('category.show',$category->id) }}"
                                            >{{ __('Analysis') }}</a>
                                            <a class="dropdown-item"
                                               href="{{ route('category.edit',$category->id) }}"
                                            >{{ __('Edit Category') }}</a>


                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        @else


            <div class="row">

                @foreach($categories as $category)
                    <div class="col-md-4 col-lg-4">
                        <a href="{{route('category.show',$category->id)}}">
                    <div class="card card-stats">
                        <div class="card-body">
                            <h6>{{$category->name}}</h6>
                        </div>
                        <div class="card-footer">
                            <hr>
                            <div class="stats">
                                <p> Resources available</p>
                            </div>
                        </div>
                    </div></a>
                    </div>
                @endforeach

            </div>

        @endif

    </div>



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
                            borderWidth: 1,
                            backgroundColor:
                                ["#FF8C00",
                                    "#8e5ea2",
                                    "#3cba9f",
                                    "#e8c3b9",
                                    "#c45850"],
                        }],

                    },

                });
            });
        });
    </script>
@endpush
