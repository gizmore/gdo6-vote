"use strict";
$(function(){
	function likeBtnClick() {
		var id = urlParam('id', this.href);
		var gdo = urlParam('gdo', this.href).rsubstrFrom('\\');
		$.ajax({
			url: this.href+'&ajax=1&fmt=json',
			method: 'post',
		}).then(function(result){
			id = "." + gdo + "-" + id + "-likes";
			$(id).parent().replaceWith(result.data.likes.html);
			$(id).parent().click(likeBtnClick.bind($(id).parent().get(0)));
//			var count = result.data.likes.count;
//			id = "." + gdo + "-" + id + "-likes b";
//			$(id).text(count);
		}, function(error) {
			window.GDO.error(error.responseJSON);
		});
		return false;
	} 

	$('.gdt-like-button').each(function(btn) {
		$(this).click(likeBtnClick.bind(this));
	});
});
