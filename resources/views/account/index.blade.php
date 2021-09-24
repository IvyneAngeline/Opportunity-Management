@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'account'
])

@section('content')

    <div class="content">
        @if(\Illuminate\Support\Facades\Auth::user()->account_type=='admin')

       <a href="{{route('account.create')}}" class="btn btn-primary">Create Account</a>
        <div class="row">

            <div class="card col-lg-12">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Accounts') }}</h3>
                        </div>

                    </div>
                </div>



                <div class="table-responsive card-body">
                    <table class="table " id="table">
                        <thead class="text-dark">
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Address') }}</th>
                        <th scope="col">{{ __('Created At') }}</th>


                        </thead>
                        <tbody style="padding: 20px">
                        @foreach ($accounts as $account)
                            <tr>
                                <td>{{ $account->name }}</td>

                                <td>{{ $account->address }}</td>

                                <td>{{ $account->created_at->format('d/m/Y H:i') }}</td>


                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        @else

            <a href="{{route('account.create')}}" class="btn btn-success">Create Account</a>
             <div class="row">

                @foreach($accounts as $account)
                    <div class="col-md-4 col-lg-4">
                        <a href="{{route('account.show',$account->id)}}">
                    <div class="card card-stats">
                        <div class="card-header text-dark">
                            <h6>{{$account->name}}</h6>
                        </div>
                        <div class="card-body text-dark">
                          <h7 >Address  : {{$account->address}}</h7>
                        </div>
                        <div class="card-footer">
                            <hr>
                            <div class="">
                                <a class="btn btn-success btn-sm "
                                   href="{{route('account.show',$account->id)}}" style="color: whitesmoke">View Opportunities</a>
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
