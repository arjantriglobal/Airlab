@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Edit Organization - {{$organization->name}}</h1>

                <form method="post" action="{{action('OrganizationController@update', $organization->id)}}">
                    @csrf

                    <div class="form-group">
                        <label class="col-form-label">Name</label>
                        <input class="form-control m-bot15" type="text" name="name" value="{{$organization->name}}"/>
                    </div>

                    <div class="row">
                        <div class="col-2 offset-9">
                            <button type="submit" class="btn btn-success">Change Organization</button>
                        </div>
                    </div>
                </form>

            </div>
        @endif
    </div>

@endsection
