(function () {
	"use strict";

	var treeviewMenu = $('.app-menu');

	// Toggle Sidebar
	$('[data-toggle="sidebar"]').click(function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});

	// Activate sidebar treeview toggle
	$("[data-toggle='treeview']").click(function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

	// Set initial active toggle
	$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

	//Activate bootstrip tooltips
	$("[data-toggle='tooltip']").tooltip();

})();

$(document).ready(function(){
	//ACTIVE DA PÁGINA ATUAL
	var pagina_atual = location.pathname.split('/')[2].split('_')[0];
	if(pagina_atual != ''){
		$('.app-menu a[href^="' + pagina_atual + '"]').addClass('active');
		$('.app-menu a[href^="' + pagina_atual + '"]').closest('.treeview').addClass('is-expanded');
	}
	else
	{
		$('.app-menu a[href^="index.php"]').addClass('active');
		$('.app-menu a[href^="index.php"]').closest('.treeview').addClass('is-expanded');
	}
});