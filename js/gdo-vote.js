"use strict";
$(function(){
	function likeBtnClick() {
		var id = urlParam('id', this.href);
		var gdo = urlParam('gdo', this.href).rsubstrFrom('\\');
		$.ajax({
			url: this.href+'&_ajax=1&_fmt=json',
			method: 'post',
		}).then(function(result){
			id = "." + gdo + "-" + id + "-likes";
			$(id).parent().replaceWith(result.json.likes.html);
			$(id).parent().click(likeBtnClick.bind($(id).parent().get(0)));
		}, function(error) {
			window.GDO.error(error.responseJSON);
		});
		return false;
	} 

	$('.gdt-like-button').each(function(btn) {
		$(this).click(likeBtnClick.bind(this));
	});
	
});
