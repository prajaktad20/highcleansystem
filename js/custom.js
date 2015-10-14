jQuery(document).ready(function() {
   
   "use strict";
   
   // Tooltip
   jQuery('.tooltips').tooltip({ container: 'body'});
   
   // Popover
   jQuery('.popovers').popover();
   
   // Show panel buttons when hovering panel heading
   jQuery('.panel-heading').hover(function() {
      jQuery(this).find('.panel-btns').fadeIn('fast');
   }, function() {
      jQuery(this).find('.panel-btns').fadeOut('fast');
   });
   
   // Close Panel
   jQuery('.panel .panel-close').click(function() {
      jQuery(this).closest('.panel').fadeOut(200);
      return false;
   });
   
   // Minimize Panel
   jQuery('.panel .panel-minimize').click(function(){
      var t = jQuery(this);
      var p = t.closest('.panel');
      if(!jQuery(this).hasClass('maximize')) {
         p.find('.panel-body, .panel-footer').slideUp(200);
         t.addClass('maximize');
         t.find('i').removeClass('fa-minus').addClass('fa-plus');
         jQuery(this).attr('data-original-title','Maximize Panel').tooltip();
      } else {
         p.find('.panel-body, .panel-footer').slideDown(200);
         t.removeClass('maximize');
         t.find('i').removeClass('fa-plus').addClass('fa-minus');
         jQuery(this).attr('data-original-title','Minimize Panel').tooltip();
      }
      return false;
   });
   
   jQuery('.leftpanel .nav .parent > a').click(function() {
      
      var coll = jQuery(this).parents('.collapsed').length;
      
      if (!coll) {
         jQuery('.leftpanel .nav .parent-focus').each(function() {
            jQuery(this).find('.children').slideUp('fast');
            jQuery(this).removeClass('parent-focus');
         });
         
         var child = jQuery(this).parent().find('.children');
         if(!child.is(':visible')) {
            child.slideDown('fast');
            if(!child.parent().hasClass('active'))
               child.parent().addClass('parent-focus');
         } else {
            child.slideUp('fast');
            child.parent().removeClass('parent-focus');
         }
      }
      return false;
   });
   
    
   
   
   // Menu Toggle
   jQuery('.menu-collapse').click(function() {
      if (!$('body').hasClass('hidden-left')) {
         if ($('.headerwrapper').hasClass('collapsed')) {
            $('.headerwrapper, .mainwrapper').removeClass('collapsed');
         } else {
            $('.headerwrapper, .mainwrapper').addClass('collapsed');
            $('.children').hide(); // hide sub-menu if leave open
         }
      } else {
         if (!$('body').hasClass('show-left')) {
            $('body').addClass('show-left');
         } else {
            $('body').removeClass('show-left');
         }
      }
      return false;
   });
   
   // Add class nav-hover to mene. Useful for viewing sub-menu
   jQuery('.leftpanel .nav li').hover(function(){
      $(this).addClass('nav-hover');
   }, function(){
      $(this).removeClass('nav-hover');
   });
   
   // For Media Queries
   jQuery(window).resize(function() {
      hideMenu();
   });
   
   hideMenu(); // for loading/refreshing the page
   function hideMenu() {
      
      if($('.header-right').css('position') == 'relative') {
         $('body').addClass('hidden-left');
         $('.headerwrapper, .mainwrapper').removeClass('collapsed');
      } else {
         $('body').removeClass('hidden-left');
      }
      
      // Seach form move to left
      if ($(window).width() <= 360) {
         if ($('.leftpanel .form-search').length == 0) {
            $('.form-search').insertAfter($('.profile-left'));
         }
      } else {
         if ($('.header-right .form-search').length == 0) {
            $('.form-search').insertBefore($('.btn-group-notification'));
         }
      }
   }
   
   collapsedMenu(); // for loading/refreshing the page
   function collapsedMenu() {
      
      if($('.logo').css('position') == 'relative') {
         $('.headerwrapper, .mainwrapper').addClass('collapsed');
      } else {
         $('.headerwrapper, .mainwrapper').removeClass('collapsed');
      }
   }

});


$(function () {
    var url = window.location.pathname; //sets the variable "url" to the pathname of the current window
    var activePage = url.substring(url.lastIndexOf('/') + 1); //sets the variable "activePage" as the substring after the last "/" in the "url" variable
        
		$('.nav li a').each(function () { //looks in each link item within the primary-nav list
            var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); //sets the variable "linkPage" as the substring of the url path in each <a>

            if (activePage == linkPage) { //compares the path of the current window to the path of the linked page in the nav item
              // $(this).parent().addClass('active'); //if the above is true, add the "active" class to the parent of the <a> which is the <li> in the nav list
            }
        });
		
		$('.dashboard a').each(function () { 

		var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); 
		if (activePage == linkPage) { 
			//$(this).parent().addClass('active'); 
			//$(this).addClass('select'); 
     // $('.Quotes .children').css("display","block");
	  $('.dashboard').addClass('active');
		}
	});
		
		
		$('.Quotes ul li a').each(function () { 

		var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); 
		if (activePage == linkPage) { 
			//$(this).parent().addClass('active'); 
			$(this).addClass('select'); 
      $('.Quotes .children').css("display","block");
	  $('.Quotes').addClass('parent-focus');
		}
	});
	
	$('.user ul li a').each(function () { 

		var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); 
		if (activePage == linkPage) { 
			//$(this).parent().addClass('active'); 
			$(this).addClass('select'); 
      $('.user .children').css("display","block");
	  $('.user').addClass('parent-focus');
		}
	});
	
	$('.report ul li a').each(function () { 

		var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); 
		if (activePage == linkPage) { 
			//$(this).parent().addClass('active'); 
			$(this).addClass('select'); 
      $('.report .children').css("display","block");
	  $('.report').addClass('parent-focus');
		}
	});
	
	$('.setting a').each(function () { 

		var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); 
		if (activePage == linkPage) { 
			//$(this).parent().addClass('active'); 
			//$(this).addClass('select'); 
     // $('.Quotes .children').css("display","block");
	  $('.setting').addClass('active');
		}
	});
	
	$('.services a').each(function () { 

		var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); 
		if (activePage == linkPage) { 
			//$(this).parent().addClass('active'); 
			//$(this).addClass('select'); 
     // $('.Quotes .children').css("display","block");
	  $('.services').addClass('active');
		}
	});
	
	$('.managebuilding a').each(function () { 

		var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); 
		if (activePage == linkPage) { 
			//$(this).parent().addClass('active'); 
			//$(this).addClass('select'); 
     // $('.Quotes .children').css("display","block");
	  $('.managebuilding').addClass('active');
		}
	});
	
	//$('.quote_section .table tbody tr td a').each(function () { 
//	  
//	  //$('.Quotes .children').css("display","block");
//	  //$('.nav li.Quotes').addClass('parent-focus');
//		
//		
//		var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); 
//		if (activePage == linkPage) { 
//			//$(this).parent().addClass('active'); 
//			//$(this).addClass('select'); 
//			
//      $('.Quotes .children').css("display","block");
//	  $('.nav li.Quotes').addClass('parent-focus');
//		}
//	});
	
	
		
		
		
		 //$('.quote_section .nav-tabs li a').each(function () { //looks in each link item within the primary-nav list
          //  var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); //sets the variable "linkPage" as the substring of the url path in each <a>
          //  if (activePage == linkPage) { //compares the path of the current window to the path of the linked page in the nav item
			
           //     $('.Quotes').addClass('active'); //if the above is true, add the "active" class to the parent of the <a> which is the <li> in the nav list
           // }
       // });
		
		
		//$('.user_section .nav-tabs li a').each(function () { //looks in each link item within the primary-nav list
//		
//            var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); //sets the variable "linkPage" as the substring of the url path in each <a>
//            if (activePage == linkPage) { //compares the path of the current window to the path of the linked page in the nav item
//			
//                $('.user').addClass('active'); //if the above is true, add the "active" class to the parent of the <a> which is the <li> in the nav list
//            }
//        });
//		
		//$('.report_scetion .nav-tabs li a').each(function () { //looks in each link item within the primary-nav list
//            var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); //sets the variable "linkPage" as the substring of the url path in each <a>
//            if (activePage == linkPage) { //compares the path of the current window to the path of the linked page in the nav item
//			
//                $('.report').addClass('active'); //if the above is true, add the "active" class to the parent of the <a> which is the <li> in the nav list
//            }
//        });
//		
//		$('.setting_scetion .nav-tabs li a').each(function () { //looks in each link item within the primary-nav list
//            var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); //sets the variable "linkPage" as the substring of the url path in each <a>
//            if (activePage == linkPage) { //compares the path of the current window to the path of the linked page in the nav item
//			
//                $('.setting').addClass('active'); //if the above is true, add the "active" class to the parent of the <a> which is the <li> in the nav list
//            }
//        });
		
	
	
	
	jQuery('#updatebtn').css('display','none');
	jQuery('.editser').click(function(){
		jQuery('#addbtn').hide();	
		jQuery('#updatebtn').show();
	});
	
	
	jQuery('.editbuing').click(function(){
		jQuery('#addbtn').hide();	
		jQuery('#updatebtn').show();
	});

	
	
});




