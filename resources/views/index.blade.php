@extends('layout/app', ['current' => 'home'])

@section('body')
	<div class="jumbotron bg-light border border-secondary">
		<div class="row">
			<div class="card-deck">


				<div class="card border border-primary">
					<div class="card-body">
						<h5 class="card-title">Cadastro de produtos</h5>
						<p class="card-text">Aqui você cadastra seus categorias.</p>
						<br>
						<a href="/categorias" class="btn btn-primary">Cadastre suas Categorias</a>
					</div>
				</div>

				<div class="card border border-primary">
					<div class="card-body">
						<h5 class="card-title">Cadastro de categorias</h5>
						<p class="card-text">Aqui você cadastra seus produtos.
						Porém não esqueça de cadastrar previamente a categoria dele!</p>
						<a href="/produtos" class="btn btn-primary">Cadastre seus Produtos</a>
					</div>
				</div>


			</div>
		</div>
	</div>
@endsection