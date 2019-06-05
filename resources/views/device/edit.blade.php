@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Bewerk device - {{$device->name}}</h1>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                {{$error}}<br>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{action('DeviceController@update', $device->id)}}">
                    @csrf

                    <div class="form-group">
                        <label class="col-form-label">Naam</label>
                        <input class="form-control" type="text" name="name" value="{{$device->name}}"/>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">MAC Adres</label>
                        <input class="form-control" type="text" name="mac_address" value="{{$device->mac_address}}" disabled/>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Serienummer</label>
                        <input class="form-control" type="text" name="serial_number" value="{{$device->serial_number}}" disabled/>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Organisatie</label>
                        <select class="form-control m-bot15" name="organization">
                            <option value=""></option>
                            @foreach($organizations as $organization)
                                <option @if($organization->id == $device->organization_id) selected @endif value="{{$organization->id}}">{{$organization->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Plattegrond</label>
                        <select class="form-control m-bot15" name="blueprint">
                            <option value=""></option>
                            @foreach($blueprints as $blueprint)
                                <option @if($blueprint->id == $device->blueprint_id) selected @endif value="{{$blueprint->id}}">{{$blueprint->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-2 offset-9">
                            <button type="submit" class="btn btn-success">Bewerk device</button>
                        </div>
                    </div>
                </form>

            </div>
        @endif
    </div>

@endsection
