<div id="addDepartmentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.department.new_department') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'addNewDepartmentForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('name', __('messages.common.name').':') }}<span class="required">*</span>
                        {{ Form::text('name', null, ['class' => 'form-control', 'required','autocomplete' => 'off']) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{ Form::button(__('messages.common.save'), ['type'=>'submit', 'class' => 'btn btn-primary', 'id'=>'btnSave', 'data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                <button type="button" id="btnCancel" class="btn btn-light ml-1"
                        data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
