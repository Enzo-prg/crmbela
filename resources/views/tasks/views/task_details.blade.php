@extends('tasks.show')
@section('section')
    <div class="row">
        @if(!empty($task->public))
            <div class="form-group col-6 col-sm-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                           id="customCheck"
                           name="public" value="1"
                           {{ (isset($task) && $task->public == 1) ? 'checked' : '' }} disabled>
                    <label class="custom-control-label"
                           for="customCheck">{{__('messages.task.public')}}</label>
                </div>
            </div>
        @endif
        @if(!empty($task->billable))
            <div class="form-group col-6 col-sm-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                           id="customCheck1"
                           name="billable" value="1"
                           {{ (isset($task) && $task->billable == 1) ? 'checked' : '' }} disabled>
                    <label class="custom-control-label"
                           for="customCheck1">{{__('messages.task.billable')}}</label>
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            {{ Form::label('cliente', __('Cliente').':') }}
            <p>{{ html_entity_decode($task->cliente) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('valor', __('Consultor').':') }}
            <p>{{ html_entity_decode($task->valor) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('contato', __('Contato').':') }}
            <p>{{ html_entity_decode($task->contato) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('email_1', __('e-mail Cliente').':') }}
            <p>{{ html_entity_decode($task->email_1) }}</p>
        </div>
        <!--endereço começo-->
        <div class="form-group col-sm-4">
            {{ Form::label('cep', __('Cep').':') }}
            <p>{{ html_entity_decode($task->cep) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('bairro', __('Bairro').':') }}
            <p>{{ html_entity_decode($task->bairro) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('rua', __('Rua').':') }}
            <p>{{ html_entity_decode($task->rua) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('cidade', __('Cidade').':') }}
            <p>{{ html_entity_decode($task->cidade) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('uf', __('Uf').':') }}
            <p>{{ html_entity_decode($task->uf) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('cnpj', __('cnpj').':') }}
            <p>{{ html_entity_decode($task->cnpj) }}</p>
        </div>
        <!--fim dos endereços-->
        <div class="form-group col-sm-4">
            {{ Form::label('telefone', __('Telefone').':') }}
            <p>{{ html_entity_decode($task->telefone) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('atendente', __('Atendente').':') }}
            <p><a href="{{ url('admin/members',$task->member_id) }}"
                       class="anchor-underline">{{ html_entity_decode($task->user->full_name) }}</a></p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('origem_indicacao', __('Origem indicacao').':') }}
            <p>{{ html_entity_decode($task->telefone) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('fabricante', __('Fabricante').':') }}
            <p>{{ isset($task->fabricante)?\App\Models\Task::FABRICANTE[$task->fabricante]: __('n/a') }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('produto', __('Produto').':') }}
            <p>{{ html_entity_decode($task->produto) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('m2', __('M2').':') }}
            <p>{{ html_entity_decode($task->m2) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('valor', __('Valor').':') }}
            <p>{{ html_entity_decode($task->hourly_rate) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('situacao', __('Situação').':') }}
            <p>{{ html_entity_decode($task->situacao) }}</p>
        </div>
        <div class="form-group col-sm-4 d-none">
            {{ Form::label('hourly_rate', __('messages.task.hourly_rate').':') }}
            @if(isset($task->hourly_rate))
                <p><i class="{{getCurrencyClass()}}"></i> {{$task->hourly_rate}}</p>
            @else
                <p>{{ __('messages.common.n/a') }}</p>
            @endif
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('start_date', __('Data d/inicio').':') }}
            <p>{{ isset($task->start_date) ? (date('jS M, Y H:i A', strtotime($task->start_date))) : __('messages.common.n/a') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            {{ Form::label('due_date', __('Data p/finalizar').':') }}
            @if(isset($task->due_date))
                <p>{{ date('jS M, Y H:i A', strtotime($task->due_date)) }}</p>
            @else
                <p>{{ __('messages.common.n/a') }}</p>
            @endif
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('priority', __('Origem').':') }}
            <p>{{ isset($task->priority)?\App\Models\Task::PRIORITY[$task->priority]: __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('status', __('messages.task.status').':') }}
            <p>{{ isset($task->status)?\App\Models\Task::STATUS[$task->status]: __('messages.common.n/a') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            {{ Form::label('tags', __('messages.tags').':') }}
            <p>
                @forelse($task->tags as $tag)
                    <span class="badge border border-secondary mb-1">{{ html_entity_decode($tag->name) }}</span>
                @empty
                    {{ __('messages.common.n/a') }}
                @endforelse
            </p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('related_to', __('messages.task.related_to').':') }}
            <p>{{ isset($task->related_to)?\App\Models\Task::RELATED_TO_array[$task->related_to]: __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-sm-4">
            @if($task->owner_type == \App\Models\Invoice::class)
                {{ Form::label('owner_type', __('messages.contact.invoice').':') }}
                <p>
                    <a href="{{ url('admin/invoices/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'title')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Customer::class)
                {{ Form::label('owner_type', __('messages.invoice.customer').':') }}
                <p>
                    <a href="{{ url('admin/customers/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'company_name')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Ticket::class)
                {{ Form::label('owner_type', __('messages.task.ticket').':') }}
                <p>
                    <a href="{{ url('admin/tickets/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'subject')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Project::class)
                {{ Form::label('owner_type', __('messages.contact.project').':') }}
                <p>
                    <a href="{{ url('admin/projects/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'project_name')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Proposal::class)
                {{ Form::label('owner_type', __('messages.proposal.proposal').':') }}
                <p>
                    <a href="{{ url('admin/proposals/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'title')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Estimate::class)
                {{ Form::label('owner_type', __('messages.estimate.estimate').':') }}
                <p>
                    <a href="{{ url('admin/estimates/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'title')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Lead::class)
                {{ Form::label('owner_type', __('messages.proposal.lead').':') }}
                <p>
                    <a href="{{ url('admin/leads/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'name')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Contract::class)
                {{ Form::label('owner_type', __('messages.contact.contract').':') }}
                <p>
                    <a href="{{ url('admin/contracts/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'subject')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @endif
        </div>
        
        <div class="form-group col-sm-4">
            {{ Form::label('created_at', __('Criado em').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($task->created_at)) }}">{{ $task->created_at->diffForHumans() }}</span>
            </p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('updated_at', __('Ultima atualização').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($task->updated_at)) }}">{{ $task->updated_at->diffForHumans() }}</span>
            </p>
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('description', __('Descrição').':') }}
            <br>
            {!! $task->description!=null ? html_entity_decode($task->description) : __('messages.common.n/a') !!}
        </div>
    </div>
@endsection
