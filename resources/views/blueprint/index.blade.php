@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Plattegronden beheren</h1>

                <a href="{{ url('blueprint/create')}}" id="user_info">
                    <button class="btn btn-info">Voeg plattegrond toe</button>
                </a>
                <br /><br />
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Organisatie</th>
                        <th>Bewerk</th>
                        @if($user->role == 2)
                            <th>Verwijder</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($blueprints as $bp)
                        <tr>
                            <td>{{$bp->name}}</td>
                            <td>{{$bp->organization->name}}</td>
                            <td>
                                <a href="{{url('/blueprint/'.$bp->id.'/edit')}}">
                                    <i style="font-size:20px;" class="fa fa-pencil-alt"></i>
                                </a>
                            </td>
                            @if($user->role == 2)
                                <td>
                                    <a href="{{url('/blueprint/'.$bp->id.'/delete')}}">
                                        <i style="font-size:20px;" class="fa fa-trash-alt"></i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection
