@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'opportunity'
])

@section('content')

    <div class="content">
        <div class="form-content card">

            <div class="card-header">
                <h5 class="card-title">Create Opportunity</h5>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data"
                      id="create_post_form" method="POST" action="{{route('opportunity.store')}}">
               @csrf

                    <div class="form-group">
                        <label for="account_id">Select Account</label>
                        <select class="form-control" id="account_id" name="account_id">
                            @foreach($accounts as $account)
                                <option value="{{$account->id}}">{{$account->name}}</option>
                            @endforeach

                        </select>
                    </div>

                <div class="form-group">
                    <label for="name">Enter Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                           placeholder="Title" required>
                </div>

                <div class="form-group">
                    <label for="description">Enter Amount</label>
                    <input type="number" class="form-control" name="amount" id="amount">
                </div>
                    <div class="form-group">
                        <label for="stage">Select Stage</label>
                        <select class="form-control" id="stage" name="stage">

                            <option value="discovery">Discovery</option>
                            <option value="proposal shared">Proposal Shared</option>
                            <option value="negotiations">Negotiations</option>

                        </select>
                    </div>
                <button type="submit" class="btn btn-primary">Create</button>
                </form>

            </div>

        </div>
    </div>

@endsection
