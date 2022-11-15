@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center">
        
        <a href="{{ route('admin.users.show', $income->member->id) }}"><h2><strong>  {{ $income->receipt_no  }}</strong>  &nbsp;/&nbsp;  <strong>{{ $income->member->name ?? '' }}</strong></h2></a>
       
        <a class="btn btn-default mfs-auto mfe-1 d-print-none" href="{{ url()->previous() }}">
            {{ trans('global.back') }} 
        </a>
        @can('income_create')
        <a class="btn btn-success mfe-1" href="{{ route('admin.incomes.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.income.title_singular') }}
        </a>
        @endcan
        
        <a class='btn btn-info mfe-1' href='{{ $income->items ?? '' }}'>Download</a>

        <a class="btn btn-success" href="{{ route('admin.incomes.edit',$income->id) }}"> 
            Send Email
        </a>


   </div>
    <div class="card-body">
        <div id="pdf-viewer"></div>
       
    </div>
</div>


@endsection
@section('scripts')
@parent
<script>
    $( document ).ready(function() {
        document.title = "KPA - {{ trans('cruds.income.title_singular') }} - {{ $income->receipt_no }}";
    });

    PDFObject.embed("{{ $income->file ?? '' }}", "#pdf-viewer");

</script>
@endsection