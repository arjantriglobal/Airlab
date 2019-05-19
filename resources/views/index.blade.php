@extends('layouts.app')
@section('content')
<script type="text/html" id="oldData">
<div class="col-md-12">
                <div class="row">  
                    <div class="col-10">
                        <h1 data-bind="text: deviceName"></h1>              
                        <div data-bind="if: noData">
                            <h4>No data for this device</h4>
                        </div>
                    </div>
                    <div class="col-2">
                        <a class="nav-link" href="#" data-bind="click: loadModel.bind($data, 'dev')">
                            <button class="btn btn-danger" type="button">Back</button>
                        </a>  
                    </div>
                </div>
                <div data-bind="if: history">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>temperature</th>
                                <th>relative_humidity</th>
                                <th>pm2_5</th>
                                <th>tvoc</th>
                                <th>co2</th>
                                <th>co</th>
                                <th>air_pressure</th>
                                <th>ozone</th>
                                <th>no2</th>
                                <th>date</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: oldRecords" >
                            <tr>
                                <td data-bind="text: temperature"></td>
                                <td data-bind="text: relative_humidity"></td>
                                <td data-bind="text: pm2_5"></td>
                                <td data-bind="text: tvoc"></td>
                                <td data-bind="text: co2"></td>
                                <td data-bind="text: co"></td>
                                <td data-bind="text: air_pressure"></td>
                                <td data-bind="text: ozone"></td>
                                <td data-bind="text: no2"></td>
                                <td data-bind="text: created_at"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
</script>

<script type="text/html" id='profileTemplate'>
    <div class="container-fluid" id="container" style="min-width:800px;" data-bind="if: showAdminPart">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">My profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="upload" aria-selected="false">Admin</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <h1>Profile</h1>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr data-bind="foreach: currentTabHead">
                            <th data-bind="text: name"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-bind="text:username"></td>
                            <td data-bind="text:useremail"></td>
                            <td data-bind="text:userorganization"></td>
                        </tr>
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
    <div class="container-fluid" id="container" style="min-width:800px;" data-bind="if: showUserPart">
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
</script>

<script type="text/html" id="deviceTemplate">
    <p>Devices</p>
    <!--Admin device to organization-->
    <div class="container" style="min-width:800px;" data-bind="if: showAdminPart">
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="margin:50px 0">
                    <!-- Default panel contents -->
                    <div class="card-header">Organizations</div>
                    <ul class="list-group list-group-flush" style="overflow: auto; height: 15em;">
                      <div data-bind="foreach: organization">
                        <li class="list-group-item">
                            <span data-bind="text: $data.name"></span>
                            <label class="checkbox">
                                <input type="radio" name="organization" data-bind="value: id, click: $root.organizationRadiobox" />
                                <span class="success"></span>
                            </label>
                        </li>
                      </div>
                    </ul>
                </div>
            </div>
            <div data-bind='visible: showOrgDevices' class="col-md-4">
                <div class="card" style="margin:50px 0">
                    <!-- Default panel contents -->
                    <div class="card-header">Devices from organization</div>
                    <ul class="list-group list-group-flush" style="overflow: auto; height: 15em;">
                      <div data-bind="foreach: devicesOrganization">
                        <li class="list-group-item">
                            <span data-bind="text: $data.name"></span>
                            <label class="checkbox">
                                <input type="checkbox" data-bind="value: id" name="devicesOrganization" />
                                <span class="success"></span>
                            </label>
                        </li>
                      </div>
                    </ul>
                    <div class="card-footer">
                      <button class="btn btn-danger" data-bind="click: devicesOwner" type="button" name="button">Delete</button>
                    </div>
                </div>
            </div>
            <div data-bind='visible: showNewDevices' class="col-md-4">
                <div class="card" style="margin:50px 0">
                    <!-- Default panel contents -->
                    <div class="card-header">New devices</div>
                    <ul class="list-group list-group-flush" style="overflow: auto; height: 15em;">
                      <div data-bind="foreach: newDevices">
                        <li class="list-group-item">
                            <span data-bind="text: $data.name"></span>
                            <label class="checkbox">
                                <input type="checkbox" data-bind="value: id" name="newDevices" />
                                <span class="success"></span>
                            </label>
                        </li>
                      </div>
                    </ul>
                    <div class="card-footer">
                      <button class="btn btn-primary" data-bind="click: newDevice" type="button" name="button">Save</button>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="container" style="min-width:800px;" data-bind="if: !showAdminPart()">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Serial number</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: allUserDevices" >
                    <tr>
                        <td ><input type="" data-bind="value :name"></input></td>
                        <td data-bind="text:serial_number"></td>
                        <td >
                          <button type="button" class="btn btn-success" data-bind="click: $root.editDevice.bind($data)">Save</button>
                          <button type="button" class="btn btn-primary"data-bind="click:  $root.oldData.bind($data), value: id">More info</button>

                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
</script>

<script type="text/html" id ="recordsTemplate">
    <p>Records</p>
    <table class="table table-striped table-bordered">
        <thead>
            <tr data-bind="foreach: currentTabHead">
                <th data-bind="text: name"></th>
            </tr>
        </thead>
        <tbody data-bind="foreach: $root.currentTabDataRecords" >
            <tr>
                <td class="btn btn-success" data-bind="text: device.name"></td>
                <td data-bind="text: temperature"></td>
                <td data-bind="text: relative_humidity"></td>
                <td data-bind="text: pm2_5"></td>
                <td data-bind="text: tvoc"></td>
                <td data-bind="text: co2"></td>
                <td data-bind="text: co"></td>
                <td data-bind="text: air_pressure"></td>
                <td data-bind="text: ozone"></td>
                <td data-bind="text: no2"></td>
            </tr>
        </tbody>
    </table>
    <div data-bind='visible: showNewDevices' class="col-md-4">
        <div class="card" style="margin:50px 0">
            <!-- Default panel contents -->
                <div class="card-header">New devices</div>
                <ul class="list-group list-group-flush" style="overflow: auto; height: 15em;">
                    <div data-bind="foreach: newDevices">
                        <li class="list-group-item">
                            <span data-bind="text: $data.name">Some org</span>
                            <label class="checkbox">
                                <input type="checkbox" data-bind="value: id" name="newDevices" />
                                <span class="success"></span>
                            </label>
                        </li>
                    </div>
                </ul>
                <div class="card-footer">
                  <button class="btn btn-primary" data-bind="click: newDevice" type="button" name="button">Save</button>
                </div>
            </div>
        </div>
    </div>
</script>
<script type="text/html" id="loginPage" >
    <div class="row justify-content-center" style="width: 1450px;">
        <div class="col-md-3 col-of" id ="loginCont">
            <h1 class="h3 mb-3 font-weight-normal" data-bind="text: currentPage"></h1>
            <form class="form-signin" >
                <div data-bind="foreach: currentPageData">
                    <input class="form-control" required="" data-bind="attr: {type: name, id: name, placeholder: name}">
                </div>
                <button class="btn btn-lg btn-primary btn-block"data-bind="click:loginToken, text:loginButton"></button>
            </form>
            <div class="form-row" data-bind="foreach: pages">
                <div class="col-md-12 mt-2">
                    <a href="#" class="form-control btn btn-info" data-bind="click: $root.choosePage.bind($data, name), text: name"></a>
                </div>
            </div>
            <p class="mt-5 mb-3 text-muted">&copy; 2018 Air Lab</p>
        </div>
    </div>
</script>

<main role="main" class="col-md-12 ml-sm-auto ">
    <div class= 'container-fluid'>
        <div class='row'>
            <div class="col-md-2 bg-light sidebar" data-bind="visible:nav">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <blockquote class="blockquote text-center">
                                <p class="mb-0" data-bind="text: $root.userOrganization"></p>
                                <footer class="blockquote-footer" data-bind="text: $root.userEmail"></footer>
                            </blockquote>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bind="click: loadModel.bind($data, 'dash')">
                                <button class="btn btn-info col" type="button"> Dashboard</button>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bind="click: loadModel.bind($data, 'pro')">
                                <button class="btn btn-info col" type="button"> Profile</button>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bind="click: loadModel.bind($data, 'dev')">
                                <button class="btn btn-info col" type="button"> Devices</button>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bind="click: loadModel.bind($data, 'out')">
                                <button class="btn btn-danger col" type="button"> Logout</button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-bind="template:currentTemplate" ></div>
        </div>
    </div>
</main>
@endsection
