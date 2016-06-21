letLeave = true;

var perfectSidebarScroll = function () {
	if ($('.st-menu').css('position') == 'fixed') {
		$('.st-menu').css({'min-height': 0});
		$('.st-menu').perfectScrollbar();
	} else {
		$('.st-menu').perfectScrollbar('destroy');
	}
}
var sidebarMinHeight = function () {
	var menuHeaderHeight = $('.st-menu .menu-header').outerHeight(true),
		menuHeight = $('.st-menu .metismenu').outerHeight(true),
		menuFooterHeight = $('.st-menu .menu-footer').outerHeight(true) + (parseInt($('.st-menu .menu-footer').css('bottom')) * 2),
		minHeight = menuHeaderHeight + menuHeight + menuFooterHeight;

	if ($('.st-menu').css('position') != 'fixed') {
		$('.st-menu').css({'min-height': minHeight + 'px'});
	}
}

var redirectToAdmin = function () {
	location.href = '/admin';
}

var waxcms = {
	confirmEmail : function (response) {
		var emails = response.params.emails;

		$.post('/admin/getemail', {emails:emails}, function (response) {
			$('#modal-email .modal-body').html(response.html);
			$('#modal-email').addClass('fade').modal('show');
		});

		$('.do-skip-email').unbind('click').bind('click', function (e) {
			e.preventDefault();

			if (confirm('Are you sure you do not want to send out this email?')) {
				var form = $(this).closest('.modal').find('form')

				form.find('input[name="skip"]').val(1);
				form.data('formValidation').validate();
				//form.trigger('submit');
			}
		});

		$('.do-send-email').unbind('click').bind('click', function (e) {
			e.preventDefault();

			var form = $(this).closest('.modal').find('form');

			form.find('input[name="skip"]').val('');
			form.data('formValidation').validate();
			//form.trigger('submit');

			$(this).button('loading');
		});
	},
	closeConfirmEmail : function () {
		var buttons = $('#modal-email').find('button');

		buttons.button('reset');

		$('#modal-email').removeClass('fade').modal('hide');
	}
}

$(function(){

	/* Init sidebar scrolling */
	setTimeout(function(){
		perfectSidebarScroll();
		sidebarMinHeight();
	},100)
	
	$(window).resize(function(){
		perfectSidebarScroll();
		sidebarMinHeight();
	})

	/* Init menu */
	$('#menu').metisMenu();

	/* Toastr options */
	toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: 4000,
        closeDuration : 100
    };

    $('[data-toggle="tooltip"]').tooltip();

	$(window).on('beforeunload', function(e) {
		if (letLeave == false && watchLeave === true) {
			return Lang.get('cms.confirm_leave_msg');
		}
	});

	$('.btn-import-content').click(function(e){
		e.preventDefault();

		var url = $(this).attr('href');

		$.post(url, {_token:$('[name="_token"]').val()}, function(response){
			$('.wax-repeater:first').waxrepeater('refresh');

			if (response.message !== undefined && response.message.length > 0) {
				if (response.valid  !== undefined && response.valid.toString() == 'true') {
					if (toastr) { toastr.success(Lang.get(response.message), Lang.get('repeater.success_msg_title')); }
				} else {
					if (toastr) { toastr.error(Lang.get(response.message), Lang.get('repeater.error_msg_title')); }
				}
			}
		});
	});
})

function setCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function removeCookie(name) {
    createCookie(name,"",-1);
}