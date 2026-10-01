var waitInstall = 0;

startInstall = function(){
	if($('.accept_install').attr('data-value') == 1 || $('.accept_install').attr('value') == 1){
		checkPermission();
	} else {
		callSaved('You must accept condition to start installation', 3);
	}
}

acceptCondition = function(item){
	var $elem = $(item);
	var val = $elem.attr('data-value') || $elem.attr('value') || "0";
	if(val == "1"){
		$elem.attr('data-value', '0').attr('value', '0');
		$elem.removeClass('fa-check-circle').addClass('fa-circle');
		$('#start_install').prop('disabled', true);
	} else {
		$elem.attr('data-value', '1').attr('value', '1');
		$elem.removeClass('fa-circle').addClass('fa-check-circle');
		$('#start_install').prop('disabled', false);
	}
}

// تشغيل التحديد وتفعيل الزر
$(document).on('click', '.agreement', function(){
	acceptCondition($(this).find('.accept_install'));
});

$(document).on('click', '#start_install', function(){
	startInstall();
});

runInstaller = function(){
	if(waitInstall == 0){
		$('#install_component').hide();
		$('#wait_install').show();
		waitInstall = 1;
		$.ajax({
			url: "builder/component.php",
			type: "post",
			cache: false,
			dataType: 'json',
			data: { 
				db_host: $('#install_db_host').val(),
				db_name: $('#install_db_name').val(),
				db_user: $('#install_db_user').val(),
				db_pass: $('#install_db_password').val(),
				title: $('#install_title').val(),
				domain: $('#install_domain').val(),
				username: $('#install_username').val(),
				email: $('#install_email').val(),
				password: $('#install_password').val(),
				repeat: $('#install_repeat').val(),
				language: $('#install_language').val()
			},
			success: function(response){
				if(response.code == 1) {
					getEnding();
				} else {
					callSaved(response.error, 3);
					waitInstall = 0;
					$('#wait_install').hide();
					$('#install_component').show();
				}
			},
			error: function(){
				waitInstall = 0;
				$('#wait_install').hide();
				$('#install_component').show();
				return false;
			}
		});
	}
}

endInstall = function(){
	window.location.reload();
}

checkPermission = function(){
	$.post('builder/permission.php', { check: 1 }, function(response) {
		$('#install_content').html(response);
	});	
}

getComponent = function(){
	$.post('builder/element.php', { check: 1 }, function(response) {
		$('#install_content').html(response);
		if($.fn.selectBoxIt) {
			selectIt();
		}
	});	
}

getEnding = function(){
	$.post('builder/ending.php', { check: 1 }, function(response) {
		$('#install_content').html(response);
	});	
}

callSaved = function(text, type){
	var $popup = $('#ui_popup');
	if($popup.length) {
		$popup.find('.msg').text(text);
		$popup.addClass('show');
		setTimeout(function(){ $popup.removeClass('show'); }, 3000);
	}
}

selectIt = function(){
	$("select:visible").selectBoxIt({ 
		autoWidth: false,
		hideEffect: 'fadeOut',
		hideEffectSpeed: 100
	});
}
