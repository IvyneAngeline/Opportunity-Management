@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'opportunity'
])

@section('content')

    @if(\Illuminate\Support\Facades\Auth::user()->account_type =='user')


    <div class="content">


    <a href="{{route('opportunity.create')}}" class="btn btn-primary">Create Opportunity</a>
    <div class="posting">
        @foreach($opportunities as $opportunity)

            <div class="card">
                <div class="card-header row col-lg-10" style="padding-left: 30px">
                    <div style="-moz-border-radius: 50px;
                    -webkit-border-radius: 60px;width: 50px;height: 50px;
                     border-radius: 50px;background-color: lightgrey"></div>
                     <span style="width: 20px"></span>
                    <p class="card-title" style="text-align: center">{{$opportunity->account_name}}</p>

                </div>
                <div class="card-body" style="padding: 20px">
                    <h6 class="card-title" style="font-weight: bold;color: black" >{{$opportunity->name}}</h6>
                    <p class="card-text">Amount  :
                        {{\Illuminate\Support\Str::limit($opportunity->amount,200,$end=' ...')}}
                        <span></span></p>


                </div>
                <div class="card-footer row col-lg-12" style="padding-left: 20px">
                    <div style="padding: 20px;" class="col-md-3 col-sm-2 col-lg-3" >
                        {{\Carbon\Carbon::parse($opportunity->created_at)->diffForHumans()}}
                    </div>

                    <div style="padding: 20px"  class="col-md-3 col-sm-2 col-lg-3">
                        <i class="">Location : </i>

                        {{$opportunity->address}}
                    </div>




                </div>
            </div>

        @endforeach

    </div>
</div>
@else
    <div class="content">
        <a href="{{route('opportunity.create')}}" class="btn btn-primary">Create</a>


        <div class="card" id="resource_table">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="mb-0">{{ __('Resources shared') }}</h5>
                    </div>

                </div>
            </div>

            <div class="table-responsive card-body">
                <table class="table " id="table">
                    <thead class="text-dark">
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('stage') }}</th>
                    <th scope="col">
                        Category
                    </th>
                    <th scope="col">{{'address'}}</th>
                    <th scope="col">{{__('Amount')}}</th>
                    <th scope="col">{{__('Created')}}</th>




                    </thead>
                    <tbody style="padding: 20px">
                    @foreach ($opportunities as $post)
                        <tr>
                            <td>{{ $post->name }}</td>
                            <td>
                                {{ $post->stage }}
                            </td>
                            <td>{{ $post->address}}</td>
                            <td>{{ $post->amount}}</td>



                            <td>{{ $post->created_at}}</td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
                type: 'doughnut',
                data: {
                    labels:Years,

                    datasets: [{
                        label: 'Performance',
                        data: Prices,
                        borderWidth: 1,
                        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                    }],

                },

            });
        });
    });
</script>
@endpush
