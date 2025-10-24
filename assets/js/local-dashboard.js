var localDashboard= function () {
    /// <summary>Constructor function of the event localDashboard class.</summary>
    /// <returns type="Home" />      
    return {
	    ///<summary>
        ///Initializes the event dashboard.  
        ///</summary>     
        ///<returns type="initialization settings" />   
        /// <since>1.0.0</since> 
        init: function() {
	  	    Common.logInfo("localDashboard.init...");  
	  	    if(jQuery('.event-dashboard-action-delete').length >0) {
				jQuery('.event-dashboard-action-delete').css({'cursor':'pointer'});  					
				//for delete event confirmation dialog / tooltip 
				jQuery('.event-dashboard-action-delete').on('click', localDashboard.confirmation.showDialog);	
	        }

	        if(jQuery('.event-local-count').length >0) {				
				//show event list dialog / tooltip 
				jQuery('.event-local-count').on('click', function(){
					jQuery(this).next('.local-events-list').slideToggle();
				});	
	        }
 	 	}, 
		confirmation:{	    
             /// <summary>
	        /// Show bootstrap third party confirmation dialog when click on 'Delete' options on event dashboard page where show delete event option.	     
	        /// </summary>
	        /// <param name="parent" type="assign"></param>           
	        /// <returns type="actions" />     
	        /// <since>1.0.0</since>       
	        showDialog: function(event) {
	        	Common.logInfo("localDashboard.confirmation.showDialog...");	            
	           	return confirm(event_manager_local_dashboard.i18n_confirm_delete);
	           	event.preventDefault(); 
	        },
	    }		 //end of comfirmation	 
    } //enf of return	
}; //end of class

localDashboard= localDashboard();
jQuery(document).ready(function($) {
   localDashboard.init();
});