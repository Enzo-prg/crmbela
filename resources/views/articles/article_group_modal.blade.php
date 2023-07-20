<div id="addArticleGroupModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.article_group.new_article_group') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'addArticleGroupForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('groupName', __('messages.article.group').':') }}<span
                                class="required">*</span>
                        {{ Form::text('group_name', null, ['class' => 'form-control', 'required','autocomplete' => 'off']) }}
                    </div>
                </div>
                <input type="hidden" name="color" value="#3F51B5">
                <input type="hidden" name="order" value="1">
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit', 'class' => 'btn btn-primary', 'id'=>'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" id="btnCancel" class="btn btn-light ml-1"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
