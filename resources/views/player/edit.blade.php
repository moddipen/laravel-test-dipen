@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Edit Player
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <link href="{{ asset('public/assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendors/select2/css/select2.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('public/assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/css/pages/wizard.css') }}" rel="stylesheet">
    <!--end of page level css-->
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Edit Player</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li><a href="{{route('players.index')}}">Players</a></li>
            <li class="active">Edit Player</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 my-3">
                <div class="card panel-primary">
                    <div class="card-heading">
                        <h3 class="card-title">
                            <i class="livicon" data-name="user-add" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            Edit Player
                        </h3>
                        <span class="float-right clickable">
                                    <i class="fa fa-chevron-up"></i>
                                </span>
                    </div>
                    <div class="card-body">
                        <!--main content-->
                        <form id="commentForm" action="{{ route('players.update', $player->id) }}"
                              method="POST" enctype="multipart/form-data" class="form-horizontal">
                            @method('put')
                            @csrf
                            <div id="rootwizard">
                                <div class="tab-content">
                                    <div>
                                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                            <div class="row">
                                                <label for="name" class="col-sm-2 control-label">Name *</label>
                                                <div class="col-sm-10">
                                                    <input id="name" name="name" type="text" placeholder="Name" class="form-control required" value="{{ old('name') ?? $player->name }}"/>
                                                    <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('image', 'has-error') }}">
                                            <div class="row">
                                                <label for="email" class="col-sm-2 control-label">Photo *</label>
                                                <div class="col-sm-5">
                                                    <input name="image" type="file" class="form-control required"/>
                                                    <span class="help-block">{{ $errors->first('image', ':message') }}</span>
                                                </div>
                                                <div class="col-sm-5">
                                                    <img width="50px" height="50px" src="{{ $player->getMedia('player')[0]->getFullUrl() }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('role_id', 'has-error') }}">
                                            <div class="row">
                                                <label for="select21" class="col-sm-2 control-label">
                                                    Player Group *
                                                </label>
                                                <div class="col-sm-10">
                                                    <select id="select21" name="player_group" class="form-control select2">
                                                        <option value="">Select player group</option>
                                                        @foreach($playerGroups as $playerGroup)
                                                            <option {{ $player->player_group_id == $playerGroup->id ? 'selected="selected"' : '' }} value="{{$playerGroup->id}}">{{$playerGroup->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block">{{ $errors->first('player_group', ':message') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button align = 'center' type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" id="delButton">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--row end-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('public/assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script src="{{ asset('public/assets/vendors/moment/js/moment.min.js') }}" ></script>
    <script src="{{ asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/js/pages/adduser.js') }}"></script>
@stop
