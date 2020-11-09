@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'posts'
])

@section('content')

    @if(\Illuminate\Support\Facades\Auth::user()->account_type =='user')


        <div class="content">


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
            <div class="card">
                <div class="card-body">
                    <div class="" style="margin-top: 10px;margin-left: 20px">

                        <form id="date_filter"  name="date_filter">
                            <div class="row">
                                <div class="col">
                                    <label>Start Date</label>
                                    <input required type="date" id="start" class="form-control" placeholder="Start Date">
                                </div>
                                <div class="col">
                                    <label>End Date</label>
                                    <input required type="date" id="end" class="form-control" placeholder="End Date">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-success">Filter</button>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <div class="card" id="resource_table">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="mb-0">{{ __('Resources shared') }}</h5>
                        </div>

                    </div>
                </div>

                <div class="table-responsive card-body">
                    <table class="table " id="posts_table">
                        <thead class="text-dark">
                        <th scope="col">{{ __('Title') }}</th>
                        <th scope="col">
                            <select name="category_filter" id="category_filter" class="form-control">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col">{{'Views'}}</th>
                        <th scope="col">{{__('Comments')}}</th>
                        <th scope="col">{{__('Time')}}</th>




                        </thead>
                        <tbody style="padding: 20px">

                        </tbody>
                    </table>
                </div>



            </div>



        </div>

    @endif



@endsection
@push('scripts')

    <script>
        $(document).ready(function (){
            dateFilter();

           $('#category_filter').change(function (){
               var category_id=$('#category_filter').val();
               $('#posts_table').DataTable().destroy();
               fetch_data(category_id);

           });

           $('#date_filter').submit(function (event) {
               event.preventDefault();
               var start=$('#start').val();
               var end =$('#end').val();

               $('#posts_table').DataTable().destroy();
               dateFilter(start,end);

           });


           function dateFilter(start='',end='') {
               $('#posts_table').DataTable({
                   dom: 'Bfrtip',
                   buttons: [
                       'copy', 'csv', 'pdf', 'print'
                   ],
                   processing:true,
                   serverSide:true,
                   ajax:{
                       url:"{{route('post_report')}}",
                       data:{start:start,end:end}
                   },
                   columns:[
                       {
                           data:'title',
                           name:'title'
                       },
                       {
                           data:'category',
                           name:'category',
                           orderable:false
                       },
                       {
                           data:'views',
                           name:'views'
                       },
                       {
                           data:'comments',
                           name:'comments'
                       },
                       {
                           data:'time',
                           name:'time',
                       }
                   ]
               });

           }
        function  fetch_data(category =''){
            $('#posts_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'pdf', 'print'
                ],
                processing:true,
                serverSide:true,
                ajax:{
                    url:"{{route('post_report')}}",
                    data:{category:category}
                },
                columns:[
                    {
                        data:'title',
                        name:'title'
                    },
                    {
                        data:'category',
                        name:'category',
                        orderable:false
                    },
                    {
                        data:'views',
                        name:'views'
                    },
                    {
                        data:'comments',
                        name:'comments'
                    },
                    {
                        data:'time',
                        name:'time',
                    }
                ]
            });
        }
        });
    </script>
@endpush
