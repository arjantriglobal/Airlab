@extends('layouts.app')
@section('content')
    <script type="text/javascript" src="{{ URL::asset('js/profile.js') }}"></script>

    @if($user->role == 2)
        <div class="container-fluid" id="container" style="min-width:800px;" data-bind="if: showAdminPart">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profiles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="upload" aria-selected="false">Admin</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h1>All Profiles</h1>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Organization</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($profiles as $profile)
                            <tr>
                                <td>{{$profile->name}}</td>
                                <td>{{$profile->email}}</td>
                                <td>{{$profile->organization_id}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                    <h1>Admin</h1>
                    <div>
                        <a href="#" data-bind="click: changeSet.bind($data, 'Register')">
                            <button type="button" class="btn btn-info">Register</button>
                        </a>
                        <a href="#" data-bind="click: changeSet.bind($data, 'Upload Blueprint')">
                            <button type="button" class="btn btn-info">Upload Blueprint</button>
                        </a>
                        <a href="#" data-bind="click: changeSet.bind($data, 'Change setting')">
                            <button type="button" class="btn btn-info">User info</button>
                        </a>

                    </div>
                    <form>
                        <div class="form-group">
                            <label class="col-form-label">Organization</label>
                            <select class="form-control" id = "orgSelect" data-bind= "options: $data.organizations,
                                    optionsText: 'name',
                                    optionsValue: 'id',
                                    event:{change: orgSet}"></select>
                        </div>
                        <!-- ko if: $data.set() == 'Change setting' -->
                        <div class="form-group">
                            <label class="col-form-label">Users</label>
                            <select class="form-control" id = "userSelect" data-bind= "options: $data.users,
                                    optionsText: 'name',
                                    optionsValue: 'id',
                                    value: $data.currentUser"></select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">User organization</label>
                            <select class="form-control" id = "orgChange" data-bind= "options: $data.organizations,
                                    optionsText: 'name',
                                    optionsValue: 'id',"></select>
                        </div>
                        <!-- /ko -->
                        <div class="form-group">
                            <div data-bind="foreach:inputs" class="form-group ">
                                <label data-bind="text: name" class="col-form-label"></label>
                                <input data-bind="attr:{id:name, type:input, placeholder: name,}" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 offset-9">
                                <button class="btn btn-success" data-bind = "click:multiFunc, text:set"></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid" id="container" style="min-width:800px;">
            <h1>Profile</h1>
            <div>
                <div class="form-group" data-bind="foreach: $root.currentTabData">
                    <label for="name">Name</label>
                    <input type="name" class="form-control" id="name" data-bind="value : $data.name">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" data-bind="value : $data.email">
                    <label for="Organization">Organization</label>
                    <input type="Organization" class="form-control" id="Organization" data-bind="value : $data.organization" disabled="">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" aria-describedby="passwordDis" placeholder="Enter password" data-bind="value :$root.new_password">
                    <small id="passwordDis" class="form-text text-muted">Enter password if you want to change your password.</small>
                    <button type="button" class="btn btn-lg btn-success float-right" data-bind="click: $root.editProfile.bind($data)">
                        save
                    </button>
                </div>
            </div>
        </div>
    @endif

@endsection