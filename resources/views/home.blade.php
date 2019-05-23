@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-12 col-lg-2">
                <div class="form-group">
                    <select class="form-control" onchange="selectOrganization(this);">
                        <option value="0">Selecteer organisatie</option>
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="p-2 card">
                    <div class="d-none" data-organization="-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="p-1">Geen plattegrond(en) beschikbaar</span>
                        </div>
                    </div>
                    @foreach ($organizations as $organization) 
                        @if(count($organization->blueprints) > 0)   
                            <div class="d-block" data-organization="{{$organization->id}}">
                                @foreach ($organization->blueprints as $blueprint)
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span data-id="{{$blueprint->id}}" class="p-1 blueprintTitle">{{ $blueprint->name }}</span>
                                        <div>
                                            <button class="p-1 btn btn-link text-info" onclick="toggleBlueprint({{$blueprint->id}});"><i class="fas fa-search"></i></button>
                                            <button data-id="{{ $blueprint->id }}" class="p-1 btn btn-link changeBlueprintName"><i class="fas fa-pencil-alt"></i></button>
                                            <button class="p-1 btn btn-link text-danger" onclick="toggleBlueprint({{$blueprint->id}});"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-md-12 col-lg-8">
                <div class="card p-2">
                    <div id="blueprint">
                        <canvas></canvas>
                        <div class="devices"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2">
                <div class="p-2 card">
                    <h3 class="p-1">Apparaten</h3>
                    @foreach ($blueprints as $blueprint)
                        <div class="d-none" data-blueprint="-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="p-1">Geen apparaten beschikbaar</span>
                            </div>
                        </div>
                        @if(count($blueprint->devices) > 0 )
                            <div class="d-block" data-blueprint="{{$blueprint->id}}">
                                @foreach($blueprint->devices as $device)
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="p-1 deviceTitle">{{ $device->name }}</span>
                                        <div>
                                            <button data-id="{{$device->id}}" class="p-1 btn btn-link"><i class="fas fa-pencil-alt"></i></button>
                                            <button class="p-1 btn btn-link text-danger" onclick="toggleBlueprint({{$blueprint->id}});"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-5 d-none">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-md-4">
                    <form class="form-inline">
                        <input class="form-control mr-1" type = "text" id = "changeName">
                        <button type="button" class="btn btn-primary" data-bind="click:changeNameBTN">Change name</button>
                    </form>
                </div>
                <div class="col-md-3" >
                    <div class="form-group">
                        <select class="form-control">

                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                        <button type="button"class="btn btn-danger" data-bind="click:deleteBP">Delete</button>
                </div>
                <div class="col-md-4">
                    <div class="btn-group float-right" role="group">
                        <button class="btn btn-info btn-md" type = 'button' data-bind="click: loadModel.bind($data, 'statData')">Show static data</button>
                        <button class="btn btn-info btn-md" type = 'button' data-bind="click: loadModel.bind($data, 'dash')">Show blueprint</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <h1 class="col-8" data-bind="text: blueprintName"></h1>
                <div class="col-2">
                    <a class="nav-link" href="{{ url('api/blueprint/fullscreen') }}" target="_blank"><button class="btn btn-info btn-md" type = 'button'>Fullscreen</button></a>
                </div> 
                <div class="col-2">
                    <div data-bind="if: showUnlocked">
                        <a class="nav-link" href="#" data-bind="click: stopDragNDropLogic">
                            <button class="btn btn-success"><i class="fas fa-lock-open"></i> unlocked</button>
                        </a>
                    </div>
                    <div data-bind="if: showLocked">
                        <a class="nav-link" href="#" data-bind="click: dragNDropLogic">
                            <button id="startDnD" class="btn btn-danger"><i class="fas fa-lock"></i> locked</button>
                        </a>
                    </div>
                </div>
            </div>



            <div class="modal fade" tabindex="-1" role="dialog" id="removeDevice">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="true">Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="chart-tab" data-toggle="tab" href="#chart" role="tab" aria-controls="chart" aria-selected="false">Chart</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
                                <div class="modal-header">
                                    <div data-bind="foreach: $root.devices">
                                        <h4 class="modal-title" data-bind="text: name"></h4>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <td>Name</td>
                                            <td>Value</td>
                                        </thead>
                                        <tbody data-bind="foreach: $root.records">
                                            <tr data-bind="css: bgColor">
                                                <th data-bind="text: name">Temperature: </th>
                                                <td data-bind="text: value"></td>
                                            </tr>                
                                        </tbody>
                                    </table> 
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="#" data-bind="click: removeDevice">
                                        <button class="btn btn-danger" type="button">Remove device</button>
                                    </a>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="chart" role="tabpanel" aria-labelledby="chart-tab">
                                <h1 data-bind="text: selectedOptionValue"></h1>
                                <div class="dropdown">
                                    <tr>
                                        <td class="label">Drop-down list:</td>
                                        <td><select data-bind="options: optionValues, value: selectedOptionValue, click: getChart"></select></td>
                                    </tr>
                                </div>
                                <canvas id="myChart" height="300" width="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav flex-column">
                <div data-bind="foreach: $root.blueprintDevices" class="nav-item">
                    <li data-bind="text: name, attr: { id: id }, style: { top: null, left: null }" class="draggable btn btn-danger drag-drop"></li>
                </div>
            </ul>
            <br>
            <form enctype="multipart/form-data" id = "uploadForm" class="form">
                <label>Upload:</label>
                <input type="file" id="files" name="" placeholder="New BP" accept="image/*" data-bind="event:{change: $root.fileSelect}">
                <label>Change:</label>
                <input type="file" id="files" name="" placeholder="Switch BP" accept="image/*" data-bind="event:{change: $root.fileSwitch}">
            </form>
        </div>

        <div class="row">
            <div class="col align-self-end">
            <div class="btn-group float-right " role="group">
                <button class="btn btn-info btn-md" type = 'button' data-bind="click: loadModel.bind($data, 'statData')">Show static data</button>
                <button class="btn btn-info btn-md" type = 'button' data-bind="click: loadModel.bind($data, 'dash')">Show blueprint</button>
            </div>
            </div>
        </div>
        <div style="max-width:1000px;" class="mt-4">
            <div data-bind="foreach: allColorDevices" class="card-columns">
                <div class="card text-white  mb-3" data-bind="css: $data.color " style="max-width: 18rem;">
                    <div class="card-body">
                <h5 class="card-title d-inline" data-bind="text: $data.name"></h5>
                        <!-- <a data-toggle="modal" data-target="#editNameModal" data-id="bla"><i class="fas fa-edit d-inline float-right"></i></a>-->
                        <p class="card-text" data-bind="text: $data.message"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')    
    <div class="modal fade" id="changeBlueprintNameModal" tabindex="-1" role="dialog" aria-labelledby="changeNameModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="changeNameModalLabel">Naam wijzigen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" name="blueprintName" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnChangeName">Opslaan</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var blueprints = {!! json_encode($blueprints) !!};
        var selected_blueprint = null;

        $(document).ready(function(){
            $(".changeBlueprintName").on("click", function(){
                var blueprintid = parseInt($(this).attr("data-id"));
                $("#btnChangeName").attr("data-id", blueprintid);
                var blueprint = blueprints.find(function(blueprint){
                    return blueprint.id === blueprintid;
                })
                $("#changeBlueprintNameModal").find("input[name='blueprintName']").val(blueprint.name);
                $("#changeBlueprintNameModal").modal("show");
            });

            $("#btnChangeName").on("click", function(){
                var blueprintid = parseInt($(this).attr("data-id"));
                var blueprint = blueprints.find(function(blueprint){
                    return blueprint.id === blueprintid;
                })
                var newname = $("#changeBlueprintNameModal").find("input[name='blueprintName']").val();
                changeName(blueprint.id, newname, function(res){
                    $(".blueprintTitle[data-id=" + blueprint.id + "]").text(newname);
                    $("#changeBlueprintNameModal").modal("hide");
                    blueprint.name = newname;
                });
            });
        })

        function selectOrganization(select){
            var organizations = document.querySelectorAll("[data-organization]");
            organizations.forEach(function(organization){
                if(select.value === "0"){
                    if(organization.getAttribute("data-organization") === "-1"){
                        organization.classList.add("d-none");
                        organization.classList.remove("d-block");
                    }else{
                        organization.classList.remove("d-none");
                        organization.classList.add("d-block");
                    }
                }
                else{
                    organization.classList.remove("d-block");
                    organization.classList.add("d-none");
                    if(organization.getAttribute("data-organization") === select.value){
                        organization.classList.add("d-block");
                    }
                }
            });
            if(document.querySelectorAll(".d-block[data-organization]").length < 1){
                var el = document.querySelector("[data-organization='-1']");
                el.classList.add("d-block");
                el.classList.remove("d-none");
            }
        }

        function selectBlueprint(blueprintid){
            var blueprints = document.querySelectorAll("[data-blueprint]");
            blueprints.forEach(function(blueprint){
                if(blueprintid === "0"){
                    if(blueprint.getAttribute("data-blueprint") === "-1"){
                        blueprint.classList.add("d-none");
                        blueprint.classList.remove("d-block");
                    }else{
                        blueprint.classList.remove("d-none");
                        blueprint.classList.add("d-block");
                    }
                }
                else{
                    blueprint.classList.remove("d-block");
                    blueprint.classList.add("d-none");
                    if(blueprint.getAttribute("data-blueprint") === blueprintid){
                        blueprint.classList.add("d-block");
                    }
                }
            });
            if(document.querySelectorAll(".d-block[data-blueprint]").length < 1){
                var el = document.querySelector("[data-blueprint='-1']");
                el.classList.add("d-block");
                el.classList.remove("d-none");
            }
        }

        function toggleBlueprint(blueprintid){
            selectBlueprint(blueprintid+"");
            selected_blueprint = blueprints.find(function(blueprint){
                return blueprint.id === blueprintid;
            })
            var blueprintContainer = document.getElementById('blueprint');
            var deviceContainer = blueprintContainer.querySelector(".devices");
            deviceContainer.innerHTML = "";
            var canvas = blueprintContainer.querySelector("canvas");
            var context = canvas.getContext("2d");
            var imageUrl = "{{env('APP_URL') }}/" + selected_blueprint.path;
            var img = document.createElement("img");
            img.src = imageUrl;
            img.onload = function(){
                canvas.width = img.naturalWidth;
                canvas.height = img.naturalHeight;
                var ratio = (canvas.clientWidth / canvas.width);
                context.drawImage(img, 0,0);
                getBlueprintDevices(selected_blueprint.id, function(devices){
                    if(devices){
                        devices.forEach(function(device) {
                            (function(){
                                var el = document.createElement("div");
                                el.id="device"+device.id;
                                el.style.top = (device.top_pixel * ratio) + "px";
                                el.style.left = (device.left_pixel * ratio) + "px";
                                el.setAttribute("data-id", device.id);
                                getDeviceStatus(device.id, function(data){
                                    if(data){
                                        var message = data.messages[0], statusclass = "shadow-secondary";
                                        switch(data.value){
                                            case 1:
                                                statusclass = "shadow-success";
                                            break;
                                            case 2:
                                                statusclass = "shadow-warning";
                                            break;
                                            case 3:
                                                statusclass = "shadow-danger";
                                            break;
                                        }
                                        el.classList.add("device", "shadow", statusclass);
                                        deviceContainer.appendChild(el);
                                            $("#" + el.id).popover({
                                            placement: 'top',
                                            animation: true,
                                            trigger: 'hover',
                                            title: device.name,
                                            content: message
                                        });
                                    }
                                });
                            })();
                        });
                    }
                });
            }
        }

        var resizeTimeout = null;
        window.onresize = function(){
            if(resizeTimeout) clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function(){
                toggleBlueprint(selected_blueprint.id);
            }, 400);
        }

        function getLastRecord(deviceid, cb){
            getRequest("/api/devices/" + deviceid + "/lastrecord", cb);
        }

        function getDeviceStatus(deviceid, cb){
            getRequest("/api/devices/" + deviceid + "/status", cb);
        }

        function getBlueprintDevices(blueprintid, cb){
            getRequest("/api/blueprints/" + blueprintid + "/devices", cb);
        }

        function changeName(blueprintid, name, cb){
            ApiRequest("/api/blueprints/"+ blueprintid + "/name", "POST", {name: name}, cb);
        }

        function getRequest(url, cb){
            var url = "{{ env('APP_URL') }}"+ url;
            var xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                cb(xhttp.response);
            };
            xhttp.onerror = function(){
                cb(null);
            }
            xhttp.responseType = 'json';
            xhttp.open("GET", url, true);
            xhttp.send();
        }

        function ApiRequest(url, method, data, cb){
            var url = "{{ env('APP_URL') }}"+ url;
            var xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                cb(xhttp.response);
            };
            xhttp.onerror = function(){
                cb(null);
            }
            xhttp.responseType = 'json';
            xhttp.open(method, url, true);
            if(data){
                xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                xhttp.send(JSON.stringify(data));
            }else{
                xhttp.send();
            }
        }
    </script>
@endsection
