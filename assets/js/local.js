var locals = function () {

    /// <summary>Constructor function of the locals class.</summary>
    /// <since>1.0.0</since>
    /// <returns type="locals" />  
    return {
        /// <summary>
        /// Initializes the locals.       
        /// </summary>                 
        /// <returns type="initialization settings" />     
        /// <since>1.0.0</since>  
        init: function () {           
            Common.logInfo("locals.init...");
            
            jQuery('#show_ALL').show();
            jQuery('.local-letters a').on('click', this.actions.showlocalInfo);
			jQuery("#upcoming-past-tabs a").on('click',this.actions.tabClick); 		
            
            if(localStorage.getItem("layout")=="calendar-layout"){
                localStorage.setItem("layout", "box-layout");
            }
			if(jQuery(".normal-section-title").length >0)
			   jQuery(".normal-section-title").html(event_manager_local.i18n_upcomingEventsTitle);
    	},

        actions: {
            /// <summary>
            /// This function is use to show local name by based on how alphabet letters are clicked 	  
            /// </summary>
            /// <param name="parent" type="Event"></param>           
            /// <returns type="actions" />     
            /// <since>1.0.0</since>       
            showlocalInfo: function (event) {
                Common.logInfo("locals.actions.showlocalInfo...");

                var currentClickedLetterId = jQuery(this).attr('id');
                var showAllLetterId = 'ALL';
                //first, hide all local info 	
                jQuery('.show-local-info').hide();

                //checks condition if selected id is \show_All\ then it will show all local name,else it will show only slected alphabet letter local name.
                if (currentClickedLetterId == showAllLetterId) {
                    //show all local block which has clas show-local-info
                    jQuery('.show-local-info').show();
                    jQuery('.no-local').addClass('wpem-d-none');
                } else if(jQuery('#show_' + currentClickedLetterId).length) {	//show clicked letter local only       
                    jQuery('#show_' + currentClickedLetterId).css({ "display": "block" });
                    jQuery('.no-local').addClass('wpem-d-none');
                }else{
                    jQuery('.no-local').removeClass('wpem-d-none');
                }
                event.preventDefault();
            },
			
			/// <summary>
            /// This function is use to show tabes of past and upcoming event onsingle local.	  
            /// </summary>
            /// <param name="parent" type="Event"></param>           
            /// <returns type="actions" />     
            /// <since>1.0.0</since>       
            tabClick: function (event) {
                Common.logInfo("locals.actions.showtab...");   
                
        		if(jQuery(event.target).attr('href')=='#past') {   
                    if(jQuery(".normal-section-title").length >0)
                      jQuery(".normal-section-title").html(event_manager_local.i18n_pastEventsTitle);  
                      
                    if(localStorage.getItem("layout")=="box-layout") {                       
        	            jQuery("#past #line-layout-icon").addClass("lightgray-layout-icon");
        		        jQuery("#past #box-layout-icon").removeClass("lightgray-layout-icon");
		            } else {
		                jQuery("#past #line-layout-icon").removeClass("lightgray-layout-icon");
        		        jQuery("#past #box-layout-icon").addClass("lightgray-layout-icon");
		            }
                }else if(jQuery(event.target).attr('href')=='#current') {   
                    if(jQuery(".normal-section-title").length >0)
                        jQuery(".normal-section-title").html(event_manager_local.i18n_currentEventsTitle);  
                     
                    if(localStorage.getItem("layout")=="box-layout") {                       
        	            jQuery("#current #line-layout-icon").addClass("lightgray-layout-icon");
        		        jQuery("#current #box-layout-icon").removeClass("lightgray-layout-icon");
		            } else {
		                jQuery("#current #line-layout-icon").removeClass("lightgray-layout-icon");
        		        jQuery("#current #box-layout-icon").addClass("lightgray-layout-icon");
		            }
                } else {
                    if(jQuery(".normal-section-title").length >0)
                       jQuery(".normal-section-title").html(event_manager_local.i18n_upcomingEventsTitle);
                }
                event.preventDefault();
            }                        
        }
    }
};
locals = locals();
jQuery(document).ready(function ($) {
    locals.init();
});