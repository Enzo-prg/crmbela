@extends('layouts.app')
@section('title')
    {{ __('messages.credit_notes') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ mix('assets/css/credit_notes/credit_notes.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.credit_notes') }}</h1>
            <div class="section-header-breadcrumb float-right">
                <div class="card-header-action mr-3 select2-mobile-margin">
                    {{ Form::select('payment_status',$paymentStatuses,null,['id' => 'filterStatus','class' => 'form-control','placeholder' => 'Select Status']) }}
                </div>
            </div>
            <div class="float-right">
                <a href="{{ route('credit-notes.create') }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @livewire('credit-notes')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let creditNoteUrl = "{{ route('credit-notes.index') }}";
        let customerId = null;
    </script>
    <script src="{{ mix('assets/js/credit-notes/credit-notes-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/status-counts/status-counts.js')}}"></script>
@endsection

