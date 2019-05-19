@extends('layouts.app')

@section('content')
    <div class="container">
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
                            @foreach ($blueprints as $blueprint)
                                <option value={{$blueprint->id}}>{{ $blueprint->name }}</option>
                            @endforeach
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

            <div id="bp" style="border:2px solid black; background-color: white;">
                <canvas class="droppable" id="currentBP" width="1000" height="500"></canvas>  
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
