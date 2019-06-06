@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Apparaten beheren</h1>

                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Apparaat naam</th>
                        <th>Organisatie</th>
                        <th>Plattegrond</th>
                        <th>Bewerk</th>
                        <th>Actief/Niet actief</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($devices as $device)
                        <tr>
                            <td>{{$device->name}}</td>
                            <td>@if(!empty($device->organization_id)) {{$device->organization->name}} @endif</td>
                            <td>@if(!empty($device->blueprint_id)) {{$device->blueprint->name}} @endif</td>
                            <td>
                                <a href="{{url('/device/'.$device->id.'/edit')}}">
                                    <i style="font-size:20px;" class="fa fa-pencil-alt"></i>
                                </a>
                            </td>
                            <td>
                                {{--<a href="{{url('/device/'.$device->id.'/delete')}}">
                                    <i style="font-size:20px;" class="fa fa-trash-alt"></i>
                                </a>--}}
                                <input class="devicesToggleButton" @if($device->active) {{"checked"}}  @endif type="checkbox" data-id="{{$device->id}}" data-toggle="toggle" data-on="Enabled" data-off="Disabled">
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@section("scripts")
    <script type="text/javascript" src="{{ URL::asset('js/devices.js') }}"></script>
@endsection