@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Manage Organizations</h1>

                <a href="{{ url('organization/create')}}" id="user_info">
                    <button class="btn btn-info">Add organization</button>
                </a>
                <br /><br />
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($organizations as $organization)
                        <tr>
                            <td>{{$organization->id}}</td>
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
