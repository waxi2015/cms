letLeave = true;

var perfectSidebarScroll = function () {
	if ($('.st-menu').css('position') == 'fixed') {
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

	$('.st-menu').css({'min-height': minHeight + 'px'});
}

var redirectToAdmin = function () {
	location.href = '/admin';
}

$(function(){

	/* Init sidebar scrolling */
	perfectSidebarScroll();
	sidebarMinHeight();
	
	$(window).resize(function(){
		perfectSidebarScroll();
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
		if (letLeave == false) {
			return Lang.get('cms.confirm_leave_msg');
		}
	})
})