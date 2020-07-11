@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'category'
])

@section('content')

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
       <a href="{{route('category.create')}}" class="btn btn-primary">Create</a>
        <div class="content">
            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">{{ __('Categories') }}</h3>
                                    </div>

                                </div>
                            </div>



                            <div class="table-responsive card-body">
                                <table class="table " id="table">
                                    <thead class="text-primary">
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
                </div>
            </div>
        </div>
    </div>



@endsection
