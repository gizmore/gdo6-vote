"use strict";
$(function(){
	function likeBtnClick() {
		var id = urlParam('id', this.href);
		var gdo = urlParam('gdo', this.href).rsubstrFrom('\\');
		$.get(this.href+'&ajax=1&fmt=json').then(function(result){
			var count = result.likes.count;
			id = "." + gdo + "-" + id + "-likes b";
			$(id).text(count);
		}, function(error) {
			window.GDO.error(error.responseText);
		});
		return false;
	} 

	$('.gdt-like-button').each(function(btn) {
		$(this).click(likeBtnClick.bind(this));
	});
});
