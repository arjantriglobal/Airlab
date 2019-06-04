@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Devices beheren</h1>

                <a href="{{ url('device/create')}}" id="user_info">
                    <button class="btn btn-info">Voeg devices toe</button>
                </a>
                <br /><br />
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Bewerk</th>
                        <th>Verwijder</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($devices as $device)
                        <tr>
                            <td>{{$device->name}}</td>
                            <td>
                                <a href="{{url('/device/'.$device->id.'/edit')}}">
                                    <i style="font-size:20px;" class="fa fa-pencil-alt"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{url('/device/'.$device->id.'/delete')}}">
                                    <i style="font-size:20px;" class="fa fa-trash-alt"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection
