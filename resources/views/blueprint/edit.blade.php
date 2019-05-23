@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Bewerk Blueprint - {{$blueprint->name}}</h1>

                <form method="post" action="{{action('BlueprintController@update', $blueprint->id)}}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="col-form-label">Organisatie</label>
                        <select class="form-control m-bot15" name="organization_id">
                            <option value=""></option>
                            @foreach($organizations as $organization)
                                <option @if($organization->id == $blueprint->organization_id) selected @endif value="{{$organization->id}}">{{$organization->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Naam</label>
                        <input class="form-control m-bot15" type="text" name="name" value="{{$blueprint->name}}"/>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Bestand</label>
                        <input type="file" name="uploaded_file" id="uploaded_file" />
                        <br/>
                        <small>Kies een bestand om de huidige plattegrond te overschrijven! Wanneer er geen nieuw bestand wordt geupload, zal er geen plattegrond overschreven worden.</small>
                    </div>

                    <div class="row">
                        <div class="col-2 offset-5">
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                    </div>
                </form>

            </div>
        @endif
    </div>

@endsection
