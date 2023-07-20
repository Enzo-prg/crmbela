@extends('layouts.app')
@section('title')
    {{ __('messages.countries') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/countries/country.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.countries') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addCountryModal float-right-mobile" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.country.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('countries')
                </div>
            </div>
        </div>
        @include('countries.add_modal')
        @include('countries.edit_modal')
    </section>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let countryUrl = "{{ route('countries.index') }}/";
        let countrySaveUrl = "{{ route('countries.store') }}";
    </script>
    <script src="{{ mix('assets/js/countries/country.js') }}"></script>
@endsection
