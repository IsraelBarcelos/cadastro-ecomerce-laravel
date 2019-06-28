@extends('layout/app', ['current' => 'categorias'])

@section('title') Categorias @endsection
@section('body')
	<div class="text-center">Clique na categoria para ver produtos vinculados</div> 
	<div class="card border">
		<div class="card-body">
			<h5 class="card-title">Categorias</h5>

			<table class="table table-ordered table-hover">
				<thead>
					<tr>
						<th>Código</th>
						<th>Nome da Categoria</th>
						<th class="text-center">Ações</th>
					</tr>
				</thead>
				<tbody id="tbody">
			
				</tbody>
			</table>

		</div>

		<div class="card-footer text-center">
			<button class="btn btn-primary" onclick="abrirFormulario()">Adicionar Categorias</button>
		</div>
	</div>

	<div id="form" class="modal" tabindex="-1" role="dialog"><!-- Dialog criação de categorias -->
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	       			<h5 class="modal-title">Criar Categoria</h5>
	        		<button type="button" class="close" aria-label="Close">
	          			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
	      		<form id="addcat" class="form-group">
			      	<div class="modal-body">
			        	
			      		<input type="hidden" id="id">

			        	<div>
			        		<input id="categoria" class=" my-1 bg-dark text-white form-control" type="text" placeholder="Nome da categoria">
			        	</div>

			
			        
			      	</div>
			      	<div class="modal-footer">
			        	<button type="submit" class="btn btn-success">Salvar</button>
			        	<button type="cancel" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			      	</div>
	      		</form>
	    	</div>
	  	</div> 
	</div>



	<div id="show" class="modal" tabindex="-1" role="dialog"> <!-- Dialog Produtos de categorias -->
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	       			<h5 class="modal-title">Produtos da categoria</h5>
	        		<button type="button" class="close" aria-label="Close">
	          			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
	      		
			      	<div id="modal-body" class="modal-body">
			
			        
			      	</div>
			      	<div class="modal-footer">
			        	<button type="cancel" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			      	</div>
	    	</div>
	  	</div>
	</div>


	<div id="attach" class="modal" tabindex="-1" role="dialog"><!-- Dialog Attach de produtos -->
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	       			<h5 class="modal-title">Vincular categoria</h5>
	        		<button type="button" class="close" aria-label="Close">
	          			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
	      		<form id="attachproduto" class="form-group">
			      	<div class="modal-body">

			      		<input type="hidden" id="idAttach">

			        	<label class="text-center" id="categoriaUtilizada" ></label>
						<div class="form-check ml-4" id="check">

						</div>
			        
			      	</div>
			      	<div class="modal-footer">
			        	<button type="submit" class="btn btn-success">Salvar</button>
			        	<button type="cancel" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			      	</div>
	      		</form>
	    	</div>
	  	</div> 
	</div>

@endsection

@section('javascript')
	<script type="text/javascript">
		let count_produtos = 0
		$(function(){ //carrega a tabela ao final do programa
			carregarCategorias()			
		})

		function carregarCategorias(){ 
			$.get('api/categorias',function(dados){
				dados = JSON.parse(dados);
				console.log(dados)
				for(let i=0;i<dados.length;i++){
					montarLinha(dados[i])
				}
			}
		)}

		function montarLinha(objeto){ // monta a linha para cada elemento categoria


			let linha = '<tr><td class="font-weight-bold">'+objeto.id+'</td><td onclick="detalhes('+objeto.id+')" >'+objeto.categoria+
			'<span id="badge'+objeto.id+'" class="ml-2 text-right badge badge-primary badge-pill">'+objeto.produtos.length+'</span></td> <td class="text-center">'+
			'<button onclick="editar('+objeto.id+')" class="btn btn-warning">Editar</button>'+
			'<button class="mx-2 my-2 btn btn-danger" onclick="deletar('+objeto.id+')">Deletar</button>'+
			'<button class="btn btn-secondary" onclick="avancado('+objeto.id+')">Avançado</Button></td></tr>'
			$('#tbody').append(linha)
		}

		function abrirFormulario(){ // limpar formulario quando aberto
			$('#categoria').val('')
			$('#form').modal('show')
		}

		$('#addcat').submit(function(e){ // adicionar categoria quando clicado em submit
			e.preventDefault()
			if($('#id').val() == ''){
				criaCategoria()
			}else{
				editarCategoria($('#id').val())
			}
			$('#form').modal('hide')
		})

		function criaCategoria(){ // cria objeto a ser passado para o laravel
			let categoria = {
				categoria : $('#categoria').val()
			}

			$.post('api/categorias', categoria ,function(data){ // envia via post para o server
				data = JSON.parse(data)
				montarLinha(data)
			})
		}

		function editar(id){ //prepara formulario para update
			$('#id').val(id)
			$.get('/api/categorias/editar/'+id, function(data){
				data = JSON.parse(data)

				$('#categoria').val(data.categoria)
				$('#form').modal('show')
			})
		}

		function editarCategoria(id){ //req do update

			let categoria = {
				categoria : $('#categoria').val()
			}

			$.ajax({
			    url: '/api/categorias/'+id,
			    type: 'PUT',
			    data: categoria,
			    success: function(data) {
			    	data = JSON.parse(data)
			    	for(let i=0;i<$('#tbody>tr').length;i++){
			    		if($('#tbody>tr')[i].cells[0].innerText == data.id){
			    			$('#tbody>tr')[i].cells[1].innerHTML = data.categoria+ '<span id="badge'+data.id+'" class="ml-2 text-right badge badge-primary badge-pill">'+data.produtos.length+'</span>'
			    		}
			    	}       
			    }
			})
		}

		function deletar(id){
			$.ajax({
			    url: '/api/categorias/'+id,
			    type: 'DELETE',
			    success: function(data) {
			   		for(let i=0;i<$('#tbody>tr').length;i++){
			    		if($('#tbody>tr')[i].cells[0].innerText == id){
			    			$('#tbody>tr')[i].remove()
			    		}
			    	}
			    }
			})
		}


		function detalhes(id){ //recupera detalhes de um unico item e mostra para o usuario
			
			var elemento = document.getElementById('modal-body') //limpa o modal body
				while (elemento.firstChild) {
					elemento.removeChild(elemento.firstChild);
				}

			$.get('/api/categorias/editar/'+id, function(dados){

				dados = JSON.parse(dados)
				if(dados.produtos.length > 0){
					dados.produtos.forEach(function(dadosProduto){//cada dado deve apresentar 2 labels
						linha = '<ul class="ml-3 list-group">'+

						'<li class="list-group-item"><label class="mx-2">Nome do produto: </label>'+
						'<label class="font-weight-bold">'+dadosProduto.produto+'</label></li>'+

						'<li class="list-group-item"><label class="mx-2">Código do produto: </label>'+
						'<label class="font-weight-bold">'+dadosProduto.id+'</label></li>'+


						'<li class="list-group-item"><label class="mx-2">Valor do produto: </label>'+
						'<label class="font-weight-bold">'+dadosProduto.valor+'</label></li>'+


						'<li class="list-group-item"><label class="mx-2">Valor em estoque: </label>'+
						'<label class="font-weight-bold">'+dadosProduto.estoque+'</label></li>'+

						'</ul><hr>'

						$('#modal-body').append(linha)
					}) 
				}else{
					linha = '<label>Não há produtos vinculados à categoria</label>'
					$('#modal-body').append(linha)
				}
					
				})

			$('#show').modal('show')
		}

		function avancado(id){
			$('#idAttach').val(id)
			var elemento = document.getElementById('check') //limpa a div checkbox
				while (elemento.firstChild) {
					elemento.removeChild(elemento.firstChild);
				}

			$.get('/api/categorias/editar/'+id, function(dados){ //recebe a categoria sendo utilizada
				
				dados = JSON.parse(dados)
				document.getElementById('categoriaUtilizada').innerText = "Adicionando produtos à categoria "+dados.categoria

				$.get('/api/produtos',function(dadosProduto){//receber os produtos para colocar no $('#radio')
					dadosTodosProdutos = JSON.parse(dadosProduto)


					count_produtos = dadosTodosProdutos.length
					for(let i=0;i<dadosTodosProdutos.length;i++){ //traz todos os produtos do programa
						let limite = dados.produtos.length

						for(let j=0;j<dados.produtos.length;j++){ //traz os prdutos da categoria
							if(dados.produtos[j].produto == dadosTodosProdutos[i].produto){//se tem nome igual
								
								limite -= 1 //impede que seja criada mais de uma box para segundo caso negativo
							}
							
						}
						
						if(limite == dados.produtos.length){ //cria no caso negativo a box sem check

							let linhas = 
								'<input type="checkbox" value="'+dadosTodosProdutos[i].id+'" class="form-check-input" id="'+i+'">'+
								'<label class="form-check-label" for="'+dadosTodosProdutos[i].produto+'">'+dadosTodosProdutos[i].produto+'</label><br>'

								$('#check').append(linhas)
						}else{
							let linhas = 
								'<input type="checkbox" value="'+dadosTodosProdutos[i].id+'" checked class="form-check-input" id="'+i+'">'+
								'<label class="form-check-label" for="'+dadosTodosProdutos[i].produto+'">'+dadosTodosProdutos[i].produto+'</label><br>'

								$('#check').append(linhas)
						}
					}


				$('#attach').modal('show')
			})

			})
		}

		$('#attachproduto').submit(function(e){ // adicionar categoria quando clicado em submit
			e.preventDefault()
			reestruturaCategoria($('#idAttach').val())
			$('#attach').modal('hide')
		})

		function reestruturaCategoria(id){
			
			
			for(i=0;i<count_produtos;i++){
				if($('#'+i+'')[0].checked == true){

					let prodsEmCats = {
						idsprodutos : $('#'+i+'')[0].value
					}

					$.ajax({
				    url: 'api/categorias/reestruturar/'+id,
				    type: 'PUT',
				    data: prodsEmCats,
				    success: function(data) {
				    	data = JSON.parse(data)
				    	$('#badge'+data.id+'')[0].innerText = data.produtos.length
					    		     
					    },
					    error: 'ERRO'
					})
					
				}else{
					let prodsEmCats = {
						idsprodutos : $('#'+i+'')[0].value
					}

					$.ajax({
				    url: 'api/categorias/desestruturar/'+id,
				    type: 'PUT',
				    data: prodsEmCats,
				    success: function(data) {
				    	data = JSON.parse(data)
				    	$('#badge'+data.id+'')[0].innerText = data.produtos.length
					    		     
					    },
					    error: 'ERRO'
					})
					

					/**/	
				}
			}
		}
		
				



	</script>
@endsection