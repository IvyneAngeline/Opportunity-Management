@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'account'
])

@section('content')

    <div class="content">
        <div class="form-content card">

            <div class="card-header">
                <h5 class="card-title">Create new Account</h5>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data"
                      id="account_form" method="POST" action="{{route('account.store')}}">
               @csrf

                <div class="form-group">
                    <label for="name">Enter category</label>
                    <input type="text" class="form-control" id="name" name="name"
                           placeholder="Account Name" required>
                </div>
                    <div class="form-group">
                        <label for="address">Enter category</label>
                        <input type="text" class="form-control" id="address" name="address"
                               placeholder="Address" required>
                    </div>


                <button type="submit" class="btn btn-primary">Create</button>
                </form>

            </div>

        </div>
    </div>

@endsection
