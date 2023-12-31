@extends('layouts.app')
@section('title')
    {{ __('messages.items') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header item-align-right">
            <h1>{{ __('messages.items') }}</h1>
            <div class="section-header-breadcrumb float-right">
                <div class="card-header-action mr-3 select2-mobile-margin">
                    {{ Form::select('group', $data['itemGroups'], null, ['id' => 'filter_group', 'class' => 'form-control', 'placeholder' => 'Select Product Group']) }}
                </div>
            </div>
            <div class="float-right">
                <a href="#" class="btn btn-primary form-btn" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.common.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('items.table')
                </div>
            </div>
        </div>
    </section>
    @include('items.templates.templates')
    @include('items.add_modal')
    @include('items.edit_modal')
    @include('items.item_group_modal')
    @include('items.edit_item_group_modal')
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js')}}"></script>
@endsection
@section('scripts')
    <script>
        let itemUrl = "{{ route('items.index') }}";
        let itemCreateUrl = "{{ route('items.store') }}";
        let itemGroupCreateUrl = "{{ route('item-groups.store') }}";
    </script>
    <script src="{{ mix('assets/js/custom/input-price-format.js')}}"></script>
    <script src="{{ mix('assets/js/items/items.js')}}"></script>
@endsection
