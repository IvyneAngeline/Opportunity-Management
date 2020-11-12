@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'user'
])

@section('content')
    <div id="app"></div>
    <div class="content">
        <div class="row container">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Users Gained Per Month</h5>
                        <p class="card-category">Users Gained per month</p>
                    </div>
                    <div class="card-body ">
                        <canvas id="users_chart"></canvas>
                    </div>
                    <div class="card-footer ">

                        <hr>
                        <div class="stats">
                            <i class="fa fa-calendar"></i> Users Gained per month
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Users Status</h5>
                        <p class="card-category">Users Status</p>
                    </div>
                    <div class="card-body ">
                        <canvas id="users_status_chart"></canvas>
                    </div>
                    <div class="card-footer ">

                        <hr>
                        <div class="stats">
                            <i class="fa fa-calendar"></i>Users Status
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('users') }}</h3>
                                </div>

                            </div>
                        </div>

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

                        <div class="table-responsive card-body">
                            <table class="table " id="users_table">
                                <thead class="text-dark">
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Email') }}</th>
                                        <th scope="col">{{ __('Creation Date') }}</th>
                                        <th scope="col">
                                            <select id="status" name="status" class="form-control">
                                                <option value="">Status</option>
                                                @foreach($statuses as $status)
                                                    <option value="{{$status->status}}">{{$status->status}}</option>
                                                @endforeach
                                            </select>
                                        </th>
                                        <th scope="col">{{__('Actions')}}</th>
                                        <th scope="col">{{__('Admin')}}</th>



                                </thead>
                                <tbody style="padding: 20px">

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            views_chart();
            user_status();
            var user = {!! auth()->user()->toJson() !!};
            var utc = new Date().toJSON().slice(0,10).replace(/-/g,'/');

            function views_chart() {

                var url = "{{url('user_stats')}}";
                var months = new Array();
                var total= new Array();
                $.get(url, function(response){
                    response.forEach(function(data){
                        months.push(data.months);
                        total.push(data.sums);
                    });
                    var ctx = document.getElementById("users_chart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {

                            labels:months,

                            datasets: [{
                                label: 'Users',
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


            function user_status() {

                var url = "{{url('user_status_stats')}}";
                var months = new Array();
                var total= new Array();
                $.get(url, function(response){
                    response.forEach(function(data){
                        months.push(data.months);
                        total.push(data.sums);
                    });
                    var ctx = document.getElementById("users_status_chart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {

                            labels:months,

                            datasets: [{
                                label: 'Users',
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

            $('#status').change(function () {
            var status=$('#status').val();
            $('#users_table').DataTable().destroy();

            fetchData(status);

            });
            fetchData();
           function fetchData(status='') {
               $('#users_table').DataTable({
                   dom: 'Bfrtip',
                   buttons: [

                       {
                           extend: 'csv',
                           messageTop: 'Users Reports . Generated By '+user.name + " on "+utc,
                           exportOptions: {
                               columns: [ 0, 1, 2, 3]
                           }
                       },  {
                           extend: 'print',
                           messageTop: 'Users Reports . Generated By '+user.name + " on "+utc,
                           exportOptions: {
                               columns: [ 0, 1, 2, 3]
                           }
                       },
                       {
                           extend: 'pdfHtml5',
                           messageTop: 'Users Reports . Generated By '+user.name + " on "+utc,
                           exportOptions: {
                               columns: [ 0, 1, 2, 3]
                           }
                       }


                   ],
                   processing:true,
                   serverSide:true,
                   searchable:true,
                   ajax:{
                       url:"{{route('user.index')}}",
                       data:{status:status}
                   },
                   columns:[
                       {
                           name:'name',
                           data:'name',
                       },
                       {
                           name:'email',
                           data:'email'
                       },
                       {
                           name:'created_at',
                           data:'created_at'
                       },
                       {
                           name:'status',
                           data:'status',
                           orderable:false,
                           render:function (data){
                               if (data==='active'){
                                   return "<p class='text-success' style='font-weight: bolder'>active</p>"
                               }
                               else{
                                   return "<p class='text-danger' style='font-weight: bolder'>inactive</p>"

                               }
                           }
                       },
                       {

                           render:function (data,type,row,meta) {
                               if (row.status=='active'){
                                   return "<a class='btn btn-danger' href='/suspend/"+ row.id +"'>Suspend</a>"
                               }
                               else{
                                   return "<a class='btn btn-success' href='/activate/"+ row.id +"'>Activate</a>"

                               }


                           }
                       },
                       {

                           render:function (data,type,row,meta) {
                               if (row.account_type=='admin'){
                                   return "<a class='btn btn-danger' href='/suspend_Admin/"+ row.id +"'>Revoke Admin</a>"
                               }
                               else{
                                   return "<a class='btn btn-success' href='/make_admin/"+ row.id +"'>Make Admin</a>"

                               }


                           }
                       }
                   ]
               })
           }


        })
    </script>
@endpush
