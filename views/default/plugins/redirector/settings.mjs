import 'jquery';

$(document).on('click', '#redirector-redirect-add', function() {
	var $from = $('#redirect_from');
	var $to = $('#redirect_to');
	
	if (!$from.val() || !$to.val()) {
		return;
	}
	
	var $list_item = '<input type="hidden" name="params[redirects][' + $from.val() + ']" value="' + $to.val() + '"></input>';
	$list_item += $from.val();
	$list_item += ' <span class="elgg-icon fa elgg-icon-arrow-right fa-arrow-right"></span> ';
	$list_item += $to.val();
	
	$list_item += '<span class="elgg-icon fa elgg-icon-delete fa-times"></span>';
	
	$list_item = '<li>' + $list_item + '</li>';
	
	$('#redirector-redirects-list').append($list_item);
	
	$from.val('');
	$to.val('');
});

$(document).on('click', '#redirector-redirects-list .elgg-icon-delete', function() {
	$(this).closest('li').remove();
});
