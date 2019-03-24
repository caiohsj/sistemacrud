<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<form method="post" action="/cadastro">
					<h2 class="mb-3 mt-4">Cadastro</h2>
					<div class="form-group row">
					    <label for="inputNome" class="col-sm-1 col-form-label">Nome</label>
					    <div class="col-sm-8">
					    	<input type="text" name="nome" class="form-control" id="inputNome" placeholder="Nome Completo" value="<?php echo htmlspecialchars( $registerValues["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
					    </div>
					</div>

					<?php if( $erro != '' ){ ?>
					<div class="alert alert-danger" role="alert">
					  <?php echo htmlspecialchars( $erro, ENT_COMPAT, 'UTF-8', FALSE ); ?>
					</div>
					<?php } ?>

					<div class="form-group row">
					    <label for="inputEmail" class="col-sm-1 col-form-label">Email</label>
					    <div class="col-sm-8">
					    	<input type="email" name="email" class="form-control" id="inputEmail" placeholder="exemplo@email.com" value="<?php echo htmlspecialchars( $registerValues["email"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
					    </div>
					</div>
					<div class="form-group row">
					    <label for="inputSenha" class="col-sm-1 col-form-label">Senha</label>
					    <div class="col-sm-8">
					    	<input type="password" name="senha" class="form-control" id="inputSenhaPassword3" placeholder="Digite aqui sua senha">
					    </div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10">
					    	<input type="submit" class="btn btn-primary" value="Salvar">
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>
</body>
</html>