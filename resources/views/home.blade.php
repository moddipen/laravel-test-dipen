@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Dashboard
    @parent
@stop

{{-- page level styles --}}
@section('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/vendors/animate/animate.min.css') }}">
    <meta name="_token" content="{{ csrf_token() }}">
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Welcome to Dashboard</h1>
        <ol class="breadcrumb">
            <li class=" breadcrumb-item active">
                <a href="#">
                    <i class="livicon" data-name="home" data-size="16" data-color="#333" data-hovercolor="#333"></i>
                    Dashboard
                </a>
            </li>
        </ol>
    </section>
    <section class="content indexpage">
        <div class="row">
            <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6 margin_10 animated fadeInUpBig">
                <!-- Trans label pie charts strats here-->
                <div class="redbg no-radius">
                    <div class="card-body squarebox square_boxs cardpaddng">
                        <div class="row">
                            <div class="col-12 float-left nopadmar">
                                <div class="row">
                                    <div class="square_box col-6 float-left">
                                        <span><h3>Teams</h3></span>

                                        <div class="number" id="myTargetElement2"></div>
                                    </div>
                                    <div class="col-6">
                                        <div class=" float-right">
                                            <h1>10</h1>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6 margin_10 animated fadeInUpBig">
                <!-- Trans label pie charts strats here-->
                <div class="redbg no-radius">
                    <div class="card-body squarebox square_boxs cardpaddng">
                        <div class="row">
                            <div class="col-12 float-left nopadmar">
                                <div class="row">
                                    <div class="square_box col-6 float-left">
                                        <span><h3>Player groups</h3></span>

                                        <div class="number" id="myTargetElement2"></div>
                                    </div>
                                    <div class="col-6">
                                        <div class=" float-right">
                                            <h1>10</h1>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4 col-sm-6 col-md-6 margin_10 animated fadeInDownBig">
                <!-- Trans label pie charts strats here-->
                <div class="goldbg no-radius">
                    <div class="card-body squarebox square_boxs cardpaddng">
                        <div class="row">
                            <div class="col-12 float-left nopadmar">
                                <div class="row">
                                    <div class="square_box col-6 pull-left">
                                        <span><h3>Players</h3></span>

                                        <div class="number" id="myTargetElement3"></div>
                                    </div>
                                    <div class="col-6">
                                        <div class=" float-right">
                                            <h1>10</h1>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </section>
@stop

{{-- page level scripts --}}
@section('scripts')
    <script src="{{ asset('public/assets/js/pages/dashboard.js') }}" type="text/javascript"></script>
@stop