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
                            <table class="table " id="table">
                                <thead class="text-dark">
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Email') }}</th>
                                        <th scope="col">{{ __('Creation Date') }}</th>
                                        <th scope="col">{{'Status'}}</th>
                                        <th scope="col">{{__('Actions')}}</th>


                                </thead>
                                <tbody style="padding: 20px">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>
                                                <a class="text-dark" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                            </td>
                                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                            @if($user->status=='active')
                                                <td style="color: green;font-weight: bold">{{ $user->status}}</td>
                                            @else
                                                <td style="color: red;font-weight: bold">{{ $user->status}}</td>
                                            @endif
                                            <td class="text-right">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="nc-align-left-2 nc-icon"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                                                        @if ($user->id != auth()->id())

                                                            @if($user->status=='active')
                                                                <form action="{{ route('make_admin', [$user->id])}}" method="post">
                                                                    @csrf
                                                                    <button type="button"
                                                                            class="dropdown-item"
                                                                            onclick=
                                                                            "confirm
                                                                                ('{{ __("Are you sure you want to make user admin?") }}') ? this.parentElement.submit() : ''">
                                                                        {{ __('Make Admin') }}
                                                                    </button>
                                                                </form>
                                                            <form action="{{ route('suspend', [$user->id]) }}" method="post">
                                                                @csrf
                                                                <button type="button" class="dropdown-item"
                                                                        onclick=
                                                                        "confirm('{{ __("Are you sure you want to suspend this user?") }}')
                                                                            ? this.parentElement.submit() : ''">
                                                                    {{ __('Suspend') }}
                                                                </button>
                                                            </form>
                                                            @else
                                                                <form action="{{ route('activate', [$user->id]) }}" method="post">
                                                                    @csrf
                                                                    <button type="button" class="dropdown-item"
                                                                            onclick=
                                                                            "confirm('{{ __("Are you sure you want to activate this user?") }}')
                                                                                ? this.parentElement.submit() : ''">
                                                                        {{ __('Activate') }}
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <form action="{{ route('user.destroy', $user) }}" method="post">
                                                                @csrf
                                                                @method('delete')

                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                                                    {{ __('Delete') }}
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Edit') }}</a>

                                                        @endif
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
@endsection
