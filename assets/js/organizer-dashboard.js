var DJDashboard= function () {
    /// <summary>Constructor function of the event DJDashboard class.</summary>
    /// <returns type="Home" />      
    return {
	    ///<summary>
        ///Initializes the event dashboard.  
        ///</summary>     
        ///<returns type="initialization settings" />   
        /// <since>1.0.0</since> 
        init: function() {
          
	  	    Common.logInfo("DJDashboard.init...");  
	  	    if(jQuery('.event-dashboard-action-delete').length >0)  {
				jQuery('.event-dashboard-action-delete').css({'cursor':'pointer'});  					
				//for delete event confirmation dialog / tooltip 
				jQuery('.event-dashboard-action-delete').on('click', DJDashboard.confirmation.showDialog);	
	        }

	        if(jQuery('.event-dj-count').length >0) {				
				//show event list dialog / tooltip 
				jQuery('.event-dj-count').on('click', function(){
					jQuery(this).next('.dj-events-list').slideToggle();
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
	        	Common.logInfo("DJDashboard.confirmation.showDialog...");	            
	           	return confirm(event_manager_dj_dashboard.i18n_confirm_delete);
	           	event.preventDefault(); 
	        },
	    }		 //end of comfirmation	 
    } //enf of return	
}; //end of class

DJDashboard= DJDashboard();
jQuery(document).ready(function($) {
   DJDashboard.init();
});