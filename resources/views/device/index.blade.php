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
                        <th>Actief/Niet actief</th>
                        <th>Bewerk</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($devices as $device)
                        <tr>
                            <td>{{$device->name}}</td>
                            <td>@if(!empty($device->organization_id)) {{$device->organization->name}} @endif</td>
                            <td>@if(!empty($device->blueprint_id)) {{$device->blueprint->name}} @endif</td>
                            <td>

                                <div class="toggle-switch">
                                    <input @if($device->active) {{"checked"}} @endif id="toggle-{{$device->id}}" class="toggle-value devicesToggleButton" type="checkbox" data-id="{{$device->id}}">
                                    <label for="toggle-{{$device->id}}"></label>
                                </div>
                            </td>



                            <td>
                                <a href="{{url('/device/'.$device->id.'/edit')}}">
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

@section("scripts")
    <script>
        $(".devicesToggleButton").click(function() {
            var deviceId = $(this).data("id");

            //set bool to see if radiobutton is checked or not.
            if($(this).is(':checked'))
            {
                var checked = 1;
            }
            else
            {
                var checked = 0;
            }

            $.ajax({
                url: "{{url("/ajax/device/setActiveOrInactive")}}",
                method: 'get',
                data: { id : deviceId, setactive: checked },
                success: function( $result) {

                }
            });
        });
    </script>
@endsection