@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Super admins
    @parent
@stop

{{-- page level styles --}}
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/datatables/css/dataTables.bootstrap4.css') }}" />
    <link href="{{ asset('public/assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Super admins</h1>
        <ol class="breadcrumb">
            <li><a href="#">Super admins</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="col-12">
                <div class="card panel-success ">
                    <div class="card-heading">
                        <h4 class="card-title pull-left add_remove_title"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Super admins
                        </h4>
                        @if(Auth::user()->hasAnyPermission(['User create']))
                            <div class="pull-right">
                                <a href="{{route('users.create')}}" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="left"><i class="fa fa-plus"></i>Add New</a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-lg table-responsive-sm table-responsive-md">
                            <table class="table table-bordered width100" id="permission-table">
                                <thead>
                                <tr class="filters">
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- row-->
    </section>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteLabel">Delete Super admin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    Are you sure, want to delete this super admin?
                </div>
                <input  type="hidden" id="confirm_id" name="delete_id" />
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button onclick="deleteComment()" type="button" class="btn btn-danger Remove_square">Delete</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript" src="{{ asset('public/assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('public/assets/vendors/datatables/js/dataTables.bootstrap4.js') }}" ></script>
    <script>
        $(function () {
            $.fn.dataTable.ext.errMode = 'throw';
            $('#permission-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('get.users') !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });

        function confirmDelete(id) {
            $("#delete_confirm").modal("show");
            $("#confirm_id").val(id);

        }
        function deleteComment(){
            var id = $("#confirm_id").val();
            $("#form"+id).submit();
        }
    </script>
@stop
