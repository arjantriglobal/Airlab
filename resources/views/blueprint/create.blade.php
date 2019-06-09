@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Voeg plattegrond toe</h1>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                {{$error}}<br>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{action('BlueprintController@store')}}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="col-form-label">Organisatie</label>
                        <select class="form-control m-bot15" name="organization">
                            <option value=""></option>
                            @foreach($organizations as $organization)
                                <option value="{{$organization->id}}">{{$organization->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Naam</label>
                        <input class="form-control m-bot15" type="text" name="name"/>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Bestand</label>
                        <input type="file" name="uploaded_file" id="uploaded_file" />
                    </div>

                    <div class="row">
                        <div class="col-2 offset-5">
                            <button type="submit" class="btn btn-success">Voeg toe</button>
                        </div>
                    </div>
                </form>

            </div>
        @endif
    </div>

@endsection
