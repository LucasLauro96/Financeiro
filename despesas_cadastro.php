<?php

require_once 'assets/include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$conexao = new conexao();
$con = $conexao->conecta();

$pageActive = 'despesas';

if(isset($_GET['CodProduto']) && !empty($_GET['CodProduto'])){
	$query = $con->prepare('SELECT * FROM tb_produto WHERE CodProduto = :CodProduto');
	$query->bindValue(':CodProduto', $conexao->injection_paginacao($_GET['CodProduto']));
	$query->execute();
	$res = $query->fetch(PDO::FETCH_OBJ);
}

$CodProduto = isset($res->CodProduto) ? $res->CodProduto : null;
$Titulo = isset($res->Titulo) ? $res->Titulo : null;
$Ativo = isset($res->Ativo) ? $res->Ativo : null;
$Imagem = isset($res->Imagem) ? $res->Imagem : null;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title>Sistema Administrativo</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0'>
	<!-- Main CSS-->
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<!-- Font-icon css-->
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Favicon -->
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<link rel="icon" href="../favicon.ico" type="image/x-icon">
	<!-- Page specific css -->
	<link rel="stylesheet" type="text/css" href="assets/css/jquery.fancybox.min.css">
</head>
<body class="app sidebar-mini rtl">

	<?php include_once "header.php"; ?>

	<main class="app-content">

		<div class="row">
			<div class="col-md-12">
				<div class="tile">
					<div class="tile-title-w-btn">
						<h3 class="title"><i class="fa fa-pencil"></i><?= empty($_GET['CodProduto']) ? '  Novo Produto' : '  Atualiza Produto' ?></h3>
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
									<label for="Nome">TITULO PRODUTO</label>
									<input type="text" name="Titulo" id="Titulo" class="form-control" maxlength="255" required value="<?= $Titulo ?>">
								</div>
								<div class="form-group col-3">
									<label for="Ativo">ATIVO</label>
									<select name="Ativo" id="Ativo" class="form-control" required>
										<option value=""></option>
										<option value="1" <?= $Ativo == 1 ? 'selected' : '' ?>>Ativo</option>
										<option value="0" <?= $Ativo == 0 ? 'selected' : '' ?>>Inativo</option>
									</select>
								</div>
								<div class="form-group col-12">
									<label for="Imagens">FOTO</label>
									<input type="file" name="Imagem" id="Imagem" class="form-control" accept="image/*">
									<small>Recomendado: 450x300</small>
								</div>
								<div class="col-md-12">
									<button type="button" name="salvar" id="salvar" class="btn btn-primary d-block mx-auto mt-3"><i class="fa fa-save"></i> SALVAR</button>
								</div>
							</div>
							<input type="hidden" name="CodProduto" id="CodProduto" value="<?= $CodProduto ?>">
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php if(isset($Imagem)){ ?>
			<div class="row">
				<div class="col-md-12">
					<div class="tile">
						<div class="tile-title-w-btn">
							<h3 class="title"><i class="fa fa-picture-o"></i> Imagem</h3>
						</div>
						<div class="tile-body">
							<div class="row">
								<div class="col-md-3 mt-4">
									<div class="card">
										<a href="../assets/img/produto/<?= $res->Imagem ?>" data-fancybox="gallery"><img src="../assets/img/produto/<?= $res->Imagem ?>" class="img-card-top img-fluid"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</main>
	<!-- Essential javascripts for application to work-->
	<script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/main.js"></script>
	<!-- The javascript plugin to display page loading on top-->
	<script src="assets/js/plugins/pace.min.js"></script>
	<!-- Page specific javascripts-->
	<script src="assets/js/plugins/jquery.validate.js"></script>
	<script src="assets/js/plugins/jquery.fancybox.min.js"></script>
	<script>
		$('#formCadastro').validate({
			errorClass: 'is-invalid',
			validClass: 'is-valid',
			errorPlacement: function(){
				$('#salvar').html('<i class="fa fa-save"></i> SALVAR').removeAttr('disabled');
				return false;//REMOVER MENSAGENS
			},
			submitHandler: function(form){
				var formData = new FormData($('#formCadastro')[0]);
				var option = $('#CodProduto').val() == '' ? 'insert' : 'update';

				$.ajax({
					type: 'POST',
					url: 'ajax/produto.php?option='+option,
					data: formData ,
					processData: false,
					contentType: false
				}).done(function(){
					window.location.href = 'produto_consulta.php';
				});
			}
		});

		$('#salvar').click(function(){
			$(this).html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> SALVANDO...').attr('disabled', 'disabled');
			$(this).parents('form').submit();
		});
	</script>

</body>
</html>
