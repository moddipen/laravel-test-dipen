"use strict";
$(document).ready(function () {
    $(".wrapper").addClass("hide_menu");
    var form = $("#form");
    form.steps({
        headerTag: "h6",
        bodyTag: "div",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {
            // Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex) {
                return true;
            }
            // Forbid next action on "Warning" step if the user is to young
            if (newIndex === 3 && Number($("#age-2").val()) < 18) {
                return false;
            }
            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex) {
                // To remove error styles
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            $('#btnGenerate').click();
        }
    }).validate({
        errorPlacement: function errorPlacement(error, element) {
            element.before(error);
        }
    });

    $('#form4').bootstrapValidator({
        fields: {
            model_name: {
                validators: {
                    notEmpty: {
                        message: 'Model name is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z']*$/,
                        message: 'The modal name can consist of characters only'
                    }
                }
            },
            myClass: {
                selector: '.txtFieldName',
                validators: {
                    notEmpty: {
                        message: 'required'
                    }
                }
            }

        }
    });

    $(document.body).on("change", ".txtdbType", function () {
        $('this').closest('tr').find('.txtdbType .date').attr('disabled', true);
        $('.txtdbType').closest('tr').find('.textarea').attr('disabled', true);
        var db_type = $(this).val();
        if (db_type == 'text') {
            $('.txtdbType').closest('tr').find('.date').attr('disabled', false);
            $('.txtdbType').closest('tr').find('.textarea').attr('disabled', false);
        }
    });
    $(document.body).on("change", ".drdHtmlType", function () {
        var html_radio = $(this).val();
        if (html_radio == 'radio' || html_radio == 'select' || html_radio == 'checkbox') {
            $(this).closest('td').find('.htmlValue').css('display', 'block');
        } else {
            $(this).closest('td').find('.htmlValue').css('display', 'none');
        }

    });


    $(".txtValidation").select2({
        tags: true,
        maximumSelectionLength: 2,
        dropdownAutoWidth: true,
        closeOnSelect: false
    });
    $(".txtdbType").select2({
        width: '100%'
    });
    $(".drdHtmlType").select2({
        width: '100%'
    });

    $('.txtdbType').closest('tr').find('.textarea').attr('disabled', true);

    $(document.body).on("change", ".txtdbType", function () {

        $(".drdHtmlType").select2({
            width: '100%'
        });
        var selected_dbtype = $(this).closest('tr').find('.txtValidation').val();
        var db_type = $(this).val();
        var html_type = $(this).closest('tr').find('.drdHtmlType').val();

        if (db_type == 'text') {
            $('.txtdbType').closest('tr').find('.textarea').attr('disabled', false);
        }
        if (db_type == 'boolean') {
            $(this).closest('tr').find('.drdHtmlType').val('checkbox').change();
            $(this).closest('tr').find(".email").prop('disabled', true);
            $(this).closest('tr').find(".integer").prop('disabled', true);
            $(this).closest('tr').find(".date").prop('disabled', true);
            $(this).closest('tr').find(".text").prop('disabled', true);
            $('.txtdbType').closest('tr').find('.checkbox').attr('disabled', false);
            $(this).closest('tr').find('.drdHtmlType option').not('.checkbox').attr('disabled', true);

        }
        if (db_type == 'date') {
            $(this).closest('tr').find('.drdHtmlType').val('date').change();
            $(this).closest('tr').find(".email").prop('disabled', true);
            $(this).closest('tr').find(".integer").prop('disabled', true);
            $(this).closest('tr').find(".text").prop('disabled', true);
            $(this).closest('tr').find('.drdHtmlType option').not('.date').attr('disabled', true);

        }
        if ((db_type != 'text' && html_type == 'textarea') || (db_type != 'boolean' && html_type == 'checkbox' )) {
            $(this).closest('tr').find('.drdHtmlType').val('text').change();
            $(".drdHtmlType").select2({
                width: '100%'
            });
        }
        if (db_type != 'boolean' && html_type == 'checkbox') {
            $(this).closest('tr').find('.drdHtmlType').val('text').change();
            $(".drdHtmlType").select2({
                width: '100%'
            });
        }
    });
    $(document.body).on("change", ".txtValidation", function () {
        var selected_validation = $(this).closest('tr').find('.txtValidation').val();
        var data2 = $('.txtValidation').select2('data').map(function (elem) {
            return elem.text
        });
        $(".txtValidation").select2({
            maximumSelectionLength: 2,
            dropdownAutoWidth: true
        });
        if (selected_validation == 'email') {
            $(this).closest('tr').find(".date").prop('disabled', true);
            $(this).closest('tr').find(".boolean").prop('disabled', true);
            $(this).closest('tr').find(".integer").prop('disabled', true);
        }
        else if (selected_validation == 'date') {
            $(this).closest('tr').find(".email").prop('disabled', true);
            $(this).closest('tr').find(".boolean").prop('disabled', true);
            $(this).closest('tr').find(".integer").prop('disabled', true);
        }
        else if (selected_validation == 'integer') {
            $(this).closest('tr').find(".email").prop('disabled', true);
            $(this).closest('tr').find(".boolean").prop('disabled', true);
            $(this).closest('tr').find(".date").prop('disabled', true);
        }
        else if (selected_validation == 'boolean') {
            $(this).closest('tr').find(".email").prop('disabled', true);
            $(this).closest('tr').find(".integer").prop('disabled', true);
            $(this).closest('tr').find(".date").prop('disabled', true);
        }
        else {
            $(this).closest('tr').find(".email").prop('disabled', false);
            $(this).closest('tr').find(".integer").prop('disabled', false);
            $(this).closest('tr').find(".date").prop('disabled', false);
            $(this).closest('tr').find(".boolean").prop('disabled', false);
        }

    });

    var fieldIdArr = [];
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        $("#drdCommandType").on("change", function () {
            if ($(this).val() == "infyom:scaffold") {
                $('#chSwag').hide();
                $('#chTest').hide();
            }
            else {
                $('#chSwag').show();
                $('#chTest').show();
            }
        });


        $(document).ready(function () {
            var htmlStr = '<tr class="item" style="display: table-row;"></tr>';
            var commonComponent = $(htmlStr).filter("tr").load(componentUrl);

            setTimeout(function () {
                $("#btnAdd").trigger('click');
            }, 200);


            $("#btnAdd").on("click", function () {
                var item = $(commonComponent).clone();
                initializeCheckbox(item);
                $("#container").append(item);
                //Initializing trash liveicon
                $('.remove').updateLivicon();
                $('#table tr:last').find('.textarea').attr('disabled', true);

            });
            $('.chkPrimary').on('click', function () {
                var item = $(commonComponent).clone();
                initializeCheckbox(item);
            });

            $("#btnTimeStamps").on("click", function () {
                var item_created_at = $(commonComponent).clone();
                $(item_created_at).find('.txtFieldName').val("created_at");
                renderTimeStampData(item_created_at);
                initializeCheckbox(item_created_at);
                $("#container").append(item_created_at);


                var item_updated_at = $(commonComponent).clone();
                $(item_updated_at).find('.txtFieldName').val("updated_at");
                renderTimeStampData(item_updated_at);
                initializeCheckbox(item_updated_at);
                $("#container").append(item_updated_at);
            });

            $("#btnPrimary").on("click", function () {
                var item = $(commonComponent).clone();
                renderPrimaryData(item);
                initializeCheckbox(item);
                $("#container").append(item);
            });

            $("#btnModalReset").on("click", function () {
                location.reload();
            });

            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            $('#txtModelName').on('blur', function () {
                var modelname = {
                    modelName: capitalizeFirstLetter($('#txtModelName').val())
                }
                $.ajax({
                    url: modelCheckUrl,
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify(modelname),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.status == false) {
                            swal({
                                title: 'error',
                                text: result.message,
                                type: "error",
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true
                            });
                            $('#btnGenerate').prop('disabled', true);
                        }
                        else {
                            $('#btnGenerate').prop('disabled', false);
                        }

                    },
                });
            });

            $('#btnGenerate').on('click', function () {

                var fieldCheck = true;
                $('table > tbody  > tr').each(function () {
                    var fieldName = $(this).find('.txtFieldName').val();
                    if (fieldName == '') {
                        fieldCheck = false;
                        swal(
                            'Oops...',
                            'You must fill field name!',
                            'error'
                        );
                        return false;
                    }
                });
                if (fieldCheck == false) {
                    return false;
                }
                var fieldArr = [];
                var validationArray, validationString;
                $('#btnReset').prop('disabled', true);
                $('#btnGenerate').prop('disabled', true);
                var primaryKey = '';
                $('.item').each(function () {

                    var htmlType = $(this).find('.drdHtmlType');
                    var htmlValue = "";
                    if ($(htmlType).val() == "select" || $(htmlType).val() == "radio" || $(htmlType).val() == "checkbox") {
                        htmlValue = $(this).find('.drdHtmlType').val() + ':' + $(this).find('.txtHtmlValue').val();
                    }
                    else {
                        htmlValue = $(this).find('.drdHtmlType').val();
                    }
                    validationArray = $(this).find('.txtValidation').val();

                    if (validationArray == null) {
                        validationString = '';
                    }
                    else
                        validationString = validationArray.join('|');

                    var primarycheck = $(this).find('.chkPrimary').prop('checked');
                    if (primarycheck == true) {
                        primaryKey = $(this).find('.txtFieldName').val();
                    }

                    fieldArr.push({
                        fieldInput: $(this).find('.txtFieldName').val() + ':' + $(this).find('.txtdbType').val(),
                        htmlType: htmlValue,
                        validations: validationString,
                        searchable: $(this).find('.chkSearchable').prop('checked'),
                        fillable: $(this).find('.chkFillable').prop('checked'),
                        primary: $(this).find('.chkPrimary').prop('checked'),
                        inForm: $(this).find('.chkInForm').prop('checked'),
                        inIndex: $(this).find('.chkInIndex').prop('checked')
                    });
                });
                //check if atleast one field added or not
                if (fieldArr.length == 0) {
                    swal(
                        'Oops...',
                        'You must add atleast one field!',
                        'error'
                    );
                    throw new Error();
                }

                fieldArr.unshift({
                    fieldInput: 'id:increments',
                    htmlType: validationString,
                    validations: false,
                    searchable: false,
                    fillable: false,
                    primary: true,
                    inForm: false,
                    inIndex: false
                });


                var data = {
                    modelName: capitalizeFirstLetter($('#txtModelName').val()),
                    commandType: $('#drdCommandType').val(),
                    tableName: $('#txtCustomTblName').val(),
                    iconName: $('#leftMenuIcons').val(),
                    iconColor: $('#iconColor').val(),
                    prefix: $('#txtPrefix').val(),
                    primary: primaryKey,
                    paginate: $('#txtPaginate').val(),
                    migrate: $('#chkMigrate').prop('checked'),
                    options: {
                        softDelete: $('#chkDelete').prop('checked'),
                        save: $('#chkSave').prop('checked'),
                        swagger: $('#chkSwagger').prop('checked'),
                        tests: $('#chkTestCases').prop('checked'),
                        datatables: $('#chkDataTable').prop('checked')
                    },
                    fields: fieldArr
                };

                data['_token'] = $('#token').val();


                $.ajax({
                    url: generateUrl,
                    type: "POST",
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function (result) {
                        swal({
                                title: 'success',
                                text: result,
                                type: "success",
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true
                            },
                            function () {
                                setTimeout(function () {
                                    location.reload();
                                }, 1500);
                            });
                        $('#btnReset').prop('disabled', false);
                    },
                    error: function () {
                        swal(
                            'Oops...',
                            'Something went wrong!',
                            'error'
                        )
                        $('#btnReset').prop('disabled', false);
                    }
                });

                return false;
            });

            function renderPrimaryData(el) {

                $('.chkPrimary').iCheck(getiCheckSelection(false));

                $(el).find('.txtFieldName').val("id");
                $(el).find('.txtdbType').val("increments");
                $(el).find('.chkSearchable').attr('checked', false);
                $(el).find('.chkFillable').attr('checked', false);
                $(el).find('.chkPrimary').attr('checked', true);
                $(el).find('.chkInForm').attr('checked', false);
                $(el).find('.chkInIndex').attr('checked', false);
            }

            function renderTimeStampData(el) {
                $(el).find('.txtdbType').val("timestamp");
                $(el).find('.chkSearchable').attr('checked', false);
                $(el).find('.chkFillable').attr('checked', false);
                $(el).find('.chkPrimary').attr('checked', false);
                $(el).find('.chkInForm').attr('checked', false);
                $(el).find('.chkInIndex').attr('checked', false);
                $(el).find('.drdHtmlType').val('date').trigger('change');
            }

        });

        function initializeCheckbox(el) {
            // $(el).find('input:checkbox').iCheck({
            //     checkboxClass: 'icheckbox_square-blue',
            //     radioClass: 'iradio_square-blue'
            // });
            setTimeout(function(){
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
            $(el).find("select").select2({width: '100%'});

            $(el).find(".chkPrimary").on("ifClicked", function () {
                $('.chkPrimary').each(function () {
                    $(this).iCheck('uncheck');
                });
            });

            $(el).find(".chkPrimary").on("ifChanged", function () {
                if ($(this).prop('checked') == true) {
                    $(el).find(".chkSearchable").iCheck('uncheck');
                    $(el).find(".chkFillable").iCheck('uncheck');
                    $(el).find(".chkInForm").iCheck('uncheck');
                }
            });

            var htmlType = $(el).find('.drdHtmlType');

            $(htmlType).select2().on('change', function () {
                if ($(htmlType).val() == "select" || $(htmlType).val() == "radio")

                    $(el).find('.htmlValue').show();
                else
                    $(el).find('.htmlValue').hide();
            });


        }


    });

    function getiCheckSelection(value) {
        if (value == true)
            return 'checked';
        else
            return 'uncheck';
    }

    function removeItem(e) {
        e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
    }

    $('#txtModelName').on('keyup', function () {
        var modalName = $('#txtModelName').val();
        var tableName = modalName.concat('s');
        $('#txtCustomTblName').val(tableName);
        $('#txtCustomTblName').css('text-transform', 'lowercase');
        if (modalName == '') {
            $('#txtCustomTblName').val('');
        }
    });
    $('.livicon').on('click', function () {
        var icon_name = $(this).attr('data-name');
        $('#leftMenuIcons').val(icon_name);
        $('#iconsModal').modal('hide');

    });
    $(function () {

        $('.txtHtmlValue').on('keypress', function (e) {
            if (e.which == 32)
                return false;
        });
        $("#txtModelName").on('keydown', function (e) {
            var key = e.keyCode;
            return ((key >= 65 && key <= 90) || key == 8);

        });
        $("body").on('keypress', '.txtFieldName', function (e) {
            var x = $(this).val() + String.fromCharCode(e.charCode);
            if (e.charCode == 0) {
                return;
            }
            if (x.match(/^\w+$/) == null) {
                e.preventDefault();
            }
        });

    });

});
