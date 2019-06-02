@extends('layouts.app')
@section('content')
    <div class="bg-white p-2">
        @if($user->role == 2)
            <div class="container-fluid" id="container" style="min-width:800px;">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profiles-tab" data-toggle="tab" href="#profiles" role="tab" aria-controls="profile" aria-selected="true">Profielen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="admin-tab" data-toggle="tab" href="#administrator" role="tab" aria-controls="administrator" aria-selected="false">Administrator</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profiles" role="tabpanel" aria-labelledby="profiles-tab">
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
                    <div class="tab-pane fade" id="administrator" role="tabpanel" aria-labelledby="admin-tab">
                        <h1>Admin</h1>

                        <a href="#" id="register_user">
                            <button class="btn btn-info">Registreer</button>
                        </a>
                        <a href="#" id="user_info">
                            <button class="btn btn-info">Gebruikersinformatie wijzigen</button>
                        </a>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        {{$error}}<br>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div id="register_user_div">
                            <form method="post" action="{{url('/profile/adduser')}}">
                                @csrf

                                <div class="form-group">
                                    <label class="col-form-label">Organisatie</label>
                                    <select class="form-control" name="organization">
                                        <option value=""></option>
                                        @foreach($organizations as $id => $name)
                                            <option value="{{$id}}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Rol</label>

                                    <select class="form-control" name="role">
                                        <option value="1">Gebruiker</option>
                                        <option value="2">Administrator</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Naam</label>
                                    <input class="form-control" type="text" name="name"/>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Wachtwoord</label>
                                    <input class="form-control" type="password" name="password"/>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Email</label>
                                    <input class="form-control" type="email" name="email"/>
                                </div>

                                <div class="row">
                                    <div class="col-2 offset-9">
                                        <button type="submit" class="btn btn-success">Registreer</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div id="user_info_div" style="display:none;">
                            <form method="post" action="{{url('/profile/change')}}">
                                @csrf
                                <div class="form-group">
                                    <label class="col-form-label">Gebruikers</label>

                                    <select class="form-control m-bot15" name="user">
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Organisatie</label>
                                    <select class="form-control m-bot15" name="organization">
                                        <option value=""></option>
                                        @foreach($organizations as $id => $name)
                                            <option value="{{$id}}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Rol</label>

                                    <select class="form-control m-bot15" name="role">
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
                    <form method="post" action="{{action('ProfileController@changeProfile', "user")}}">
                        @csrf

                        <input class="form-control m-bot15" type="hidden" name="user" value="{{Auth::user()->id}}"/>

                        <div class="form-group">
                            <label class="col-form-label">Naam</label>
                            <input class="form-control m-bot15" type="text" name="name"/>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Wachtwoord</label>
                            <input class="form-control m-bot15" type="password" name="password" placeholder="Nieuw wachtwoord"/>
                            <small class="form-text text-muted">Vul je nieuwe wachtwoord in als je je wachtwoord wilt veranderen.</small>
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
        @endif
    </div>

@endsection

@section("scripts")
    <script type="text/javascript" src="{{ URL::asset('js/profile.js') }}"></script>
@endsection
