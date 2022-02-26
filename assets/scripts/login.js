var Login = function () {
    var handleLogin = function() {
		$('.login-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
	                username: {
	                    required: true
	                },
	                password: {
	                    required: true
	                },
	                remember: {
	                    required: false
	                }
	            },

	            messages: {
	                username: {
	                    required: "Username is required1."
	                },
	                password: {
	                    required: "Password is required2."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-danger', $('.login-form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('.login-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
	                    $('.login-form').submit();
	                }
	                return false;
	            }
	        });
	}

	var handleForgetPassword = function () {
		$('.forget-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                email: {
	                    required: true,
	                    email: true
	                }
	            },

	            messages: {
	                email: {
	                    required: "Email is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('.forget-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.forget-form').validate().form()) {
	                    $('.forget-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#forget-password').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.forget-form').show();
	        });

	        jQuery('#back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.forget-form').hide();
	        });

	}

	var handleRegister = function () {
        //console.log(site_url);
        
		function format(state) {
            if (!state.id) return state.text; // optgroup
            return "<img class='flag' src='assets/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
        }


		$("#select2_sample4").select2({
		  	placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
            allowClear: true,
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function (m) {
                return m;
            }
        });


			$('#select2_sample4').change(function () {
                $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
		
		var url      = window.location.origin;
		console.log(url);
        $.validator.addMethod("checkUsername", 
        function(value, element) {
            var result = false;
            $.ajax({
                type:"POST",
                async: false,
                url  : url+'/en/companies/C_newStore/checkUsername', // script to validate in server side
                data : $("#u_name").serialize(),
                success: function(data) {
                    console.log(data);
                    result = (data == 'true' ? false : true);
                    
                    //console.log($("#u_name").serialize());
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
            // return true if username is exist in database
            //console.log(result);
            return result; 
        }, 
        "This username is already taken! Try another."
    );
    
        var success1 = $('.alert-success');
        $("#register-submit-btn").show();
        $(".loading").hide();
                    
         $('.register-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                
	                name: {
	                    required: true
	                },
	                email: {
	                    required: true,
	                    email: true
	                },
	                address: {
	                    required: true
	                },
	                time_zone: {
	                    required: true
	                },
	                currency_id: {
	                    required: true
	                },
                    
                    contact_no:{
                        required:true
                    },
                    fy_start_date:{
                        required:true
                    },
                    fy_end_date:{
                        required:true
                    },
                    fy_year:{
                        required:true
                    },
	                u_name: {
	                    required: true,
                        minlength: 3,
                        maxlength:12,
                        checkUsername:true
                        //remote: {  // value of 'username' field is sent by default
//                            type: 'POST',
//                            url: 'http://localhost/khybersoft/pos1/en/companies/C_companies/hasLoginUsername'
//                        }
	                },
                    role: {
	                    required: true
	                },
	                password: {
	                    required: true,
                        minlength: 3,
                        maxlength:12,
	                },
	                rpassword: {
	                   minlength: 3,
                        maxlength:12,
	                    equalTo: "#register_password"
	                },

	                tnc: {
	                    required: true
	                }
	            },

	            messages: { // custom messages for radio buttons and checkboxes
	                tnc: {
	                    required: "Please accept TNC first."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
                    $("#register-submit-btn").show();
                    $(".loading").hide();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
	                    error.insertAfter($('#register_tnc_error'));
	                } else if (element.closest('.input-icon').size() === 1) {
	                    error.insertAfter(element.closest('.input-icon'));
	                } else {
	                	error.insertAfter(element);
	                }
	            },

	            submitHandler: function (form) {
	               
                   $("#register-submit-btn").hide();
                   $(".loading").show();
	               
                    $.ajax({
            				type : 'POST',
            				url  : $('#url').val(),
            				data : $('.register-form').serialize(),
                            success : function(data)
            						  {
            						      console.log($('#url').val());
    						              $("#success-msg").show();
                                          $("#register-submit-btn").show();
                                          $(".loading").hide();  
                                          jQuery('.register-form').hide();
                                          jQuery('.login-form').show();
                                          
                                          console.log(data);
                                          //window.location.href = $('#url').val();
            					      },
                            error: function (request, status, error) {
                                        console.log(request);
                                        console.log(error);
                                    }
            				});
                    return false; // required to block normal submit since you used ajax
        
	            }
	        });

			$('.register-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.register-form').validate().form()) {
	                    $('.register-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#register-btn').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.register-form').show();
                //alert('You are not a premuim user. please contact the vendor');
	        });

	        jQuery('#register-back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.register-form').hide();
	        });
	}
    
    return {
        //main function to initiate the module
        init: function () {
            handleLogin();
            handleForgetPassword();
            handleRegister();        
	       
        }

    };

}();