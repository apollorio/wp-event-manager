var DJs = function () {

    /// <summary>Constructor function of the DJs class.</summary>
    /// <since>1.0.0</since>
    /// <returns type="DJs" />  
    return {
        /// <summary>
        /// Initializes the DJs.       
        /// </summary>                 
        /// <returns type="initialization settings" />     
        /// <since>1.0.0</since>  
        init: function () {           
            Common.logInfo("DJs.init...");
            
            jQuery('#show_ALL').show();
            jQuery('.dj-letters a').on('click', this.actions.showDJInfo);
			jQuery("#upcoming-past-tabs a").on('click',this.actions.tabClick); 		
            
            if(localStorage.getItem("layout")=="calendar-layout"){
                localStorage.setItem("layout", "box-layout");
            }
			if(jQuery(".normal-section-title").length >0)
			   jQuery(".normal-section-title").html(event_manager_dj.i18n_upcomingEventsTitle);
    	},

        actions: {
            /// <summary>
            /// This function is use to show dj name by based on how alphabet letters are clicked 	  
            /// </summary>
            /// <param name="parent" type="Event"></param>           
            /// <returns type="actions" />     
            /// <since>1.0.0</since>       
            showDJInfo: function (event) {
                Common.logInfo("DJs.actions.showDJInfo...");

                var currentClickedLetterId = jQuery(this).attr('id');
                var showAllLetterId = 'ALL';
                //first, hide all dj info 	
                jQuery('.show-dj-info').hide();

                //checks condition if selected id is \show_All\ then it will show all dj name,else it will show only slected alphabet letter dj name.
                if (currentClickedLetterId == showAllLetterId) {
                    //show all dj block which has clas show-dj-info
                    jQuery('.show-dj-info').show();
                    jQuery('.no-dj').addClass('wpem-d-none');
                } else if(jQuery('#show_' + currentClickedLetterId).length) {	//show clicked letter dj only       
                    jQuery('#show_' + currentClickedLetterId).css({ "display": "block" });
                    jQuery('.no-dj').addClass('wpem-d-none');
                }else{
                    jQuery('.no-dj').removeClass('wpem-d-none');
                }
                event.preventDefault();
            },
			
			/// <summary>
            /// This function is use to show tabes of past and upcoming event onsingle dj.	  
            /// </summary>
            /// <param name="parent" type="Event"></param>           
            /// <returns type="actions" />     
            /// <since>1.0.0</since>       
            tabClick: function (event) {
                Common.logInfo("DJs.actions.showtab...");   
                
        		if(jQuery(event.target).attr('href')=='#past') {   
                    if(jQuery(".normal-section-title").length >0)
                      jQuery(".normal-section-title").html(event_manager_dj.i18n_pastEventsTitle);  
                      
                    if(localStorage.getItem("layout")=="box-layout") {                       
        	            jQuery("#past #line-layout-icon").addClass("lightgray-layout-icon");
        		        jQuery("#past #box-layout-icon").removeClass("lightgray-layout-icon");
		            } else  {
		                jQuery("#past #line-layout-icon").removeClass("lightgray-layout-icon");
        		        jQuery("#past #box-layout-icon").addClass("lightgray-layout-icon");
		            }
                }else if(jQuery(event.target).attr('href')=='#current') {   
                    if(jQuery(".normal-section-title").length >0)
                        jQuery(".normal-section-title").html(event_manager_dj.i18n_currentEventsTitle);  
                     
                    if(localStorage.getItem("layout")=="box-layout") {                       
        	            jQuery("#current #line-layout-icon").addClass("lightgray-layout-icon");
        		        jQuery("#current #box-layout-icon").removeClass("lightgray-layout-icon");
		            } else {
		                jQuery("#current #line-layout-icon").removeClass("lightgray-layout-icon");
        		        jQuery("#current #box-layout-icon").addClass("lightgray-layout-icon");
		            }
                } else {
                    if(jQuery(".normal-section-title").length >0)
                       jQuery(".normal-section-title").html(event_manager_dj.i18n_upcomingEventsTitle);
                }
                event.preventDefault();
            }                        
        }
    }
};
DJs = DJs();
jQuery(document).ready(function ($) {
    DJs.init();
});