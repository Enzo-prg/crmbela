@extends('customers.show')
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/contracts/contracts.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('section')
    <section class="section">
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-header">
                    <div class="row w-100 justify-content-end">
                        <a href="{{ route('contracts.create', $customer->id) }}"
                           class="btn btn-primary form-btn add-button">{{ __('messages.common.add') }} <i
                                    class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @livewire('contracts', ['customer' => $customer->id])
                </div>
            </div>
        </div>
    </section>
@endsection
@push('page-scripts')
    @livewireScripts
    <script>
        let contractUrl = "{{ route('contracts.index') }}";
    </script>
    <script src="{{mix('assets/js/contracts/contracts.js')}}"></script>
@endpush
