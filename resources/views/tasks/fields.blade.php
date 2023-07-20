 <script>
 $(document).ready(function(){

  // Adicionamos o evento onclick ao botão com o ID "pesquisar"
  $('#pesquisar').on('click', function(e) {
    
    // Apesar do botão estar com o type="button", é prudente chamar essa função para evitar algum comportamento indesejado
    e.preventDefault();
    
    // Aqui recuperamos o cnpj preenchido do campo e usamos uma expressão regular para limpar da string tudo aquilo que for diferente de números
    var cnpj = $('#cnpj').val().replace(/[^0-9]/g, '');
    
    // Fazemos uma verificação simples do cnpj confirmando se ele tem 14 caracteres
    if(cnpj.length == 14) {
    
      // Aqui rodamos o ajax para a url da API concatenando o número do CNPJ na url
      $.ajax({
        url:'https://www.receitaws.com.br/v1/cnpj/' + cnpj,
        method:'GET',
        dataType: 'jsonp', // Em requisições AJAX para outro domínio é necessário usar o formato "jsonp" que é o único aceito pelos navegadores por questão de segurança
        complete: function(xhr){
        
          // Aqui recuperamos o json retornado
          response = xhr.responseJSON;
          
          // Na documentação desta API tem esse campo status que retorna "OK" caso a consulta tenha sido efetuada com sucesso
          if(response.status == 'OK') {
          
            // Agora preenchemos os campos com os valores retornados
            $('#razao').val(response.nome);
            $('#nome').val(response.fantasia);
            $('#logradouro').val(response.logradouro);
          
          // Aqui exibimos uma mensagem caso tenha ocorrido algum erro
          } else {
            alert(response.message); // Neste caso estamos imprimindo a mensagem que a própria API retorna
          }
        }
      });
    
    // Tratativa para caso o CNPJ não tenha 14 caracteres
    } else {
      alert('CNPJ inválido');
    }
  });
});
 </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<div class="row">
<div class=" col-12 ">

<form id="formu">
        <p>Cadastro de Empresa</p>
    		<fieldset id="first">
    		    <div class="row">
    		       <div class="col-md-8">
    		        {{ Form::label('cnpj', __('CNPJ').':') }}
                    {{ Form::text('cnpj', null, ['class' => 'form-control','autocomplete' => 'off', 'onblur' => "Pesquisar(this.value)"]) }}
    		           
    		       </div>
               
    			<div class="col-md-4 mt-4">
    		 <input id="pesquisar" class="btn btn-outline-primary m-0 p-3" name="pesqui" value="Pesquisar"><!-- Aqui incluímos o id="pesquisar" para poder aplicar o evento pelo ID e mudamos o type para "button"-->
    		           
    		       </div>
    					
    			</div>		
    			{{ Form::label('razao', __('Razão social').':') }}
                {{ Form::text('razao', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    			
    			{{ Form::label('nome', __('Nome fantasia').':') }}
                {{ Form::text('nome_empresa', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    			
    			
    		</fieldset>
    		
</div>
  
    <div class="col-12">
     
        {{ Form::label('cep', __('cep').':') }}
        {{ Form::text('cep', null, ['class' => 'form-control', 'id' => 'cep', 'onblur' => "pesquisacep(this.value)"]) }}
    
        {{ Form::label('rua', __('rua').':') }}
        {{ Form::text('rua', null, ['class' => 'form-control', 'id' => 'rua']) }}
   
        {{ Form::label('bairro', __('bairro').':') }}
        {{ Form::text('bairro', null, ['class' => 'form-control', 'id' => 'bairro']) }}
    

    
        {{ Form::label('cidade', __('cidade').':') }}
        {{ Form::text('cidade', null, ['class' => 'form-control', 'id' => 'cidade']) }}
    

        {{ Form::label('uf', __('estado').':') }}
        {{ Form::text('uf', null, ['class' => 'form-control', 'id' => 'uf']) }}
        
        {{ Form::label('ibge', __('ibge').':') }}
        {{ Form::text('ibge', null, ['class' => 'form-control', 'id' => 'ibge']) }}
    
    </div>
        </div>
<div class="row">

    


<!--parte do cep-->
    <div class="form-group col-sm-6">
        {{ Form::label('cliente', __('Cliente').':') }}
        {{ Form::text('cliente', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div>
    
    <div class="form-group col-sm-6">
        {{ Form::label('subject', __('SKU').':') }}
        {{ Form::text('subject', null, ['class' => 'form-control', 'id' => '1234', 'required', 'onblur' => "pesquisacep(this.value);"]) }}
        <script type="text/javascript">
        var d = new Date();
        var elem = document.getElementById("1234"); 
        elem.value = d.toISOString().slice(0,36);
        </script>
        
    </div>


    <div class="form-group col-sm-6">
        {{ Form::label('member_id', __('Atendente inicial').':') }}
        {{ Form::select('member_id', $data['users'],isset($task->member_id)?$task->member_id:null, ['id'=>'memberId','class' => 'form-control', 'required','placeholder' => 'Selecione atendente']) }}
    </div>
 

    

    <div class="form-group col-sm-6"><!--teste3-->
        {{ Form::label('contato', __('contato').':') }}
        {{ Form::text('contato', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div><!--fim do teste3-->
    <div class="form-group col-6">
        {{ Form::label('email_1', __('Email cliente').':') }}
        {{ Form::text('email_1', null, ['class' => 'form-control', 'autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-6">
        {{ Form::label('email_2', __('email 2').':') }}
        {{ Form::text('email_2', null, ['class' => 'form-control', 'autocomplete' => 'off']) }}
    </div>
   

    <div class="form-group col-sm-6"><!--teste5-->
        {{ Form::label('telefone', __('telefone').':') }}
        {{ Form::text('telefone', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div><!--fim do teste5-->

    <div class="form-group col-sm-6"><!--teste6-->
        {{ Form::label('origem_indicacao', __('Nome de quem indicou').':') }}
        {{ Form::text('origem_indicacao', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div><!--fim do teste6-->

    <div class="form-group col-sm-6"><!--teste6-->
        {{ Form::label('produto', __('produto').':') }}
        {{ Form::text('produto', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div><!--fim do teste6-->

    <div class="form-group col-sm-6"><!--teste6-->
        {{ Form::label('m2', __('m2').':') }}
        {{ Form::text('m2', null, ['class' => 'form-control', 'autocomplete' => 'off']) }}
    </div><!--fim do teste6-->


     <div class="form-group col-sm-6"><!--teste6-->
        {{ Form::label('situacao', __('situação').':') }}
        {{ Form::text('situacao', null, ['class' => 'form-control', 'autocomplete' => 'off']) }}
    </div><!--fim do teste6-->
    

    <div class="form-group col-sm-6">
        {{ Form::label('fabricante', __('fabricante').':') }}
        {{ Form::select('fabricante', $data['fabricante'],null, ['id'=>'fabricanteId','class' => 'form-control','placeholder' => 'Select fabricante']) }}
    </div>


    <div class="form-group col-sm-6">
        {{ Form::label('hourly_rate', __('Valor').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="{{ getCurrencyClass() }}"></i>
                </div>
            </div>
            {{ Form::text('hourly_rate', null, ['class' => 'form-control price-input','autocomplete' => 'off']) }}
        </div>
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('start_date', __('Data d/inicio').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            {{ Form::text('start_date', null, ['class' => 'form-control','id' => 'startDate','autocomplete' => 'off']) }}
        </div>
    </div>
    
        <input type="hidden" name="status" value="{{ \App\Models\Task::NOT_STARTED_STATUS }}">
    
    <div class="form-group col-sm-6">
        {{ Form::label('due_date', __('data p/finalizar').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            {{ Form::text('due_date', null, ['class' => 'form-control','id' => 'dueDate','autocomplete' => 'off']) }}
        </div>
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('priority', __('Origem').':') }}
        {{ Form::select('priority', $data['priority'],null, ['id'=>'priorityId','class' => 'form-control', 'required','placeholder' => 'Select Priority']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('consultor', __('Responsavel por alimentar').':') }}
        {{ Form::select('consultor', $data['users'],isset($task->first_name)?$task->first_name:null, ['id'=>'first_name','class' => 'form-control','placeholder' => 'Selecione o consultor']) }}
    </div>
    <div class="form-group col-sm-6"><!--teste6-->
        {{ Form::label('valor', __('consultor').':') }}
        {{ Form::text('valor', null, ['class' => 'form-control', 'autocomplete' => 'off']) }}
    </div><!--fim do teste6-->
    
        <div class="form-group col-sm-6">
            {{ Form::label('status', __('messages.task.status').':') }}
            {{ Form::select('status', $data['status'],null, ['id'=>'statusId','class' => 'form-control','placeholder' => 'Select Status','required']) }}
        </div>
    
    <div class="form-group col-sm-6">
        {{ Form::label('related_to', __('Relacionado').':') }}
        {{ Form::select('related_to', $data['relatedTo'], isset($relatedTo) ? array_search($relatedTo, $data['relatedTo']) : null, ['id'=>'relatedToId','class' => 'form-control','placeholder' => 'Select Option']) }}
    </div>
    <div class="form-group col-sm-6 display-none" id="relatedToForm">
        {{ Form::label('owner_label', null,['id' => 'ownerLabel']) }}
        {{ Form::select('owner_id', (isset($owner)?$owner:[]),null, ['id'=>'ownerId','class' => 'form-control owner','placeholder' => 'Select Option']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('produtos', __('produtos').':') }}
        <div class="input-group">
            {{ Form::select('tags[]', $data['tags'],isset($task->tags)?$task->tags:null, ['id'=>'tagId','class' => 'form-control','multiple']) }}
            <div class="input-group-append plus-icon-height">
                <div class="input-group-text">
                    <a href="#" data-toggle="modal" data-target="#addCommonTagModal"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group col-sm-12 mb-0">
        {{ Form::label('description', __('descrição').':') }}
        {{ Form::textarea('description', null, ['class' => 'form-control','id' => 'taskDescription']) }}
    </div>
</div>
<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary', 'id' => 'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
        <a href="{{ url()->previous() }}" class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
    </div>
</div>

 <script>
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
            document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
            document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";
                document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>