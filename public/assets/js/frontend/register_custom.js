$(document).ready(function(){
    $("input[type='checkbox'],input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });

$("#reg_form").bootstrapValidator({
    fields: {
        name: {
            validators: {
                notEmpty: {
                    message: 'Name is required'
                }
            },
            required: true,
            minlength: 3
        },
        
        email: {
            validators: {
                notEmpty: {
                    message: 'The email address is required'
                },
                regexp: {
                    regexp: /^(\w+)([\-+.\'0-9A-Za-z_]+)*@(\w[\-\w]*\.){1,5}([A-Za-z]){2,6}$/,
                    message: 'The input is not a valid email address'
                }
            }
        },
        password: {
            validators: {
                notEmpty: {
                    message: 'Password is required'
                },
                different: {
                    field: 'name',
                    message: 'Password should not match first/last Name'
                }
            }
        },
        password_confirmation: {
            validators: {
                notEmpty: {
                    message: 'Confirm Password is required'
                },
                identical: {
                    field: 'password'
                },
                different: {
                    field: 'name',
                    message: 'Confirm Password should match with password'
                }
            }
        }
    }
});
});

$('#reg_form input').on('keyup', function (){

    $('#reg_form input').each(function(){
        var pswd = $("#reg_form input[name='password']").val();
        var pswd_cnf = $("#reg_form input[name='password_confirmation']").val();
            if(pswd != '' ){
                $('#reg_form').bootstrapValidator('revalidateField', 'password');
            }
            if(pswd_cnf != '' ){
                $('#reg_form').bootstrapValidator('revalidateField', 'password_confirmation');
            }
    });
});