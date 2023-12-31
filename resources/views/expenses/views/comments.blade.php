@extends('expenses.show')
@section('section')
    <section class="section">
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                    <div class="row">
                        <input type="hidden" name="module_id" value="{{ $data['moduleId'] }}" id="moduleId">
                        <input type="hidden" name="owner_id" value="{{ $data['ownerId'] }}" id="ownerId">
                        <div class="form-group col-lg-6">
                            <strong>{{ Form::label('add_comment', __('messages.comment.add_comment')) }}</strong>
                            <div id="commentContainer" class="quill-editor-container"></div>
                            <div class="text-left mt-3">
                                {{ Form::button(__('messages.common.save'), ['type'=>'button','class' => 'btn btn-primary','id'=>'btnComment','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                                <button type="reset" id="btnCancel" class="btn btn-light ml-1">
                                    {{ __('messages.common.cancel') }}
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-6 note-scroll">
                            <div class="comments">
                                <div>
                                    <div class="mb-3 d-flex">
                                        <span class="flex-1 ml-5 no_comments text-center @if(!($comments->isEmpty())) d-none @endif">{{ __('messages.comment.no_comments_added_yet') }}</span>
                                    </div>
                                </div>
                                <div class="activities">
                                    @foreach($comments as $comment)
                                        <div class="activity clearfix comments__information"
                                             id="{{ 'comment__'.$comment->id }}">
                                            <div class="activity-icon">
                                                <img class="user__img profile" width="50"
                                                     height="50"
                                                     src=" {{ $comment->user->image_url }}"
                                                     alt="User Image">
                                                <span class="user__username">
                                                            </span>
                                            </div>
                                            <div class="activity-detail col-xl-11 col-lg-10 pt-1 mb-3">
                                                <div
                                                        class="mb-0 d-flex justify-content-between flex-wrap">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        @php
                                                            $deletedUser = (isset($comment->user->deleted_at)) ? "<span class='user__deleted-user'>(deactivated user)</span>" : ''
                                                        @endphp
                                                        <span
                                                                class="font-weight-bold lead">{{ isset($comment->user->full_name) ? $comment->user->full_name . ' ' . $deletedUser : '' }}</span>
                                                        <span
                                                                class="text-job text-dark user__description ml-2">{{timeElapsedString($comment->created_at)}}</span>
                                                    </div>
                                                    <div>
                                                        @if($comment->added_by == getLoggedInUserId())
                                                            <a class="user__icons del-comment d-none task-comment-delete"
                                                               title="delete"
                                                               data-id="{{$comment->id}}"><i
                                                                        class="fas fa-trash ml-0 card-delete-icon"></i></a>
                                                            <a class="user__icons edit-comment d-none task-comment-edit"
                                                               title="edit"
                                                               data-id="{{$comment->id}}"><i
                                                                        class="fas fa-edit mr-2 card-edit-icon"></i>&nbsp;</a>
                                                            <a class="user__icons save-comment {{'comment-save-icon-'.$comment->id}} d-none task-comment-check"
                                                               data-id="{{$comment->id}}"><i
                                                                        class="far fa-check-circle text-success font-weight-bold hand-cursor card-save-icon"></i>&nbsp;&nbsp;</a>
                                                            <a class="user__icons cancel-comment {{'comment-cancel-icon-'.$comment->id}} d-none task-comment-cancel"
                                                               data-id="{{$comment->id}}"><i
                                                                        class="fas fa-times hand-cursor card-cancel-icon"></i>&nbsp;&nbsp;</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div
                                                        class="user__comment mt-2 @if($comment->added_by == getLoggedInUserId()) comment-display @endif {{'comment-display-'.$comment->id}}"
                                                        data-id="{{$comment->id}}">
                                                    {!! html_entity_decode($comment->description) !!}
                                                </div>
                                                @if($comment->added_by == getLoggedInUserId())
                                                    <div
                                                            class="user__comment d-none comment-edit {{'comment-edit-'.$comment->id}}">
                                                        <div id="commentEditContainer{{$comment->id}}"
                                                             class="quill-editor-container"></div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <div id="commentContainer" class="quill-editor-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        @include('reminders.templates.templates')
    </section>
@endsection
