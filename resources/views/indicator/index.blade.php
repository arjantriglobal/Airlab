@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Indicatoren koppelen</h1>

                <br /><br />
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Device</th>
                        <th>Bewerk</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($indicators as $indicator)
                        <tr>
                            <td>{{$indicator->name}}</td>
                            <td>{{ array_key_exists($indicator->device_id, $devices) ? $devices[$indicator->device_id] : ""}}</td>
                            <td>
                                <a href="{{url('/indicator/'.$indicator->id.'/edit')}}">
                                    <i style="font-size:20px;" class="fa fa-pencil-alt"></i>
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
