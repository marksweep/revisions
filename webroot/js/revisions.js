$(document).ready(function() {

	$('.toggle-revision').show();

	$('.toggle-revision a').live('click', function() {
		if ($('.originalnode').css('display') == 'none') {
			$('.originalnode').show('slow');
			$('.revision').hide('fast');
			$('#RevisionMessage .push-revision').hide();
			$('#RevisionMessage').addClass('original');
			$('#RevisionMessage .toggle-revision a').html('Toggle Revision');
		} else {
			$('.originalnode').hide('fast');
			$('.revision').show('slow');
			$('#RevisionMessage').removeClass('original');
			$('#RevisionMessage .push-revision').show();
			$('#RevisionMessage .toggle-revision a').html('Toggle Original');
		}
	
	});

});
