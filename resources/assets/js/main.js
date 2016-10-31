var dateFormat 		= require('dateformat');

// Vue imports
var Vue 			= require('vue');
var Permissions 	 = require('./components/Permissions.vue');
var PhotoList 	     = require('./components/photoList.vue');
var emailPreference  = require('./components/email.vue');
var FormToAjax   	= require('./directives/FormToAjax.vue');
var countries       = require('./components/countries.vue');
var dropdown       = require('./components/dropdown.vue');
var alert       = require('./components/alert.vue');
var billing       = require('./components/billing.vue');
var contract       = require('./components/contract.vue');
require('./components/checkboxList.vue');

var Spinner         = require("spin");
var Gmaps           = require("gmaps.core");
require("gmaps.markers");
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
	Billing Stripe
	========================================================================== */




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
	Tables
	========================================================================== */

	var generic_table = $('.generic_table');
	var equipmentTable = $('#equipmentTable');
	var worksTable = $('#worksTable');
	var missingServices = $('#missingServices');


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
	equipmentTable.bootstrapTable(tableOptions);
	worksTable.bootstrapTable(tableOptions);
	missingServices.bootstrapTable(tableOptions);


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

    $('#worksTable').on( 'click-row.bs.table', function (e, row, $element) {
        if ( $element.hasClass('table_active') ) {
            $element.removeClass('table_active');
        }
        else {
            worksTable.find('tr.table_active').removeClass('table_active');
            $element.addClass('table_active');
        }
        if(isset('worksUrl')){
            $.ajax({
                vue: workOrderVue,
                worksTable: worksTable,
                url:      back.worksUrl+row.id,
                type:     'GET',
                success: function(data, textStatus, xhr) {
                    //called when successful
                    this.vue.workId = data.id;
                    this.vue.workTitle = data.title;
                    this.vue.workDescription = data.description;
                    this.vue.workQuantity = data.quantity;
                    this.vue.workUnits = data.units;
                    this.vue.workCost = data.cost;
                    this.vue.workTechnician = data.technican;
                    this.vue.workPhotos = data.photos;

                    this.vue.openWorkModal(2);
                    // remove dropzone instance
                    Dropzone.forElement("#worksDropzone").destroy();

                    if(isset('worksAddPhotoUrl')){
                        // generating the dropzone dinamicly
                        // in order to change the url
                        $("#worksDropzone").dropzone({
                                vue: this.vue,
                                url: back.worksAddPhotoUrl+data.id,
                                method: 'post',
                                paramName: 'photo',
                                maxFilesize: 50,
                                acceptedFiles: '.jpg, .jpeg, .png',
                                init: function() {
                                    this.on("success", function(file) {
                                        this.options.vue.$emit('workChanged');
                                    });
                                }
                        });
                    }
                    // remove the selected color from the row
                    this.worksTable.find('tr.table_active').removeClass('table_active');
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error');
                }
            });
        }
    });

    $('#equipmentTable').on( 'click-row.bs.table', function (e, row, $element) {
        if ( $element.hasClass('table_active') ) {
            $element.removeClass('table_active');
        }
        else {
            equipmentTable.find('tr.table_active').removeClass('table_active');
            $element.addClass('table_active');
        }
        if(isset('equipmentUrl')){
            $.ajax({
                vue: serviceVue,
                equipmentTable: equipmentTable,
                url:      back.equipmentUrl+row.id,
                type:     'GET',
                success: function(data, textStatus, xhr) {
                    //called when successful
                    this.vue.equipmentId = data.id;
                    this.vue.equipmentKind = data.kind;
                    this.vue.equipmentType = data.type;
                    this.vue.equipmentBrand = data.brand;
                    this.vue.equipmentModel = data.model;
                    this.vue.equipmentCapacity = data.capacity;
                    this.vue.equipmentUnits = data.units;
                    this.vue.equipmentPhotos = data.photos;
                    // remove dropzone instance
                    Dropzone.forElement("#equipmentDropzone").destroy();

                    if(isset('equipmentAddPhotoUrl')){
                        // generating the dropzone dinamicly
                        // in order to change the url
                        $("#equipmentDropzone").dropzone({
                                vue: this.vue,
                                url: back.equipmentAddPhotoUrl+data.id,
                                method: 'post',
                                paramName: 'photo',
                                maxFilesize: 50,
                                acceptedFiles: '.jpg, .jpeg, .png',
                                init: function() {
                                    this.on("success", function(file) {
                                        this.options.vue.$emit('equipmentChanged');
                                    });
                                }
                        });
                        // set the dropzone class for styling
                        $( "#equipmentDropzone" ).addClass("dropzone");
                    }
                    // remove the selected color from the row
                    this.equipmentTable.find('tr.table_active').removeClass('table_active');
                    this.vue.equipmentTableFocus = false;
                    this.vue.equipmentFocus = 4;
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error');
                }
            });
        }
    });

    $('#missingServices').on( 'click-row.bs.table', function (e, row, $element) {
        if ( $element.hasClass('table_active') ) {
            $element.removeClass('table_active');
        }
        else {
            missingServices.find('tr.table_active').removeClass('table_active');
            $element.addClass('table_active');
        }
        window.location.href = back.click_missingServices_url+row.id;
    });

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

	if(isset('date_url')){
	   	$("#side-datetimepicker").on("dp.change", function(e) {
	   		var date = new Date(e.date._d);
	   		var date_selected = dateFormat(date, "yyyy-mm-dd");
            var new_url = back.datatable_url+date_selected;
            var new_missingServices_url = back.missingServices_url+date_selected;

            generic_table.bootstrapTable('refresh', {url: new_url});
            missingServices.bootstrapTable('refresh', {url: new_missingServices_url});
            if(isset('missingServicesInfo_url')){
                $.ajax({
                    vue: reportVue,
                    url:      back.missingServicesInfo_url,
                    type:     'GET',
                    dataType: 'json',
                    data: {
                            'date': date_selected
                        },
                    success: function(data, textStatus, xhr) {
                        //called when successful
                        this.vue.numServicesDone =  data.numServicesDone;
                        this.vue.numServicesMissing =  data.numServicesMissing;
                        this.vue.numServicesToDo =  data.numServicesToDo;
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        //called when there is an error
                        // console.log('error');
                    }
                });
            }
	    });
   }
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
    VueJs code
    ========================================================================== */

    // workOrders Vue instance
    let workOrderVue = new Vue({
        el:'.workOrderVue',
        components: {
            PhotoList,
            dropdown
        },
        data:{
            validationErrors: {},
            // index
            finishedSwitch: false,
            // create edit
            supervisorId: (isset('supervisorId')) ? back.supervisorId : 0,
            serviceId: (isset('serviceId')) ? back.serviceId : 0,
            // Show
            finished: (isset('workOrderFinished')) ? back.workOrderFinished : 0,
                // Finish
                    workOrderFinishedAt: '',
                // Photos
                    photoFocus: 1, // 1=before work  2=after work 3=editing before work photo
                // Work
                    // show and edit
                    workFocus: 1, // 1=new, 2=show, 3=edit
                    workOrderId: (isset('workOrderId')) ? back.workOrderId : 0,
                    workId: 0,
                    workTitle: '',
                    workDescription: '',
                    workQuantity: '',
                    workUnits: '',
                    workCost: '',
                    workOrderBeforePhotos: (isset('workOrderBeforePhotos')) ? back.workOrderBeforePhotos : 0,
                    workOrderAfterPhotos: (isset('workOrderAfterPhotos')) ? back.workOrderAfterPhotos : 0,
                    workTechnician: {
                        'id': 0,
                    },
                    workPhotos: [],
        },
        computed:{
            workModalTitle: function(){
                switch (this.workFocus){
                    case 1:
                        return 'Add Work';
                    break;
                    case 2:
                        return 'View Work';
                    break;
                    case 3:
                        return 'Edit Work';
                    break;
                    default:
                        return 'Work';
                }
            },
            photoModalTitle: function(){
                switch (this.photoFocus){
                    case 1:
                        return 'Photos before work started';
                    break;
                    case 2:
                        return 'Photos after the work was finished';
                    break;
                    default:
                        return 'Photos';
                }
            },
        },
        events:{
            workChanged(){
                this.getWork();
            },
            workOrderChangePhotos(){
                this.refreshWorkOrderPhotos('after');
                this.refreshWorkOrderPhotos('before');
            }
        },
        methods:{
            refreshWorkOrderPhotos(type){
                let url = '';
                if((type == 'before') && (isset('workOrderPhotoBeforeUrl'))){
                    url = back.workOrderPhotoBeforeUrl;
                }else if((type == 'after') && (isset('workOrderPhotoAfterUrl'))){
                    url = back.workOrderPhotoAfterUrl;
                }

                if(url != ''){
                    $.ajax({
                        vue: this,
                        url: url,
                        type: 'GET',
                        success: function(data, textStatus, xhr) {
                            if(type == 'before'){
                                this.vue.workOrderBeforePhotos = data;
                            }else if(type == 'after'){
                                this.vue.workOrderAfterPhotos = data;
                            }
                        },
                        error: function(xhr, textStatus, errorThrown) {

                        }
                    });
                }
            },
            checkValidationError($fildName){
                return $fildName in this.validationErrors;
            },
            finishWorkOrder(){
                if(isset('finishWorkOrderUrl') && isset('workOrderUrl')){
                    $.ajax({
                        vue: this,
                        swal: swal,
                        url: back.finishWorkOrderUrl,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'end': this.workOrderFinishedAt,
                        },
                        success: function(data, textStatus, xhr) {
                            window.location = back.workOrderUrl;
                            // send success alert
                            this.swal({
                                title: data.title,
                                text: data.message,
    		                    type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            this.vue.validationErrors = xhr.responseJSON;
                        }
                    });
                }
            },
            openPhotosModal($focus){
                this.photoFocus = $focus;
                $('#photosWorkOrderModal').modal('show');
            },
            checkPhotoFocus($num){
                return (this.photoFocus == $num);
            },
            openFinishModal(){
                $('#finishWorkOrderModal').modal('show');
            },
            destroyWork(){
                if(isset('worksUrl')){
                    let vue = this;
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    }, function(isConfirm){
                        if(isConfirm){
                            $.ajax({
                                vue: vue,
                                swal: swal,
                                url: back.worksUrl+vue.workId,
                                type: 'DELETE',
                                success: function(data, textStatus, xhr) {
                                    // refresh equipment list
                                    worksTable.bootstrapTable('refresh');

                                    this.vue.closeWorkModal();
                                    // send success alert
                                    this.swal({
                                        title: data.title,
                                        text: data.message,
        			                    type: "success",
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                },
                                error: function(xhr, textStatus, errorThrown) {
                                    // this.swal({
                                    //     title: data.title,
                                    //     text: data.message,
        			                //     type: "error",
                                    //     showConfirmButton: true
                                    // });
                                }
                            });
                        }
                    });
                }
            },
            sendWork(type){
                let url = (isset('worksUrl')) ? back.worksUrl: '';
                let requestType = 'POST';
                if(type == 'edit'){
                    url += this.workId;
                    requestType = 'PATCH';
                }

                if(url != ''){
                    $.ajax({
                        vue: this,
                        swal: swal,
                        url: url,
                        type: requestType,
                        dataType: 'json',
                        data: {
                            title: this.workTitle,
                            description: this.workDescription,
                            quantity: this.workQuantity,
                            units: this.workUnits,
                            cost: this.workCost,
                            work_order_id: this.workOrderId,
                            technician_id: this.workTechnician.id,
                        },
                        success: function(data, textStatus, xhr) {
                            // refresh equipment list
                            worksTable.bootstrapTable('refresh');

                            this.vue.closeWorkModal();

                            // send success alert
                            this.swal({
                                title: data.title,
                                text: data.message,
			                    type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            this.vue.validationErrors = xhr.responseJSON;
                        }
                    });
                }
            },
            getWork(){
                if(isset('worksUrl')){
                    $.ajax({
                        vue: this,
                        url:      back.worksUrl+this.workId,
                        type:     'GET',
                        success: function(data, textStatus, xhr) {
                            this.vue.workId = data.id;
                            this.vue.workTitle = data.title;
                            this.vue.workDescription = data.description;
                            this.vue.workQuantity = data.quantity;
                            this.vue.workUnits = data.units;
                            this.vue.workCost = data.cost;
                            this.vue.workTechnician = data.technican;
                            this.vue.workPhotos = data.photos;
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            //called when there is an error
                            console.log('error');
                        }
                    });
                }
            },
            clearWork(){
                this.workId= 0;
                this.workTitle= '';
                this.workDescription= '';
                this.workQuantity= '';
                this.workUnits= '';
                this.workCost= '';
                this.workTechnician= '';
                this.workPhotos= '';
            },
            setWorkFocus($num){
                if($num == 1){
                    this.clearWork();
                }
                this.workFocus= $num;
            },
            checkWorkFocusIs($num){
                return (this.workFocus == $num);
            },
            openWorkModal($focus){
                this.setWorkFocus($focus);
                $('#workModal').modal('show');
            },
            closeWorkModal(){
                $('#workModal').modal('hide');
                this.clearWork();
            },
            changeWorkOrderListFinished(finished){
                var intFinished = (!finished) ? 1 : 0;
                if(isset('workOrderTableUrl')){
                    let new_url = back.workOrderTableUrl+intFinished;
                    generic_table.bootstrapTable('refresh', {url:new_url});
            	}
            }
        },
    });

    // report Vue instance
    let reportVue = new Vue({
        el:'.reportVue',
        components: { dropdown },
        directives: { FormToAjax },
        data:{
            numServicesMissing: (isset('numServicesMissing')) ? back.numServicesMissing : '',
            numServicesToDo:    (isset('numServicesToDo')) ? back.numServicesToDo : '',
            numServicesDone:    (isset('numServicesDone')) ? back.numServicesDone : '',
            reportEmailPreview: (isset('emailPreviewNoImage')) ? back.emailPreviewNoImage : '',
            serviceKey:         (isset('serviceKey')) ? Number(back.serviceKey) : 0,
            technicianKey:      (isset('technicianKey')) ? Number(back.technicianKey) : 0,
        },
        computed:{
            missingServicesTag: function () {
                    if(this.numServicesMissing < 1){
                        return 'All Services Done';
                    }
                    return 'Missing Services: '+this.numServicesMissing;
                },
        },
        methods:{
            previewEmailReport(id){
                // prevent the user from clicking more than once
                event.target.disabled = true;
                event.target.innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Generating email";
                new Spinner({
                    left: "90%",
                    radius: 5,
                    length: 4,
                    width: 1,
                }).spin(event.target);
                // HTTP Request or what ever to update the permission
                $.ajax({
                    vue: this,
                    target: event.target,
                    url:      (isset('emailPreview')) ? back.emailPreview : '',
                    type:     'GET',
                    dataType: 'json',
                    data: {
                            'id': id
                        },
                    complete: function(xhr, textStatus) {
                        this.target.disabled = false;
                        this.target.innerHTML = "<i class=\"font-icon font-icon-mail\"></i>&nbsp;&nbsp;Preview email";
                    },
                    success: function(data, textStatus, xhr) {
                        $('#emailPreview').modal('show');
                        this.vue.reportEmailPreview = data.data.url;
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log('error');
                    }
                });
            }
        },
    });

    let settingsVue = new Vue({
        el: '.settingsVue',
        components:{
            Permissions,
            emailPreference,
            alert,
            billing,
        },
        directives: { FormToAjax },
        data:{
            companyName: "",
            website: "",
            facebook: "",
            twitter: "",
            objectName: "",
            objectLastName: "",
            alertMessage: "Error",
            alertOpen: false,
            // billing
            subscribed: isset('subscribed') ? back.subscribed : null,
            plan: isset('plan') ? back.plan : null,
            activeObjects: isset('activeObjects') ? back.activeObjects : null,
            billableObjects: isset('billableObjects') ? back.billableObjects : null,
            freeObjects: isset('freeObjects') ? back.freeObjects : null,
        },
        methods:{
            submitCreditCard(){
                let $form = $('#payment-form');
                let clickEvent = event;
                let buttonTag = clickEvent.target.innerHTML;

                // Disable the submit button to prevent repeated clicks:
                clickEvent.target.disabled = true;
                clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checking Credit Card';

                new Spinner({
                    left: "90%",
                    radius: 5,
                    length: 4,
                    width: 1,
                }).spin(clickEvent.target);

                // Request a token from Stripe:
                Stripe.card.createToken($form, (status, response) => {
                    if (response.error) { // Problem!

                        // Show the errors on the form:
                        this.alertMessage = response.error.message;
                        this.alertOpen = true;
                        clickEvent.target.disabled = false; // Re-enable submission
                        clickEvent.target.innerHTML = buttonTag;

                    } else { // Token was created!

                        // Get the token ID:
                        var token = response.id;

                        // Insert the token ID into the form so it gets submitted to the server:
                        $form.append($('<input type="hidden" name="stripeToken">').val(token));

                        // Submit the form:
                        $form.get(0).submit();
                    }
                });
            },

        },
    });

    let serviceVue = new Vue({
        el: '.serviceVue',
        components: {
            PhotoList,
            countries,
            contract
        },
        directives: {
            FormToAjax
        },
        data: {
            validationErrors: {},
            statusSwitch: true,
            // Location picker values
            pickerServiceAddressLine1: '',
            pickerServiceCity: '',
            pickerServiceState: '',
            pickerServicePostalCode: '',
            pickerServiceCountry: '',
            pickerServiceLatitude: '',
            pickerServiceLongitude: '',
            // form values
            serviceAddressLine1: (isset('addressLine')) ? back.addressLine : '',
            serviceCity: (isset('city')) ? back.city : '',
            serviceState: (isset('state')) ? back.state : '',
            servicePostalCode: (isset('postalCode')) ? back.postalCode : '',
            serviceCountry: (isset('country')) ? back.country : '',
            serviceLatitude: (isset('latitude')) ? back.latitude : null,
            serviceLongitude: (isset('longitude')) ? back.longitude : null,
            // Contract
                hasContract: (isset('hasContract')) ? back.hasContract : null,
            // Equipment
                equipmentTableFocus: true,
                equipmentFocus: 1, // 1=table, 2=new, 3=show, 4=edit
                equipmentId: 0,
                equipmentServiceId: (isset('serviceId')) ? Number(back.serviceId) : 0,
                equipmentPhotos: [],
                equipmentPhoto: '',
                equipmentKind: '',
                equipmentType: '',
                equipmentBrand: '',
                equipmentModel: '',
                equipmentCapacity: '',
                equipmentUnits: '',
        },
        computed: {
            equipmentModalTitle: function(){
                switch (this.equipmentFocus){
                    case 1:
                    return 'Equipment List';
                    break;
                    case 2:
                    return 'Add Equipment';
                    break;
                    case 3:
                    return this.equipmentKind;
                    break;
                    case 4:
                    return 'Edit Equipment';
                    break;
                    default:
                    return 'Equipment';
                }
            },
            contractTag(){
                if(this.hasContract){
                    return "Manage";
                }
                return "Create";
            },
            locationPickerTag(){
                let attributes = {
                        'icon': 'font-icon font-icon-ok',
                        'text': 'Location Selected',
                        'class': 'btn-success'
                    };
                if(this.serviceLatitude == null ){
                    attributes = {
                        'icon': 'font-icon font-icon-pin-2',
                        'text': 'Choose Location',
                        'class': 'btn-primary'
                    };
                }
                return attributes;
            },
        },
        events: {
            // when a photo is deleted from the equipment photo edit
            equipmentChanged(){
                this.getEquipment();
            },
            contractCreated(){
                this.hasContract = true;
            },
            contractDestroyed(){
                this.hasContract = false;    
            }
        },
        methods: {
            checkValidationError($fildName){
                return $fildName in this.validationErrors;
            },
            // Equipment
            destroyEquipment(){
                if(isset('equipmentUrl')){
                    let vue = this;
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    }, function(isConfirm){
                        if(isConfirm){
                            $.ajax({
                                vue: vue,
                                swal: swal,
                                url: back.equipmentUrl+vue.equipmentId,
                                type: 'DELETE',
                                success: function(data, textStatus, xhr) {
                                    // refresh equipment list
                                    equipmentTable.bootstrapTable('refresh');

                                    this.vue.openEquimentList();
                                    // send success alert
                                    this.swal({
                                        title: data.title,
                                        text: data.message,
            		                    type: "success",
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                },
                                error: function(xhr, textStatus, errorThrown) {
                                    // this.swal({
                                    //     title: data.title,
                                    //     text: data.message,
            		                //     type: "error",
                                    //     showConfirmButton: true
                                    // });
                                }
                            });
                        }
                    });
                }
            },
            getEquipment(){
                if(isset('equipmentUrl')){
                    $.ajax({
                        vue: this,
                        url:      back.equipmentUrl+this.equipmentId,
                        type:     'GET',
                        success: function(data, textStatus, xhr) {
                            //called when successful
                            this.vue.equipmentId = data.id;
                            this.vue.equipmentKind = data.kind;
                            this.vue.equipmentType = data.type;
                            this.vue.equipmentBrand = data.brand;
                            this.vue.equipmentModel = data.model;
                            this.vue.equipmentCapacity = data.capacity;
                            this.vue.equipmentUnits = data.units;
                            this.vue.equipmentPhotos = data.photos;
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            //called when there is an error
                            console.log('error');
                        }
                    });
                }
            },
            sendEquipment(type){
                let url = (isset('equipmentUrl')) ? back.equipmentUrl: '';
                let requestType = 'POST';

                if(type == 'edit'){
                    url += this.equipmentId;
                    requestType = 'PATCH';
                }

                if(url != ''){
                    $.ajax({
                        vue: this,
                        url: url,
                        type: requestType,
                        dataType: 'json',
                        data: {
                            'photo': this.equipmentPhoto,
                            'kind': this.equipmentKind,
                            'type': this.equipmentType,
                            'brand': this.equipmentBrand,
                            'model': this.equipmentModel,
                            'capacity': this.equipmentCapacity,
                            'units': this.equipmentUnits,
                            'service_id': this.equipmentServiceId,
                        },
                        success: function(data, textStatus, xhr) {
                            // refresh equipment list
                            equipmentTable.bootstrapTable('refresh');
                            // send back to list
                            this.vue.openEquimentList();
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            this.vue.validationErrors = xhr.responseJSON;
                        }
                    });
                }
            },
            clearEquipment(){
                this.equipmentKind = '';
                this.equipmentType = '';
                this.equipmentBrand = '';
                this.equipmentModel = '';
                this.equipmentCapacity = '';
                this.equipmentUnits = '';
                // clear the validation errors to
                this.validationErrors = {};
            },
            setEquipmentFocus($num){
                this.equipmentFocus = $num;
            },
            checkEquipmentFocusIs($num){
                return (this.equipmentFocus == $num);
            },
            openEquimentList(clearEquipment = true){
                this.equipmentTableFocus = true;
                this.equipmentFocus = 1;
                if(clearEquipment){
                    this.clearEquipment();
                }
                $('#equipmentModal').modal('show');
            },
            populateAddressFields(page){
                this.setLocation(page);
                if(page == 'create'){
                    this.serviceAddressLine1 = this.pickerServiceAddressLine1;
                    this.serviceCity = this.pickerServiceCity;
                    this.servicePostalCode = this.pickerServicePostalCode;
                    this.serviceState = this.pickerServiceState;
                    this.serviceCountry = this.pickerServiceCountry;
                }

            },
            setLocation(page){
                if(page == 'create'){
                    this.serviceLongitude = this.pickerServiceLongitude;
                    this.serviceLatitude = this.pickerServiceLatitude;
                }
            },
            changeServiceListStatus(status){
                var intStatus = (!status) ? 1 : 0;
                if(isset('serviceTableUrl')){
                    let new_url = back.serviceTableUrl+intStatus;
                    generic_table.bootstrapTable('refresh', {url:new_url});
            	}
            },
        },

    });

    let supervisorVue = new Vue({
        el: '.supervisorVue',
        data:{
            statusSwitch: true,
        },
        methods:{
            changeSupervisorListStatus(status){
                var intStatus = (!status) ? 1 : 0;
                if(isset('supervisorTableUrl')){
                    let new_url = back.supervisorTableUrl+intStatus;
                    generic_table.bootstrapTable('refresh', {url:new_url});
            	}
            }
        }
    });


    let technicianVue = new Vue({
        el: '.technicianVue',
        components: { dropdown },
        data:{
            statusSwitch: true,
            dropdownKey: (isset('dropdownKey')) ? Number(back.dropdownKey) : 0,
        },
        methods:{
            changeTechnicianListStatus(status){
                var intStatus = (!status) ? 1 : 0;
                if(isset('techniciansTableUrl')){
                    let new_url = back.techniciansTableUrl+intStatus;
                    generic_table.bootstrapTable('refresh', {url:new_url});
            	}
            }
        }
    });


/* ==========================================================================
    GMaps
    ========================================================================== */
    $('#mapModal').on('shown.bs.modal', function (e) {
        if(isset('showLatitude') && isset('showLongitude')){
            let map = new Gmaps({
                el: '#serviceMap',
                lat: back.showLatitude,
                lng: back.showLongitude,
            });

            map.addMarker({
                lat: back.showLatitude,
                lng: back.showLongitude
            });
        }
    });


/* ==========================================================================
    Dropzone
    ========================================================================== */

    // Dropzone.autoDiscover = false;
    Dropzone.options.genericDropzone = {
        paramName: 'photo',
    	maxFilesize: 50,
    	acceptedFiles: '.jpg, .jpeg, .png'
    }

    Dropzone.options.workOrderDropzone = {
        vue: workOrderVue,
        paramName: 'photo',
    	maxFilesize: 50,
    	acceptedFiles: '.jpg, .jpeg, .png',
        init: function() {
            this.on("success", function(file) {
                this.options.vue.$emit('workOrderChangePhotos');
            });
        }
    }

    // Dropzone.options.equipmentDropzone = {
    //     paramName: 'photo',
    // 	maxFilesize: 50,
    // 	acceptedFiles: '.jpg, .jpeg, .png',
    // }


/* ==========================================================================
    Location Picker
    ========================================================================== */


    let locPicker = $('#locationPicker').locationpicker({
        vue: serviceVue,
        location: {latitude: 23.04457265331633, longitude: -109.70587883663177},
        radius: 0,
        inputBinding: {
        	latitudeInput: $('#serviceLatitude'),
        	longitudeInput: $('#serviceLongitude'),
        	locationNameInput: $('#serviceAddress')
        },
        enableAutocomplete: true,
        onchanged: function (currentLocation, radius, isMarkerDropped) {
            let addressComponents = $(this).locationpicker('map').location.addressComponents;
            let vue = $(this).data("locationpicker").settings.vue;

            vue.pickerServiceAddressLine1 = addressComponents.addressLine1;
            vue.pickerServiceCity         = addressComponents.city;
            vue.pickerServiceState        = addressComponents.stateOrProvince;
            vue.pickerServicePostalCode   = addressComponents.postalCode;
            vue.pickerServiceCountry      = addressComponents.country;
            vue.pickerServiceLongitude      = currentLocation.longitude;
            vue.pickerServiceLatitude      = currentLocation.latitude;
        },
        oninitialized: function(component) {
            let addressComponents = $(component).locationpicker('map').location.addressComponents;
            let startLocation = $(component).data("locationpicker").settings.location;
            let vue = $(component).data("locationpicker").settings.vue;

            vue.pickerServiceAddressLine1 = addressComponents.addressLine1;
            vue.pickerServiceCity         = addressComponents.city;
            vue.pickerServiceState        = addressComponents.stateOrProvince;
            vue.pickerServicePostalCode   = addressComponents.postalCode;
            vue.pickerServiceCountry      = addressComponents.country;
            vue.pickerServiceLongitude      = startLocation.longitude;
            vue.pickerServiceLatitude      = startLocation.latitude;
        }
    });

    $('#locationPickerModal').on('shown.bs.modal', function () {
        $('#locationPicker').locationpicker('autosize');
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

/*
Taken from: https://gist.github.com/soufianeEL/3f8483f0f3dc9e3ec5d9
Modified by Ferri Sutanto
- use promise for verifyConfirm
Examples :
<a href="posts/2" data-method="delete" data-token="{{csrf_token()}}">
- Or, request confirmation in the process -
<a href="posts/2" data-method="delete" data-token="{{csrf_token()}}" data-confirm="Are you sure?">
*/

(function(window, $, undefined) {

    var Laravel = {
        initialize: function() {
            this.methodLinks = $('a[data-method]');
            this.token = $('a[data-token]');
            this.registerEvents();
        },

        registerEvents: function() {
            this.methodLinks.on('click', this.handleMethod);
        },

        handleMethod: function(e) {
            e.preventDefault()

            var link = $(this)
            var httpMethod = link.data('method').toUpperCase()
            var form

            // If the data-method attribute is not PUT or DELETE,
            // then we don't know what to do. Just ignore.
            if ($.inArray(httpMethod, ['PUT', 'DELETE']) === -1) {
                return false
            }

            Laravel
                .verifyConfirm(link)
                .done(function () {
                    form = Laravel.createForm(link)
                    form.submit()
                })
        },

        verifyConfirm: function(link) {
            var confirm = new $.Deferred()
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false
            },
            function(){
                confirm.resolve(link)
            })

            return confirm.promise()
        },

        createForm: function(link) {
            var form =
                $('<form>', {
                    'method': 'POST',
                    'action': link.attr('href')
                });

            var token =
                $('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': link.data('token')
                });

            var hiddenInput =
                $('<input>', {
                    'name': '_method',
                    'type': 'hidden',
                    'value': link.data('method')
                });

            return form.append(token, hiddenInput)
                .appendTo('body');
        }
    };

    Laravel.initialize();

})(window, jQuery);
