@extends('layouts.app')
@section('title')
    {{ __('messages.kanban_list') }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dragula/dragula.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/kanban.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.kanban_list') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('tasks.index') }}"
                   class="btn btn-primary form-btn float-right-mobile">{{ __('messages.list_view') }}</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="col-12">
                    <div class="row flex-nowrap pt-3 overflow-auto board-container">
                        <div class="lock-board">
                        </div>
                        @include('tasks.kanban.show_fields')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        let taskUrl = '{{ route('tasks.index') }}';
    </script>
    <script src="{{ mix('assets/js/dom-autoscroller.js') }}"></script>
    <script src="{{ mix('assets/js/dragula/dragula.js') }}"></script>
    <script src="{{ mix('assets/js/tasks/kanban.js') }}"></script>
@endsection
