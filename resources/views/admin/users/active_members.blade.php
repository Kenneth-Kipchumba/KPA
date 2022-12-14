@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
            <div class="row">
                <div class="col-md-6"> {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }} </div>
                <div class="col-md-6 text-right">
                    @can('user_create')
                        <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'User', 'route' => 'admin.users.parseCsvImport'])
                    @endcan
                </div>
            </div>
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-User">
            <thead>
                <tr>
                    <td>Member No</td>
                    <td>Name</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                @foreach($active_members as $active_member)
                 <tr>
                     <td>{{ $active_member->member_no }}</td>
                     <td>{{ $active_member->name }}</td>
                     <td>
                        @if($active_member->status == 2)
                           PAID
                        @endif
                     </td>
                 </tr>
                @endforeach
            </tbody>
            <tfoot>
                
            </tfoot>
        </table>
    </div>
</div>



@endsection
