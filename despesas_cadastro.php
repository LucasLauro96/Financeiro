<?php

require_once 'assets/include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$conexao = new conexao();
$con = $conexao->conecta();

$pageActive = 'despesas';

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<title>Sistema Administrativo</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0'>
	<!-- Main CSS-->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!-- Font-icon css-->
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Favicon -->
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<link rel="icon" href="../favicon.ico" type="image/x-icon">
	<!-- Page specific css -->
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css">
</head>

<body class="app sidebar-mini rtl">

	<?php include_once "header.php"; ?>

	<main class="app-content">

		<div class="row">
			<div class="col-md-12">
				<div class="tile">
					<div class="tile-title-w-btn">
						<h3 class="title"><i class="fa fa-pencil"></i><?= empty($_GET['CodDespesa']) ? '  Novo Produto' : '  Atualiza Produto' ?></h3>
						<p>
							<a href="despesas_consulta.php" class="btn btn-danger icon-btn">
								<i class="fa fa-ban"></i> Cancelar
							</a>
						</p>
					</div>
					<div class="tile-body">
						<form id="formCadastro" enctype="multipart/form-data">
							<div class="form-row">
								<div class="form-group col-9">
									<label for="Valor">VALOR</label>
									<input type="text" name="Valor" id="Valor" class="form-control mask-valor" required>
								</div>
								<div class="form-group col-3">
									<label for="DataDespesa">DATA</label>
									<input type="date" name="DataDespesa" id="DataDespesa" class="form-control" required>
								</div>
								<div class="form-group col-12">
									<label for="Descricao">DESCRIÇÃO</label>
									<textarea name="Descricao" id="Descricao" class="form-control" rows="6"></textarea>
								</div>
								<div class="col-md-12">
									<button type="submit" name="salvar" id="salvar" class="btn btn-primary d-block mx-auto mt-3"><i class="fa fa-save"></i> SALVAR</button>
								</div>
							</div>
							<input type="hidden" name="CodDespesa" id="CodDespesa">
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>
	<!-- Essential javascripts for application to work-->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/jquery.mask.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<!-- The javascript plugin to display page loading on top-->
	<script src="js/plugins/pace.min.js"></script>
	<!-- Page specific javascripts-->
	<script src="js/plugins/jquery.validate.js"></script>
	<script src="js/plugins/jquery.fancybox.min.js"></script>
	<script>
		$('#formCadastro').validate({
			errorClass: 'is-invalid',
			validClass: 'is-valid',
			errorPlacement: function() {
				return false; //REMOVER MENSAGENS
			},
			submitHandler: function(form) {
				$('#salvar').html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> SALVANDO...').attr('disabled', '');

				var formData = new FormData($('#formCadastro')[0]);
				var option = $('#CodDespesa').val() == '' ? 'insert' : 'update';

				$.ajax({
					type: 'POST',
					url: 'ajax/despesa.php?option=' + option,
					data: formData,
					processData: false,
					contentType: false
				}).done(function() {
					//window.location.href = 'despesa_consulta.php';
				});
			}
		});

		<?php if (isset($_GET['CodDespesa']) && !empty($_GET['CodDespesa'])) { ?>
			$.post('ajax/despesa.php?option=select', {CodDespesa: <?= $_GET['CodDespesa']?>})
				.done(function(response) {
					response = JSON.parse(response);

					$('#DataDespesa').val(response.DataDespesa);
					$('#Descricao').val(response.Descricao);
					$('#Valor').val(response.Valor);
				});
		<?php } ?>
	</script>

</body>

</html>