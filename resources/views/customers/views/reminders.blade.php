@extends('customers.show')
@section('section')
    <section class="section">
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-header">
                    <div class="mt-0 mb-3 col-12 d-flex justify-content-end livewire-search">
                        <div class="justify-content-end mr-2">
                            {{ Form::select('is_notified', $notifiedReminder, null, ['id' => 'filterNotified', 'class' => 'form-control','placeholder' => 'Select Email Status']) }}
                        </div>
                        <div class="text-right">
                            <a href="#" class="btn btn-primary addReminderModal add-button text-nowrap"
                               data-toggle="modal"
                               data-target="#addModal">{{ __('messages.reminder.set_reminder') }} <i
                                        class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('reminders.table')
                </div>
            </div>
        </div>
        @include('reminders.templates.templates')
        @include('reminders.add_modal')
        @include('reminders.edit_modal')
    </section>
@endsection
@push('page-scripts')
    <script>
        let reminderUrl = "{{ route('reminder.index') }}/";
        let reminderSaveUrl = "{{ route('reminder.store') }}";
        let contactUrl = "{{ route('contacts.index') }}";
    </script>
    <script src="{{mix('assets/js/reminder/reminder.js')}}"></script>
@endpush
