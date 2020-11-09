@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'user'
])

@section('content')
    <div id="app"></div>
    <div class="content">
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
            $('#status').change(function () {
            var status=$('#status').val();
            $('#users_table').DataTable().destroy();

            fetchData(status);

            });
            fetchData();

           function fetchData(status='') {
               $('#users_table').DataTable({
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
