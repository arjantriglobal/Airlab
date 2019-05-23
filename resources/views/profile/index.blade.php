@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profielen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="upload" aria-selected="false">Administrator</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h1>Alle profielen</h1>

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Gebruiker</th>
                                    <th>Email</th>
                                    <th>Organisatie</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$organizations[$user->organization_id]}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                        <h1>Admin</h1>

                        <a href="#" id="register_user">
                            <button class="btn btn-info">Registreer</button>
                        </a>
                        <a href="#" id="upload_blueprint">
                            <button class="btn btn-info">Plattegrond uploaden</button>
                        </a>
                        <a href="#" id="user_info">
                            <button class="btn btn-info">Gebruikersinformatie</button>
                        </a>

                        <div id="register_user_div">
                            <form method="post" action="{{url('/profile/adduser')}}">
                                @csrf

                                <div class="form-group">
                                    <label class="col-form-label">Organisatie</label>
                                    <select class="form-control m-bot15" name="organization_id">
                                        <option value=""></option>
                                        @foreach($organizations as $id => $name)
                                            <option value="{{$id}}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Rol</label>

                                    <select class="form-control m-bot15" name="role_id">
                                        <option value="1">Gebruiker</option>
                                        <option value="2">Administrator</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Naam</label>
                                    <input class="form-control m-bot15" type="text" name="name"/>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Wachtwoord</label>
                                    <input class="form-control m-bot15" type="password" name="password"/>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Email</label>
                                    <input class="form-control m-bot15" type="email" name="email"/>
                                </div>

                                <div class="row">
                                    <div class="col-2 offset-9">
                                        <button type="submit" class="btn btn-success">Registreer</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div id="upload_blueprint_div" style="display:none;">
                            <form method="post" action="{{url('/profile/uploadblueprint')}}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label class="col-form-label">Organisatie</label>
                                    <select class="form-control m-bot15" name="organization_id">
                                        <option value=""></option>
                                        @foreach($organizations as $id => $name)
                                            <option value="{{$id}}">{{$name}}</option>
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
                                        <button type="submit" class="btn btn-success">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div id="user_info_div" style="display:none;">
                            <form method="post" action="{{url('/profile/change')}}">
                                @csrf
                                <div class="form-group">
                                    <label class="col-form-label">Gebruikers</label>

                                    <select class="form-control m-bot15" name="user_id">
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Organisatie</label>
                                    <select class="form-control m-bot15" name="organization_id">
                                        <option value=""></option>
                                        @foreach($organizations as $id => $name)
                                            <option value="{{$id}}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Rol</label>

                                    <select class="form-control m-bot15" name="role_id">
                                        <option value=""></option>
                                        <option value="1">Gebruiker</option>
                                        <option value="2">Administrator</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Naam</label>
                                    <input class="form-control m-bot15" type="text" name="name"/>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Wachtwoord</label>
                                    <input class="form-control m-bot15" type="password" name="password"/>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Email</label>
                                    <input class="form-control m-bot15" type="email" name="email"/>
                                </div>

                                <div class="row">
                                    <div class="col-2 offset-9">
                                        <button type="submit" class="btn btn-success">Verander</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container-fluid" id="container" style="min-width:800px;">
                <h1>Profiel</h1>
                <div>
                    <div class="form-group" data-bind="foreach: $root.currentTabData">
                        <label for="name">Naam</label>
                        <input type="name" class="form-control" id="name" data-bind="value : $data.name">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" data-bind="value : $data.email">
                        <label for="Organization">Organisatie</label>
                        <input type="Organization" class="form-control" id="Organization" data-bind="value : $data.organization" disabled="">
                        <label for="password">Wachtwoord</label>
                        <input type="password" class="form-control" id="password" aria-describedby="passwordDis" placeholder="Enter password" data-bind="value :$root.new_password">
                        <small id="passwordDis" class="form-text text-muted">Vul je wachtwoord in als je je wachtwoord wilt veranderen.</small>
                        <button type="button" class="btn btn-lg btn-success float-right" data-bind="click: $root.editProfile.bind($data)">
                            Opslaan
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection

@section("scripts")
    <script type="text/javascript" src="{{ URL::asset('js/profile.js') }}"></script>
@endsection
