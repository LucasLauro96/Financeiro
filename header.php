<!-- SAIR -->
<form method="post" class="sr-only">
	<input type="submit" name="sair" id="sair">
</form>
<?php
if(isset($_POST['sair']))
	$autenticacao->encerra_sessao();
?>
<!--/ SAIR -->

<!-- Navbar-->
<header class="app-header"><a class="app-header__logo d-none" href="index.php">Vali</a>
	<!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
	<!-- Navbar Right Menu-->
	<label for="sair" class="text-white mt-3 ml-auto" style="cursor: pointer;"><i class="fa fa-sign-out fa-lg"></i></label>
</header>
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
	<div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
		<div>
			<p class="app-sidebar__user-name"><?= $_SESSION['Nome'] ?></p>
			<p class="app-sidebar__user-designation">Administrador</p>
		</div>
	</div>
	<ul class="app-menu">
		<li><a class="app-menu__item" href="index.php" data-active="index"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
		<li><a class="app-menu__item" href="despesas_consulta.php" data-active="despesas"><i class="app-menu__icon fa fa-circle-o"></i><span class="app-menu__label">Despesas</span></a></li>
		<li><a class="app-menu__item" href="banco_consulta.php" data-active="banco"><i class="app-menu__icon fa fa-circle-o"></i><span class="app-menu__label">Bancos</span></a></li>
	</ul>
</aside>

<!-- ACTIVE DO MENU (main.js) -->
<script>
	var paginaAtual = '<?= isset($pageActive) ? $pageActive : '' ?>';
</script>