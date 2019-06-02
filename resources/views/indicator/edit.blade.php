@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Bewerk Indicator - {{$indicator->name}}</h1>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                {{$error}}<br>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{action('IndicatorController@update', $indicator->id)}}">
                    @csrf

                    <div class="form-group">
                        <label class="col-form-label">Naam</label>
                        <input class="form-control" type="text" name="name" value="{{$indicator->name}}"/>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Apparaat</label>
                        <select class="form-control m-bot15" name="device">
                            <option value=""></option>
                            @foreach($devices as $device)
                                <option @if($device->id == $indicator->device_id) selected @endif value="{{$device->id}}">{{$device->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-2 offset-9">
                            <button type="submit" class="btn btn-success">Bewerk Indicator</button>
                        </div>
                    </div>
                </form>

            </div>
        @endif
    </div>

@endsection
