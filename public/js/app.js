$(".button-collapse").sideNav();

$(document).ready(function(){
	$('.slider').slider({full_width: true});
	$(".dropdown-button").dropdown();
    $('select').material_select();
    $('.modal-trigger').leanModal();
    $('.tooltipped').tooltip({delay: 50});
    $('.collapsible').collapsible({accordion : false});
});
