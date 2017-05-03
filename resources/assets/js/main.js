var dateFormat 		= require('dateformat');

// Vue imports
var Vue 			= require('vue');

var SendBird        = require("sendbird");
var Spinner         = require("spin");
var Dropzone 		= require("dropzone");
var swal 			= require("sweetalert");
var bootstrapToggle = require("bootstrap-toggle");
var locationPicker  = require("jquery-locationpicker");
Vue.use(require('vue-resource'));

$(document).ready(function(){
// var dateFormat = require('dateformat');

// set th CSRF_TOKEN for ajax requests
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});
Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');


 /* ==========================================================================
    Custom functions
    ========================================================================== */

/**
 * Check if variable is instanciated
 * @param  {string} strVariableName name of the variable to pass
 * @return {boolean}
 */
function isset(strVariableName) {
	if(typeof back !== 'undefined'){
        return (typeof back[strVariableName] !== 'undefined');
	}
	return false
 }


 /* ==========================================================================
    VueJs code
    ========================================================================== */

    let Permissions 	 = require('./components/Permissions.vue');
    let PhotoList 	     = require('./components/photoList.vue');
    let FormToAjax   	= require('./directives/FormToAjax.vue');
    let countries       = require('./components/countries.vue');
    let dropdown       = require('./components/dropdown.vue');
    let alert       = require('./components/alert.vue');
    let billing       = require('./components/billing.vue');
    let contract       = require('./components/contract.vue');
    let measurement     = require('./components/measurement.vue');
    let equipment       = require('./components/equipment.vue');
    let works       = require('./components/works.vue');
    let payments       = require('./components/payments.vue');
    let routeTable     = require('./components/routeTable.vue');
    let notificationsWidget     = require('./components/notificationsWidget.vue');
    let AllNotificationsAsReadButton = require('./components/AllNotificationsAsReadButton.vue');
    let workOrderPhotosShow = require('./components/workOrderPhotosShow.vue');
    let workOrderPhotosEdit = require('./components/workOrderPhotosEdit.vue');
    let finishWorkOrderButton = require('./components/finishWorkOrderButton.vue');
    let deleteButton = require('./components/deleteButton.vue');
    let addressFields = require('./components/addressFields.vue');
    let missingServices = require('./components/missingServices.vue');
    let settings = require('./components/settings.vue');
    let profile = require('./components/profile.vue');
    let workOrderTable = require('./components/workOrderTable.vue');
    let serviceTable = require('./components/serviceTable.vue');
    let clientTable = require('./components/clientTable.vue');
    let supervisorTable = require('./components/supervisorTable.vue');
    let technicianTable = require('./components/technicianTable.vue');
    let invoiceTable = require('./components/invoiceTable.vue');
    let photo = require('./components/photo.vue');
    let editReportPhotos = require('./components/editReportPhotos.vue');
    let timezoneDropdown = require('./components/timezoneDropdown.vue');
    let emailVerificationNotice = require('./components/emailVerificationNotice.vue');
    let clientReports = require('./components/ClientReports.vue');
    let workOrderClientTable = require('./components/workOrderClientTable.vue');
    let serviceClientTable = require('./components/serviceClientTable.vue');
    let clientContract = require('./components/clientContract.vue');
    let clientEquipment = require('./components/clientEquipment.vue');
    let clientWorks = require('./components/clientWorks.vue');
    let locationShow = require('./components/locationShow.vue');
    let reportIndex = require('./components/ReportIndex.vue');
    let changeTechnicianPassword = require('./components/changeTechnicianPassword.vue');
    let rolePicker = require('./components/rolePicker.vue');
    let chat = require('./components/chat.vue');
    let messagesWidget = require('./components/messagesWidget.vue');
    let unreadMessagesCounter = require('./components/unreadMessagesCounter.vue');


    let mainVue = new Vue({
        el: 'body',
        data:{
            sb: {},
            currentUser: {},
        },
        components: {
            // header
            notificationsWidget,
            messagesWidget,
            rolePicker,
            // sideMenu
            unreadMessagesCounter,
            // generic
            alert,
            dropdown,
            PhotoList,
            photo,
            deleteButton,
            timezoneDropdown,
            emailVerificationNotice,
            chat,
            // notifications
            AllNotificationsAsReadButton,
            // settings
            Permissions,
            billing,
            settings,
            profile,
            // Client Interface
            clientReports,
            workOrderClientTable,
            serviceClientTable,
            clientContract,
            clientEquipment,
            clientWorks,
            // work orders
            workOrderTable,
            workOrderPhotosShow,
            workOrderPhotosEdit,
            finishWorkOrderButton,
            works,
            // report
            reportIndex,
            editReportPhotos,
            // service
            serviceTable,
            countries,
            contract,
            measurement,
            equipment,
            routeTable,
            deleteButton,
            addressFields,
            locationShow,
            // client
            clientTable,
            // supervisor
            supervisorTable,
            // technician
            technicianTable,
            changeTechnicianPassword,
            // invoice
            invoiceTable,
            payments,

        },
        directives: { FormToAjax },
        events:{
            messageViewed(channel){
                this.$broadcast('messageViewed', channel);
            }
        },
        ready(){
            // Try to make this only rune once
            let vue = this;
            this.sb = new SendBird({
                appId: '19AA8038-0207-416F-95E2-BF118EA1D93E',
            });
            this.sb.connect(Laravel.chat.id, Laravel.chat.token, function(user, error) {
                if (error) {
                    console.error(error);
                    return;
                }
                vue.currentUser = user;
                let ChannelHandler = new vue.sb.ChannelHandler();
                ChannelHandler.onMessageReceived = function(channel, message){
                    vue.$broadcast('newMessage', {
                        channel: channel,
                        message: message
                    });
                };
                ChannelHandler.onUserLeft = function (groupChannel, user) {
                    vue.$broadcast('leftChannel', {
                        channel: channel,
                        user: user
                    });
                };
                vue.sb.addChannelHandler('mainChannel', ChannelHandler);
                vue.$broadcast('chatReady', user);
            });
        }
    });


    /* ==========================================================================
	Tables
	========================================================================== */

	var generic_table = $('.generic_table');


    let tableOptions = {
		iconsPrefix: 'font-icon',
        toggle:'table',
        sidePagination:'client',
        pagination:'true',
		icons: {
			paginationSwitchDown:'font-icon-arrow-square-down',
			paginationSwitchUp: 'font-icon-arrow-square-down up',
			refresh: 'font-icon-refresh',
			toggle: 'font-icon-list-square',
			columns: 'font-icon-list-rotate',
			export: 'font-icon-download'
		},
		paginationPreText: '<i class="font-icon font-icon-arrow-left"></i>',
		paginationNextText: '<i class="font-icon font-icon-arrow-right"></i>',
	}

	generic_table.bootstrapTable(tableOptions);


    $('.generic_table').on( 'click-row.bs.table', function (e, row, $element) {
        if ( $element.hasClass('table_active') ) {
            $element.removeClass('table_active');
        }
        else {
            generic_table.find('tr.table_active').removeClass('table_active');
            $element.addClass('table_active');
        }
        window.location.href = back.click_url+row.id;
    });

/* ==========================================================================
	Scroll
	========================================================================== */

	if (!("ontouchstart" in document.documentElement)) {

		document.documentElement.className += " no-touch";

		var jScrollOptions = {
			autoReinitialise: true,
			autoReinitialiseDelay: 100
		};

		$('.box-typical-body').jScrollPane(jScrollOptions);
		$('.side-menu').jScrollPane(jScrollOptions);
		//$('.side-menu-addl').jScrollPane(jScrollOptions);
		$('.scrollable-block').jScrollPane(jScrollOptions);
	}

/* ==========================================================================
    Header search
    ========================================================================== */

	$('.site-header .site-header-search').each(function(){
		var parent = $(this),
			overlay = parent.find('.overlay');

		overlay.click(function(){
			parent.removeClass('closed');
		});

		parent.clickoutside(function(){
			if (!parent.hasClass('closed')) {
				parent.addClass('closed');
			}
		});
	});

/* ==========================================================================
    Header mobile menu
    ========================================================================== */

	// Dropdowns
	$('.site-header-collapsed .dropdown').each(function(){
		var parent = $(this),
			btn = parent.find('.dropdown-toggle');

		btn.click(function(){
			if (parent.hasClass('mobile-opened')) {
				parent.removeClass('mobile-opened');
			} else {
				parent.addClass('mobile-opened');
			}
		});
	});

	$('.dropdown-more').each(function(){
		var parent = $(this),
			more = parent.find('.dropdown-more-caption'),
			classOpen = 'opened';

		more.click(function(){
			if (parent.hasClass(classOpen)) {
				parent.removeClass(classOpen);
			} else {
				parent.addClass(classOpen);
			}
		});
	});

	// Left mobile menu
	$('.hamburger').click(function(){
		if ($('body').hasClass('menu-left-opened')) {
			$(this).removeClass('is-active');
			$('body').removeClass('menu-left-opened');
			$('html').css('overflow','auto');
		} else {
			$(this).addClass('is-active');
			$('body').addClass('menu-left-opened');
			$('html').css('overflow','hidden');
		}
	});

	$('.mobile-menu-left-overlay').click(function(){
		$('.hamburger').removeClass('is-active');
		$('body').removeClass('menu-left-opened');
		$('html').css('overflow','auto');
	});

	// Right mobile menu
	$('.site-header .burger-right').click(function(){
		if ($('body').hasClass('menu-right-opened')) {
			$('body').removeClass('menu-right-opened');
			$('html').css('overflow','auto');
		} else {
			$('.hamburger').removeClass('is-active');
			$('body').removeClass('menu-left-opened');
			$('body').addClass('menu-right-opened');
			$('html').css('overflow','hidden');
		}
	});

	$('.mobile-menu-right-overlay').click(function(){
		$('body').removeClass('menu-right-opened');
		$('html').css('overflow','auto');
	});

/* ==========================================================================
    Header help
    ========================================================================== */

	$('.help-dropdown').each(function(){
		var parent = $(this),
			btn = parent.find('>button'),
			popup = parent.find('.help-dropdown-popup'),
			jscroll;

		btn.click(function(){
			if (parent.hasClass('opened')) {
				parent.removeClass('opened');
				jscroll.destroy();
			} else {
				parent.addClass('opened');

				$('.help-dropdown-popup-cont, .help-dropdown-popup-side').matchHeight();

				if (!("ontouchstart" in document.documentElement)) {
					setTimeout(function(){
						jscroll = parent.find('.jscroll').jScrollPane(jScrollOptions).data().jsp;
						//jscroll.reinitialise();
					},0);
				}
			}
		});

		$('html').click(function(event) {
		    if (
		        !$(event.target).closest('.help-dropdown-popup').length
		        &&
		        !$(event.target).closest('.help-dropdown>button').length
		        &&
		        !$(event.target).is('.help-dropdown-popup')
		        &&
		        !$(event.target).is('.help-dropdown>button')
		    ) {
				if (parent.hasClass('opened')) {
					parent.removeClass('opened');
					jscroll.destroy();
		        }
		    }
		});

	});

/* ==========================================================================
    Side menu list
    ========================================================================== */

	$('.side-menu-list li.with-sub').each(function(){
		var parent = $(this),
			clickLink = parent.find('>span'),
			subMenu = parent.find('ul');

		clickLink.click(function(){
			if (parent.hasClass('opened')) {
				parent.removeClass('opened');
				subMenu.slideUp();
			} else {
				$('.side-menu-list li.with-sub').not(this).removeClass('opened').find('ul').slideUp();
				parent.addClass('opened');
				subMenu.slideDown();
			}
		});
	});


/* ==========================================================================
    Dashboard
    ========================================================================== */

	// Calculate height
	function dashboardBoxHeight() {
		$('.box-typical-dashboard').each(function(){
			var parent = $(this),
				header = parent.find('.box-typical-header'),
				body = parent.find('.box-typical-body');
			body.height(parent.outerHeight() - header.outerHeight());
		});
	}

	dashboardBoxHeight();

	$(window).resize(function(){
		dashboardBoxHeight();
	});

	// Collapse box
	$('.box-typical-dashboard').each(function(){
		var parent = $(this),
			btnCollapse = parent.find('.action-btn-collapse');

		btnCollapse.click(function(){
			if (parent.hasClass('box-typical-collapsed')) {
				parent.removeClass('box-typical-collapsed');
			} else {
				parent.addClass('box-typical-collapsed');
			}
		});
	});

	// Full screen box
	$('.box-typical-dashboard').each(function(){
		var parent = $(this),
			btnExpand = parent.find('.action-btn-expand'),
			classExpand = 'box-typical-full-screen';

		btnExpand.click(function(){
			if (parent.hasClass(classExpand)) {
				parent.removeClass(classExpand);
				$('html').css('overflow','auto');
			} else {
				parent.addClass(classExpand);
				$('html').css('overflow','hidden');
			}
			dashboardBoxHeight();
		});
	});



/* ==========================================================================
	Select
	========================================================================== */

	// Bootstrap-select
	$('.bootstrap-select').selectpicker({
		style: '',
		width: '100%',
		size: 8
	});

	// Select2
	$.fn.select2.defaults.set("minimumResultsForSearch", "Infinity");

	$('.select2').select2();

	function select2Icons (state) {
		if (!state.id) { return state.text; }
		var $state = $(
			'<span class="font-icon ' + state.element.getAttribute('data-icon') + '"></span><span>' + state.text + '</span>'
		);
		return $state;
	}

	$(".select2-icon").select2({
		templateSelection: select2Icons,
		templateResult: select2Icons
	});

	$(".select2-arrow").select2({
		theme: "arrow"
	});

	$(".select2-white").select2({
		theme: "white"
	});

	function select2Photos (state) {
		if (!state.id) { return state.text; }
		var $state = $(
			'<span class="user-item"><img src="' + state.element.getAttribute('data-photo') + '"/>' + state.text + '</span>'
		);
		return $state;
	}

	$(".select2-photo").select2({
		templateSelection: select2Photos,
		templateResult: select2Photos
	});


/* ==========================================================================
	Datepicker
	========================================================================== */

	$('.datetimepicker-1').datetimepicker({
		widgetPositioning: {
			horizontal: 'right'
		},
		debug: false
	});

	$('.datetimepicker-2').datetimepicker({
		widgetPositioning: {
			horizontal: 'right'
		},
		format: 'LT',
		debug: false
	});

/* ==========================================================================
	Tooltips
	========================================================================== */

	// Tooltip
	$('[data-toggle="tooltip"]').tooltip({
		html: true
	});

	// Popovers
	$('[data-toggle="popover"]').popover({
		trigger: 'focus'
	});

/* ==========================================================================
	Validation
	========================================================================== */

	$('#form-signin_v1').validate({
		submit: {
			settings: {
				inputContainer: '.form-group'
			}
		}
	});

	$('#form-signin_v2').validate({
		submit: {
			settings: {
				inputContainer: '.form-group',
				errorListClass: 'form-error-text-block',
				display: 'block',
				insertion: 'prepend'
			}
		}
	});

	$('#form-signup_v1').validate({
		submit: {
			settings: {
				inputContainer: '.form-group',
				errorListClass: 'form-tooltip-error'
			}
		}
	});

	$('#form-signup_v2').validate({
		submit: {
			settings: {
				inputContainer: '.form-group',
				errorListClass: 'form-tooltip-error'
			}
		}
	});

/* ==========================================================================
	Sweet alerts
	========================================================================== */

	$('.swal-btn-basic').click(function(e){
		// e.preventDefault();
		swal("Here's a message!");
	});

	$('.swal-btn-text').click(function(e){
		e.preventDefault();
		swal({
			title: "Here's a message!",
			text: "It's pretty, isn't it?"
		});
	});

	$('.swal-btn-success').click(function(e){
		e.preventDefault();
		swal({
			title: "Good job!",
			text: "You clicked the button!",
			type: "success",
			confirmButtonClass: "btn-success",
			confirmButtonText: "Success"
		});
	});

	$('.swal-btn-warning').click(function(e){
		e.preventDefault();
		swal({
				title: "Are you sure?",
				text: "Your will not be able to recover this imaginary file!",
				type: "warning",
				showCancelButton: true,
				cancelButtonClass: "btn-default",
				confirmButtonClass: "btn-warning",
				confirmButtonText: "Warning",
				closeOnConfirm: false
			},
			function(){
				swal({
					title: "Deleted!",
					text: "Your imaginary file has been deleted.",
					type: "success",
					confirmButtonClass: "btn-success"
				});
			});
	});

	$('.swal-btn-cancel').click(function(e){
		e.preventDefault();
		swal({
				title: "Are you sure?",
				text: "You will not be able to recover this imaginary file!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plx!",
				closeOnConfirm: false,
				closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {
					swal({
						title: "Deleted!",
						text: "Your imaginary file has been deleted.",
						type: "success",
						confirmButtonClass: "btn-success"
					});
				} else {
					swal({
						title: "Cancelled",
						text: "Your imaginary file is safe :)",
						type: "error",
						confirmButtonClass: "btn-danger"
					});
				}
			});
	});

	$('.swal-btn-custom-img').click(function(e){
		e.preventDefault();
		swal({
			title: "Sweet!",
			text: "Here's a custom image.",
			confirmButtonClass: "btn-success",
			imageUrl: 'img/smile.png'
		});
	});

	$('.swal-btn-info').click(function(e){
		e.preventDefault();
		swal({
				title: "Are you sure?",
				text: "Your will not be able to recover this imaginary file!",
				type: "info",
				showCancelButton: true,
				cancelButtonClass: "btn-default",
				confirmButtonText: "Info",
				confirmButtonClass: "btn-primary"
			});
	});

/* ==========================================================================
	Bar chart
	========================================================================== */

	$(".bar-chart").peity("bar",{
		delimiter: ",",
		fill: ["#919fa9"],
		height: 16,
		max: null,
		min: 0,
		padding: 0.1,
		width: 384
	});

/* ==========================================================================
	Full height box
	========================================================================== */

	function boxFullHeight() {
		var sectionHeader = $('.section-header');
		var sectionHeaderHeight = 0;

		if (sectionHeader.size()) {
			sectionHeaderHeight = parseInt(sectionHeader.height()) + parseInt(sectionHeader.css('padding-bottom'));
		}

		$('.box-typical-full-height').css('min-height',
			$(window).height() -
			parseInt($('.page-content').css('padding-top')) -
			parseInt($('.page-content').css('padding-bottom')) -
			sectionHeaderHeight -
			parseInt($('.box-typical-full-height').css('margin-bottom')) - 2
		);
		$('.box-typical-full-height>.tbl, .box-typical-full-height>.box-typical-center').height(parseInt($('.box-typical-full-height').css('min-height')));
	}

	boxFullHeight();

	$(window).resize(function(){
		boxFullHeight();
	});

/* ==========================================================================
	Chat
	========================================================================== */

	function chatHeights() {
		$('.chat-dialog-area').height(
			$(window).height() -
			parseInt($('.page-content').css('padding-top')) -
			parseInt($('.page-content').css('padding-bottom')) -
			parseInt($('.chat-container').css('margin-bottom')) - 2 -
			$('.chat-area-header').outerHeight() -
			$('.chat-area-bottom').outerHeight()
		);
		$('.chat-list-in')
			.height(
				$(window).height() -
				parseInt($('.page-content').css('padding-top')) -
				parseInt($('.page-content').css('padding-bottom')) -
				parseInt($('.chat-container').css('margin-bottom')) - 2 -
				$('.chat-area-header').outerHeight()
			)
			.css('min-height', parseInt($('.chat-dialog-area').css('min-height')) + $('.chat-area-bottom').outerHeight());
	}

	chatHeights();

	$(window).resize(function(){
		chatHeights();
	});

/* ==========================================================================
	Auto size for textarea
	========================================================================== */

	autosize($('textarea[data-autosize]'));

/* ==========================================================================
	Pages center
	========================================================================== */

	$('.page-center').matchHeight({
		target: $('html')
	});

	$(window).resize(function(){
		setTimeout(function(){
			$('.page-center').matchHeight({ remove: true });
			$('.page-center').matchHeight({
				target: $('html')
			});
		},100);
	});

/* ==========================================================================
	Cards user
	========================================================================== */

	$('.card-user').matchHeight();

/* ==========================================================================
	Fancybox
	========================================================================== */

	$(".fancybox").fancybox({
		padding: 0,
		openEffect	: 'none',
		closeEffect	: 'none'
	});



/* ==========================================================================
	Box typical full height with header
	========================================================================== */

	function boxWithHeaderFullHeight() {
		$('.box-typical-full-height-with-header').each(function(){
			var box = $(this),
				boxHeader = box.find('.box-typical-header'),
				boxBody = box.find('.box-typical-body');

			boxBody.height(
				$(window).height() -
				parseInt($('.page-content').css('padding-top')) -
				parseInt($('.page-content').css('padding-bottom')) -
				parseInt(box.css('margin-bottom')) - 2 -
				boxHeader.outerHeight()
			);
		});
	}

	boxWithHeaderFullHeight();

	$(window).resize(function(){
		boxWithHeaderFullHeight();
	});

/* ==========================================================================
	Gallery
	========================================================================== */

	$('.gallery-item').matchHeight({
		target: $('.gallery-item .gallery-picture')
	});


/* ==========================================================================
	Addl side menu
	========================================================================== */

	setTimeout(function(){
		if (!("ontouchstart" in document.documentElement)) {
			$('.side-menu-addl').jScrollPane(jScrollOptions);
		}
	},1000);


/* ==========================================================================
    Side datepicker
    ========================================================================== */
    if(isset('enabledDates')){
	    $('#side-datetimepicker').datetimepicker({
	        inline: true,
            enabledDates: back.enabledDates,
	        format: 'YYYY-MM-DD',
            defaultDate: back.todayDate,
	    });
	}

   	$("#side-datetimepicker").on("dp.change", function(e) {
   		var date = new Date(e.date._d);
   		var date_selected = dateFormat(date, "yyyy-mm-dd");
        mainVue.$broadcast('datePickerClicked', date_selected);
    });

    // Forms Datepickers
    if(isset('defaultDate')){
	    $('#editGenericDatepicker').datetimepicker({
	        widgetPositioning: {
				horizontal: 'right'
			},
			debug: false,
	        defaultDate: back.defaultDate,
	    });
	}
	$('#genericDatepicker').datetimepicker({
	        widgetPositioning: {
				horizontal: 'right'
			},
			debug: false,
	        useCurrent: true,
	    });


/* ==========================================================================
    Custom Slick Carousel
    ========================================================================== */

    $(".reports_slider").slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
		centerMode: true,
		focusOnSelect: true
	});


/* ==========================================================================
    Clockpicker
    ========================================================================== */

	$(document).ready(function() {
	    $('.clockpicker').clockpicker({
	        autoclose: true,
	        donetext: 'Done',
	        'default': 'now'
	    });
	});


/* ==========================================================================
    Maxlenght and Hide Show Password
    ========================================================================== */

	$('input.maxlength-simple').maxlength();

    $('input.maxlength-custom-message').maxlength({
        threshold: 10,
        warningClass: "label label-success",
        limitReachedClass: "label label-danger",
        separator: ' of ',
        preText: 'You have ',
        postText: ' chars remaining.',
        validate: true
    });

    $('input.maxlength-always-show').maxlength({
        alwaysShow: true
    });

    $('textarea.maxlength-simple').maxlength({
        alwaysShow: true
    });

    $('.hide-show-password').password();

/* ========================================================================== */
});
