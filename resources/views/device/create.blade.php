@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Voeg device toe</h1>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                {{$error}}<br>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{action('DeviceController@store')}}">
                    @csrf

                    <div class="form-group">
                        <label class="col-form-label">Naam</label>
                        <input class="form-control m-bot15" type="text" name="name"/>
                    </div>

                    <div class="row">
                        <div class="col-2 offset-9">
                            <button type="submit" class="btn btn-success">Voeg toe</button>
                        </div>
                    </div>
                </form>

            </div>
        @endif
    </div>

@endsection
