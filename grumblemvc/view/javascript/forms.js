var options = {
  inputs: {
    'username': {
      filters: 'required username exclude max ajax',
      data: { exclude: ['user', 'username', 'admin', 'moderator'], max:15,
	      ajax: {
	      		url: 'index.php?controller=user&action=usernamevalidate&id=',
				_success: function( resp, text, xhr ) {
				  // The request was succesful
				},
				_error: function( xhr, text, error ) {
					alert(xhr);
				  // The request failed  
				}
	      	},
	      	errors: {
	      		ajax: {
	      			success: 'Username not available.',
	      			error: 'Sorry, there was an error on the server. Try again later.'
	      		}
	      	} 
	      }
    },
    'firstname': {
      filters: 'required max',
      data: { max: 50 }
    },
    'lastname': {
      filters: 'required max',
      data: { max: 50 }
    },
    'email': {
      filters: 'email required max ajax',
      data: { max: 100,
      	ajax: {
      		url: 'index.php?controller=user&action=emailvalidate&id=',
			_success: function( resp, text, xhr ) {
			  // The request was succesful
			},
			_error: function( xhr, text, error ) {
			
			  // The request failed  
			}
      	},
      	errors: {
      		ajax: {
      			success: 'Username not available.',
      			error: 'Sorry, there was an error on the server. Try again later.'
      		}
      	} 
      }
    },
    'password': {
      filters: 'required pass max',
      data: { max: 100 }
    },
    'password2': {
      filters: 'equalto required',
      data: { equalto: "#userpassword" }
    },
    'tz': {
      filters: 'exclude',
      data: { exclude: 'Select Timezone' }
    },
    'terms': {
      filters: 'min',
      data: { min: 1 }
    }
  }
};

var $myform = $('#userForm').idealforms( options ).data('idealforms');