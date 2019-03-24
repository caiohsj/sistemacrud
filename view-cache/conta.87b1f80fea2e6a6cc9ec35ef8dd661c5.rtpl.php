<?php if(!class_exists('Rain\Tpl')){exit;}?>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<table class="table mt-4 border">
					  <thead class="thead-dark">
					    <tr>
					      <th scope="col" colspan="3">Seus Lembretes <a href="/adicionar">+</a></th>
					    </tr>
					  </thead>
					  <tbody>

					  	<?php $counter1=-1;  if( isset($lembretes) && ( is_array($lembretes) || $lembretes instanceof Traversable ) && sizeof($lembretes) ) foreach( $lembretes as $key1 => $value1 ){ $counter1++; ?>
					    <tr class="row">
					      <td class="col-md-9 ml-1"><?php echo htmlspecialchars( $value1["descricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
					      <td class="col-md-1"><a href="/lembrete/<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">Editar</a></td>
					      <td class="col-md-1"><a href="/lembrete/<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/excluir" onclick="return confirm('Deseja realmente excluir este registro?')">Excluir</a></td>
					    </tr>
					    <?php } ?>
					    
					    <?php if( $lembretes == '' ){ ?>
					    <tr class="row">
					    	<td class="col-md-2"></td>
					     	<td class="col-md-10">Clique no botao +, que está acima, para adicionar um lembrete</td>
					    </tr>
					    <?php } ?>

					  </tbody>
				</table>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>