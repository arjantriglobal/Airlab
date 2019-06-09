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
                                            @if ($user->role == 2)
                                                <button data-id="{{ $blueprint->id }}" class="p-1 btn btn-link changeBlueprintName"><i class="fas fa-pencil-alt"></i></button>
                                            @endif
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
                    <h3 class="p-1">
                        Apparaten 
                        @if ($user->role == 2)
                            <button id="btnMove" class="btn btn-primary float-right" onclick="moveDevices();">Verplaats</button>
                            <button id="btnSaveMove" class="btn btn-success float-right d-none" onclick="saveDevices();">Opslaan</button>
                        @endif
                    </h3>
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
                                        @if ($user->role == 2)
                                            <button data-id="{{$device->id}}" class="p-1 btn btn-link"><i class="fas fa-pencil-alt"></i></button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
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
        var imageRatio = 1;

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

            //resize function
            $(".nav-button ").on("click", function(){
                $(window).trigger('resize');
            });
        })

        function selectOrganization(select){
            var organizations = document.querySelectorAll("[data-organization]");
            for(var i = 0; i < organizations.length; i++){
                var organization = organizations[i];
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
            }
            if(document.querySelectorAll(".d-block[data-organization]").length < 1){
                var el = document.querySelector("[data-organization='-1']");
                el.classList.add("d-block");
                el.classList.remove("d-none");
            }
        }

        function selectBlueprint(blueprintid){
            var blueprints = document.querySelectorAll("[data-blueprint]");
            for(var i =0; i < blueprints.length; i++){
                var blueprint = blueprints[i];
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
            }
            if(document.querySelectorAll(".d-block[data-blueprint]").length < 1){
                var el = document.querySelector("[data-blueprint='-1']");
                el.classList.add("d-block");
                el.classList.remove("d-none");
            }
        }

        function saveDevices(){
            var btnSaveMove = document.getElementById("btnSaveMove");
            var btnMove = document.getElementById("btnMove");
            btnMove.classList.remove("d-none");
            btnSaveMove.classList.add("d-none");

            $(".devices")[0].onmousemove = null;
            $(".devices")[0].onmouseup = null;
            $(".devices .device").each(function(){
                $(this).removeClass("moveable");
                this.onmousedown = null;
                this.ondrag = null;
                var deviceid = this.getAttribute("data-id");
                var left = this.offsetLeft / imageRatio;
                var top = this.offsetTop / imageRatio;
                savePositions(deviceid, left, top, function(done){
                    if(done){
                    }
                });
            });
        }

        function moveDevices(){
            var btnSaveMove = document.getElementById("btnSaveMove");
            var btnMove = document.getElementById("btnMove");
            btnMove.classList.add("d-none");
            btnSaveMove.classList.remove("d-none");

            var selected_sensor = null;
            var difX = 0;
            var difY = 0;
            var offset = $(".devices").offset();

            $(".devices")[0].onmousemove = function(e){
                if(selected_sensor != null){
                    var left = e.pageX - offset.left - difX;
                    var top = e.pageY - offset.top - difY;
                    if(left < 0){
                        selected_sensor.style.left = "0px";
                    }else if(left > (this.offsetWidth - selected_sensor.offsetWidth)){
                        selected_sensor.style.left = (this.offsetWidth - selected_sensor.offsetWidth) + "px"
                    }else{
                        selected_sensor.style.left = left + "px";
                    }
                    if(top < 0){
                        selected_sensor.style.top = "0px";
                    }else if(top > (this.offsetHeight - selected_sensor.offsetHeight)){
                        selected_sensor.style.top = (this.offsetHeight - selected_sensor.offsetHeight) + "px"
                    }else{
                        selected_sensor.style.top = top + "px";
                    }
                }
            }
            $(".devices")[0].onmouseup = function(e){
                selected_sensor = null;
            }
            $(".devices .device").each(function(){
                $(this).addClass("moveable");
                this.onmousedown = function(e){
                    selected_sensor = this;
                    var left = e.pageX - offset.left;
                    var top = e.pageY - offset.top;
                    difX = left - selected_sensor.offsetLeft;
                    difY = top - selected_sensor.offsetTop;
                }
                this.ondrag = function(){};
            });
        }

        function toggleBlueprint(blueprintid){
            selectBlueprint(blueprintid+"");
            for(i = 0; i < blueprints.length; i++){
                if(blueprints[i].id == blueprintid){
                    selected_blueprint = blueprints[i];
                }
            }
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
                imageRatio = (canvas.clientWidth / canvas.width);
                context.drawImage(img, 0,0);
                getBlueprintDevices(selected_blueprint.id, function(devices){
                    if(devices){
                        for(var i = 0; i < devices.length; i++){
                            (function(){
                                var device = devices[i];
                                var el = document.createElement("div");
                                el.id="device"+device.id;
                                el.style.top = (device.top_pixel * imageRatio) + "px";
                                el.style.left = (device.left_pixel * imageRatio) + "px";
                                el.setAttribute("data-id", device.id);
                                deviceContainer.appendChild(el);
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
                                        getLastRecord(device.id, function(record){
                                            el.classList.add("device", "shadow", statusclass);
                                                $("#" + el.id).popover({
                                                placement: 'top',
                                                animation: true,
                                                html: true,
                                                trigger: 'hover',
                                                title: device.name,
                                                content: ""+
                                                "<div class='popoverstyle'>" + 
                                                    "<p class='m-0'>" + message + "</p><hr class='m-1 w-100' />"+
                                                    "<span style='font-size: 6pt; float: right;'>Bijgewerkt op: " + record.created_at + "</span>"+
                                                "</div>"
                                            });
                                        });
                                    }
                                });
                            })();
                        }
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

        function savePositions(deviceid, x, y, cb){
            ApiRequest("/api/devices/"+ deviceid + "/positions", "POST", {x: x, y: y}, cb);
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
            xhttp.open("GET", url, true);
            xhttp.responseType = 'json';
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
            xhttp.open(method, url, true);
            xhttp.responseType = 'json';
            if(data){
                xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                xhttp.send(JSON.stringify(data));
            }else{
                xhttp.send();
            }
        }
    </script>
@endsection
