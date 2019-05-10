@extends('layouts.airlab')
@section('content')
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
@endsection