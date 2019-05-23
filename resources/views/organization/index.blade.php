@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Organisaties beheren</h1>

                <a href="{{ url('organization/create')}}" id="user_info">
                    <button class="btn btn-info">Voeg organisatie toe</button>
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
                    @foreach($organizations as $organization)
                        <tr>
                            <td>{{$organization->name}}</td>
                            <td>
                                <a href="{{url('/organization/'.$organization->id.'/edit')}}">
                                    <i style="font-size:20px;" class="fa fa-pencil-alt"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{url('/organization/'.$organization->id.'/delete')}}">
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
