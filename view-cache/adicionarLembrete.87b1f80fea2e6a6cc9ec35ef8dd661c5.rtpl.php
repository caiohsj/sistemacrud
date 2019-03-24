<?php if(!class_exists('Rain\Tpl')){exit;}?>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<table class="table mt-4">
					  <thead class="thead-dark">
					    <tr>
					      <th scope="col" colspan="3">Adicionar Lembrete</a></th>
					    </tr>
					  </thead>
				</table>
				<form method="post" action="/adicionar">
					<div class="form-group row">
					    <label for="inputDescricao" class="col-sm-2 col-form-label">Descricao</label>
					    <div class="col-sm-8">
					    	<textarea type="text" name="descricao" class="form-control" id="inputDescricao" placeholder="Digite aqui a descricao do seu lembrete"></textarea>
					    </div>
						<div class="col-sm-1">
					    	<input type="submit" class="btn btn-primary" value="Salvar">
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>