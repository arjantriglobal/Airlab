@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Overzicht van alle apparaat statussen</h1>

                <div class="row">
                    @foreach ($devices as $device)
                        <div class="col-sm-3 mt-3 mr-3 rounded @if($device->getStatus()->value == 1) {{"bg-success"}} @elseif($device->getStatus()->value == 2) {{"bg-warning"}} @elseif($device->getStatus()->value == 3) {{"bg-danger"}} @else {{"bg-light"}} @endif">
                            <div class="m-2">

                                <h2 style="width:100%;">{{$device->name}}</h2>
                                @foreach($device->getStatus()->messages as $message)
                                    <p>{{$message}}</p>
                                @endforeach

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
