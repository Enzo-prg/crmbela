@extends('layouts.app')
@section('title')
    {{ __('messages.tasks') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ mix('assets/css/tasks/task.css') }}">
    <style type="text/css">
.badge-001FFF {
  background-color: #001FFF;
  color: white;
}
</style>
@endsection
@section('content')
    <section class="section">
        <div class="section-header task-sec-mbl-hdr">
            <h1>{{ __('messages.tasks') }}</h1>
            <div class="section-header-breadcrumb float-right">
                <div class="card-header-action mr-3">
                    {{ Form::select('priority', $priorities, null, ['id' => 'priorityId', 'class' => 'form-control','placeholder' => 'Origem']) }}
                </div>
            </div>

            <div class="float-right mr-3">
                {{ Form::select('status', $status, null, ['id' => 'filter_status', 'class' => 'form-control select2-mobile-margin','placeholder' => 'Selecione Status']) }}
            </div>
            
            <div class="float-right">
                <!--<a href="{{ route('tasks.kanbanList') }}"
                   class="btn btn-warning form-btn mr-2 text-nowrap">{{ __('messages.kanban_view') }}
                </a>-->
                <a href="{{ route('tasks.create') }}"
                   class="btn btn-primary form-btn text-nowrap">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="section-body mb-4">
            <div class="row justify-content-md-center text-center">
                <div class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="ticket-statistics mx-auto bg-success">
                            <p>{{ $statusCount->not_started }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('lead') }}</h5>
                    </div>
                    <div class="item">
                        <div class="ticket-statistics mx-auto bg-info">
                            <p>{{ $statusCount->in_progress }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('Cotacao s/proposta') }}</h5>
                    </div>
                    <div class="item">
                        <div class="ticket-statistics mx-auto bg-warning">
                            <p>{{ $statusCount->testing }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('proposta c/visita') }}</h5>
                    </div>
                    <div class="item">
                        <div style="background-color: #001FFF;"class="ticket-statistics mx-auto">
                            <p>{{ $statusCount->awaiting_feedback }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('Fechado') }}</h5>
                    </div>
                    <div class="item">
                        <div class="ticket-statistics mx-auto bg-danger">
                            <p>{{ $statusCount->completed }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('Perdido') }}</h5>
                    </div>
                    <div class="item">
                        <div class="ticket-statistics mx-auto bg-danger">
                            <p>{{ $statusCount->cancelado }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('cancelado') }}</h5>
                    </div>
                    <div class="item">
                        <div class="ticket-statistics mx-auto bg-warning">
                            <p>{{ $statusCount->parado }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('parado') }}</h5>
                    </div>
                    <div class="item">
                        <div class="ticket-statistics mx-auto bg-warning">
                            <p>{{ $statusCount->lead_qualificado }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('lead qualificado') }}</h5>
                    </div>
                    <div class="item">
                        <div  style="background-color: #001FFF;" class="ticket-statistics mx-auto bg-warning">
                            <p>{{ $statusCount->enviar_proposta }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('Enviar proposta') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @include('tasks.table')
                </div>
            </div>
        </div>
        @include('tasks.templates.templates')

        
    </section>
   
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js')}}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
@endsection
@section('scripts')
    
    
    <script>
        let taskUrl = "{{ route('tasks.index') }}";
        let statusArray = JSON.parse('@json($status)');
        let priorities = JSON.parse('@json($priorities)');
        let fabricante = JSON.parse('@json($fabricantes)');
        let ownerId = null;
        let ownerType = null;
        let memberUrl = "{{ route('members.index') }}";
    </script>
    <script src="{{mix('assets/js/tasks/tasks.js')}}"></script>
    <script src="{{mix('assets/js/status-counts/status-counts.js')}}"></script>
@endsection
