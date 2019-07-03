@extends('layout/app', ["current" => "produtos"])

@section('body')
<div class="text-center">Clique no produto para ver categorias vinculadas</div> 
<div class="card border">
	<div class="card-body">
		<h5 class="card-title">Produtos</h5>

		<table class="table table-ordered table-hover">
			<thead>
				<tr>
					<th>Código</th>
					<th>Nome do Produto</th>
					<th>Estoque</th>
					<th>Valor</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody id="tbody">


			</tbody>
		</table>

	</div>
	<div class="card-footer text-center">
		<button class="btn btn-primary" onclick="abrirFormulario()"> Cadastrar Produto</button>
	</div>
</div>





<div id="form" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Criar Produto</h5>
				<button type="cancel" class="close" aria-label="Close">
					<span data-dismiss="modal" aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="addprod" class="form-group">
				<div class="modal-body">

					<input type="hidden" id="id">

					<div class="input-group">
						<div class="input-group-prepend">
							<label class="input-group-text form-control form-control-sm" id="labelproduto">Produto</label>
						</div>
						<input class="form-control form-control-sm mb-2" id="produto" type="text" placeholder="Digite o nome do produto">
					</div>

					<div class="input-group">
						<div class="input-group-prepend">

							<label class="input-group-text form-control form-control-sm" id="labelvalor">R$</label>
						</div>
						<input class="form-control form-control-sm mb-2" id="valor" type="number" placeholder="Digite o valor do produto">
					</div>

					<div class="input-group">
						<div class="input-group-prepend">

							<label class="input-group-text form-control form-control-sm" id="labelestoque">Estoque</label>
						</div>
						<input class="form-control form-control-sm mb-2" id="estoque" type="number" placeholder="Numero em estoque">
					</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Salvar</button>
					<button type="cancel" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
			</form>
		</div>
	</div><!-- menu de adicao -->
</div>



<div id="show" class="modal" tabindex="-1" role="dialog"> <!-- Dialog categoria de produtos -->
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Categoria dos produtos</h5>
				<button data-dismiss="modal" type="button" class="close" aria-label="Close">
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
					<span data-dismiss="modal" aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="attachcategoria" class="form-group">
				<div class="modal-body">

					<input type="hidden" id="idAttach">

					<label class="text-center" id="produtoUtilizado" ></label>
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
		$(function(){ //carrega a tabela ao final do programa
			carregarProdutos()
		})

		function carregarProdutos(){
			$.get('api/produtos',function(dados){
				dados = JSON.parse(dados);
				for(let i=0;i<dados.length;i++){
					montarLinha(dados[i])
				}
			}
			)}

		function montarLinha(objeto){ // monta a linha para cada elemento produto
			
			let linha = '<tr><td>'+objeto.id+'</td> <td onclick="detalhes('+objeto.id+')" >'+objeto.produto+'<span id="clique" class="text-danger"></span><span id="badge'+objeto.id+'" class="ml-2 text-right badge badge-primary badge-pill">'+objeto.categorias.length+
			'</span></td> <td>'+objeto.estoque+'</td>'+
			'<td>'+objeto.valor+
			'</td> <td class="text-center">'+
			'<button onclick="editar('+objeto.id+')" class="mr-2 btn btn-warning">Editar</button>'+
			'<button class="btn btn-danger mx-2 my-2" onclick="deletar('+objeto.id+')">Deletar</button> '+
			'<button class="btn btn-secondary" onclick="avancado('+objeto.id+')">Avançado</Button></td></tr>'
			$('#tbody').append(linha)
		}


		function abrirFormulario(){ // limpar formulario quando aberto
			$('#produto').val('')
			$('#id').val('')
			$('#estoque').val('')
			$('#valor').val('')
			$('#form').modal('show')
		}

		$('#addprod').submit(function(e){ // adicionar produto quando clicado em submit
			e.preventDefault()
			if($('#id').val() == ''){
				criaProduto()
			}else{
				editarProduto($('#id').val())
			}
			$('#form').modal('hide')
		})

		function criaProduto(){ // cria objeto a ser passado para o laravel
			let produto = {
				produto : $('#produto').val(),
				valor : $('#valor').val(),
				estoque : $('#estoque').val()
			}

			$.post('api/produtos', produto ,function(data){ // envia via post para o server
				data = JSON.parse(data)
				montarLinha(data)
			})
		}

		function editar(id){ //prepara formulario para update
			$('#id').val(id)
			$.get('/api/produtos/editar/'+id, function(data){
				data = JSON.parse(data)

				$('#produto').val(data.produto)
				$('#valor').val(data.valor)
				$('#estoque').val(data.estoque)

				$('#form').modal('show')
			})
		}

		function editarProduto(id){ //req do update

			let produto = {
				produto : $('#produto').val(),
				valor : $('#valor').val(),
				estoque : $('#estoque').val()
			}

			$.ajax({
				url: '/api/produtos/'+id,
				type: 'PUT',
				data: produto,
				success: function(data) {
					data = JSON.parse(data)
					for(let i=0;i<$('#tbody>tr').length;i++){
						if($('#tbody>tr')[i].cells[0].innerText == data.id){
							$('#tbody>tr')[i].cells[1].innerHTML = data.produto+ '<span id="badge'+data.id+'" class="ml-2 text-right badge badge-primary badge-pill">'+data.categorias.length+'</span>'
							$('#tbody>tr')[i].cells[2].innerText = data.estoque
							$('#tbody>tr')[i].cells[3].innerText = data.valor
						}
					}       
				}
			})
		}



		function deletar(id){
			$.ajax({
				url: '/api/produtos/'+id,
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

			$.get('/api/produtos/editar/'+id, function(dados){

				dados = JSON.parse(dados)
				if(dados.categorias.length > 0){
					let cabecalho = '<div class=" h2 font-weight-bold text-center mx-2">Categorias: </div>'
					$('#modal-body').append(cabecalho)
					dados.categorias.forEach(function(dadosCategoria){//cada dado deve apresentar 2 labels
						linha = '<ul class="ml-3 list-group">'+

						'<li class="list-group-item">'+

						'<div class="text-primary text-center font-weight-bold">'+dadosCategoria.categoria+
						
						'</div></li></ul><hr>'

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

			$.get('/api/produtos/editar/'+id, function(dados){ //recebe o produto sendo utilizado
				
				dados = JSON.parse(dados)
				document.getElementById('produtoUtilizado').innerHTML = "Adicionando categorias ao produto"+
				"<b class='text-primary'> "+dados.produto+"</b>"

				$.get('/api/categorias',function(dadosCategoria){//receber as categorias para colocar no $('#radio')
					dadosTodasCategorias = JSON.parse(dadosCategoria)


					count_categorias = dadosTodasCategorias.length
					for(let i=0;i<dadosTodasCategorias.length;i++){ //traz todos as categorias do programa
						let limite = dados.categorias.length

						for(let j=0;j<dados.categorias.length;j++){ //traz as categorias do produto
							if(dados.categorias[j].categoria == dadosTodasCategorias[i].categoria){//se tem nome igual
								
								limite -= 1 //impede que seja criada mais de uma box para segundo caso negativo
							}
							
						}
						
						if(limite == dados.categorias.length){ //cria no caso negativo a box sem check

							let linhas = 
							'<input type="checkbox" value="'+dadosTodasCategorias[i].id+'" class="form-check-input" id="'+i+'">'+
							'<label class="form-check-label" for="'+dadosTodasCategorias[i].categoria+'">'+dadosTodasCategorias[i].categoria+'</label><br>'

							$('#check').append(linhas)
						}else{
							let linhas = 
							'<input type="checkbox" value="'+dadosTodasCategorias[i].id+'" checked class="form-check-input" id="'+i+'">'+
							'<label class="form-check-label" for="'+dadosTodasCategorias[i].categoria+'">'+dadosTodasCategorias[i].categoria+'</label><br>'

							$('#check').append(linhas)
						}
					}


					$('#attach').modal('show')
				})

			})
		}

		$('#attachcategoria').submit(function(e){ // adicionar categoria quando clicado em submit
			e.preventDefault()
			reestruturaProduto($('#idAttach').val())
			$('#attach').modal('hide')
		})

		function reestruturaProduto(id){

			

			
			opcaoUsuario = []

			for(let i=0;i<count_categorias;i++){ //para cada categoria
				if($('#'+i)[0].checked == true){ //se estiver marcada
					
					opcaoUsuario.push($('#'+i)[0].value)
					
				}
			}

			console.log(opcaoUsuario)


			$.ajax({
				url: 'api/produtos/reestruturar/'+id,
				type: 'get',
				data: {idscategorias:opcaoUsuario},
				success: function(data) {
					data = JSON.parse(data)
					console.log(data)
				    	$('#badge'+data.id+'')[0].innerText = data.categorias.length

				    },
				    error:
				    $.get('api/produtos/editar/'+id, function(data){
				    	data = JSON.parse(data)
				    	$('#badge'+data.id+'')[0].innerText = data.categorias.length
				    })
				})

		}

	</script>
	@endsection