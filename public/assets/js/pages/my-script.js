"use strict"

//COMPRUEBA SI YA EXISTE EL CORREO
$('#user_correo').change(function (e) {
        let email = $(this).val();
        console.log(email);
        $.ajax({
            type: "POST",
            url: consulta_email,
            data: {email: email},
            success: function (respuesta) {
                if (respuesta.error == true) {
                    $(".emailuser").html(respuesta.message);
                    $('.emailuser').css("display", "block");
                } else {
                    $('.emailuser').css("display", "none");
                }
            },
            error: function () {
                console.log("No se ha podido obtener la información");
            }
        });
    }
)
;

//MUESTRA LA PANTALLA MODAL DE UN SERVER EN CONCRETO
$('.detalle-btn').click(function () {
        let value = $(this).data('value');
        console.log(value);
        $.ajax({
            type: "POST",
            url: url_cargar_servidores,
            data: {id: value},
            success: function (respuesta) {
                $('#titulo').append(respuesta.alias);
                $('#nombrevps').text(respuesta.nombrevps);
                $('#alias').text(respuesta.alias);
                $('#ip').text(respuesta.ip);
                $('#urlacceso').text(respuesta.urlacceso);
                $('#usuario').text(respuesta.usuario);
                $('#psw').text(respuesta.psw);
                $('#tipo').text(respuesta.tipo);
            },
            error: function () {
                console.log("No se ha podido obtener la información");
            }
        });
    }
)
;

$('#test_customer').ready(function () {
    var ruta = window.location.pathname;
    //console.log(ruta);
    var vars = ruta.split("/");
    let valor = parseInt(vars[vars.length - 1]);
    //console.log(isNaN(valor));

    //SI NO VIENE DE EDIT ENTRA
    if (isNaN(valor)) {
        //console.log("entra")
        $.ajax({
            type: "POST",
            url: url_cargar_tests_default,//'/wiip/public/index.php/proyectos/default',
            success: function (respuesta) {
                $('#test_project').html('');
                let cont = 0;
                for (let value of respuesta) {
                    if (cont == 0) {
                        $('#test_project').append('<option value="' + value.id + '" selected>' + value.alias + '</option>')
                    } else {
                        $('#test_project').append('<option value="' + value.id + '">' + value.alias + '</option>')
                    }

                }
            },
            error: function () {
                //console.log("No se ha podido obtener la información");
            }
        });
    }

});

$('#test_customer').click(function () {
    let valor = $('#test_customer').val();
    //console.log(valor);
    if (valor !== null && valor !== undefined && valor !== '') {
        $.ajax({
            type: "POST",
            url: url_cargar_tests,
            data: {id: valor},
            success: function (respuesta) {
                console.log(respuesta);
                $('#test_project').prop('disabled', false);
                //Borro todo el contenido del select
                $('#test_project').html('');
                for (let value of respuesta) {
                    $('#test_project').append('<option value="' + value.id + '">' + value.alias + '</option>')
                }
            },
            error: function () {
                //console.log("No se ha podido obtener la información");
            }
        });
    }

});

//AÑADIR BLOQUE
function isEmpty(a) {
    if (a === '' || a === null || a === undefined) {
        return true;
    } else {
        return false;
    }
}

$('#addblock').click(function (e) {
    e.preventDefault();
    if ($('#test_blocks___name___alias').val() !== null && $('#test_blocks___name___alias').val() !== "" && $('#test_blocks___name___position').val() !== null && $('#test_blocks___name___position').val() !== "") {
        //console.log("hola");
        $.ajax({
            type: "POST",
            url: url_blocks,
            data: {
                alias: $('#test_blocks___name___alias').val(),
                position: $('#test_blocks___name___position').val(),
                padre: $('#test_blocks___name___bloque_padre').val()
            },
            success: function (r) {
                //console.log(r);
                $('#form_test').submit();
            },
            error: function () {
                console.log("No se ha podido obtener la información");
            }
        });
    } else {
        console.log("adios");
        $('#form_test').submit();
    }
});

$(".denegar").click(function (e) {
    e.preventDefault();
    Swal.fire("La pregunta esta desactivada");
});
$(".disabled-test").click(function (e) {
    Swal.fire("El Test ha sido desactivado");
});

$(".no-questions").click(function (e) {
    Swal.fire("El Test no tiene ninguna pregunta");
});


//MANYTOMANY de USER y CUSTOMER
$('select[name="users[]"]').bootstrapDualListbox();
$('select[name="customers[]"]').bootstrapDualListbox();

$(document).ready(function () {
    var sPaginaURL = window.location.pathname;
    var sURLVariables = sPaginaURL.split('/');
    var id = sURLVariables[sURLVariables.length - 1];
    //console.log(sURLVariables[sURLVariables.length - 1]);

    //ELIMINAR UN USUARIO
    $('.deleteuser').click(function (e) {
        e.preventDefault();
        let user = $(this).attr('href');
        console.log(user);
        $.confirm({
            title: 'Eliminar!',
            content: '¿Estas seguro de que deseas eliminarlo?',
            buttons: {
                ok: {
                    action: function () {
                        //e.preventDefault();
                        window.location.href = user;
                    }
                },
                cancel: function () {
                    //e.preventDefault()
                }
            }
        });
    });

    //ELIMINAR UN CLIENTE
    $('.deletecustomer').click(function (e) {
        e.preventDefault();
        let customer = $(this).attr('href');
        $.confirm({
            title: 'Eliminar!',
            content: '¿Estas seguro de que deseas eliminarlo?',
            buttons: {
                ok: {
                    action: function () {
                        //e.preventDefault();
                        window.location.href = customer;
                    }
                },
                cancel: function () {
                }
            }
        });
    });

    //ELIMINAR UN PROYECTO
    $('.deleteproject').click(function (e) {
        e.preventDefault();
        let project = $(this).attr('href');
        $.confirm({
            title: 'Eliminar!',
            content: '¿Estas seguro de que deseas eliminarlo?',
            buttons: {
                ok: {
                    action: function () {
                        window.location.href = project;
                    }
                },
                cancel: function () {
                }
            }
        });
    });

    //ELIMINAR UN SERVER
    $('.deleteserver').click(function (e) {
        e.preventDefault();
        let server = $(this).attr('href');
        $.confirm({
            title: 'Eliminar!',
            content: '¿Estas seguro de que deseas eliminarlo?',
            buttons: {
                ok: {
                    action: function () {
                        window.location.href = server;
                    }
                },
                cancel: function () {
                }
            }
        });
    });

    //RECORRE TODOS LOS INPUT QUE CONTENGAN EN EL NAME DESCRIPTION
    $('input[name*="description"]').each(function () {
        //console.log($(this));
        $(this).rules('add', {
            required: true,
            maxlength: 50,
            messages: {
                required: "El campo el obligatorio",
                maxlength: "Debe tener menos de 50 caracteres"
            }
        });
    });

    //RECORRE TODOS LOS INPUTS QUE CONTENGAN EN EN EL NAME IMAGE
    $('.add-image').each(function () {
        console.log($(this));
        $(this).rules('add', {
            //required: false,
            fileValidation: true,
            sizeNewValidation: true,
            messages: {
                fileValidation: "Debe ser una imagen en JPG JPEG PNG",
                sizeNewValidation: "La imagen no debe exceder de 1 MB"
            }
        });
    })

    //BOTON DE AÑADIR QUESTION
    $('.add-question').on('click', function () {
        $('input[name*="description"]').each(function () {
            console.log($('input[name*="description"]'));
            $(this).rules('add', {
                required: true,
                maxlength: 50,
                messages: {
                    required: "El campo el obligatorio",
                    maxlength: "Debe tener menos de 50 caracteres"
                }
            });
        });

        $('input[name*="image"]').each(function () {
            console.log($(this));
            $(this).rules('add', {
                //required: false,
                fileValidation: true,
                sizeNewValidation: true,
                messages: {
                    fileValidation: "Debe ser una imagen en JPG JPEG PNG",
                    sizeNewValidation: "La imagen no debe exceder de 1 MB"
                }
            });
        })
    })

    $('#recuperarPassword').click(function (e){
        e.preventDefault();
        Swal.fire("El Test no tiene ninguna pregunta");
    })

});

//VALIDACIONES DEL FORM USER
$("#form_user").validate({
    rules: {
        'user[nombre]': {
            required: true,
            maxlength: 50
        },
        'user[correo]': {
            required: true,
            email: true
        },
        'user[password]': {
            required: true,
            minlength: 4
        }
    },
    messages: {
        'user[nombre]': {
            required: "El campo es obligatorio",
            maxlength: "El campo debe tener menos de 50 caracteres"
        },
        'user[correo]': {
            required: "El campo es obligatorio",
            email: "Introduce un email correcto"
        },
        'user[password]': {
            required: "El campo es obligatorio",
            minlength: "El password requiere 4 caracteres como mínimo"
        },
    },

    focusInvalid: false,
    invalidHandler: function (form, validator) {
        if (!validator.numberOfInvalids())
            return;
        $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top - 200
        }, 1000);

    },
});

//VALIDACION DEL FORM CUSTOMER
$('#form_customer').validate({
    rules: {
        'nombre': {
            required: true,
            maxlength: 50
        },
        'alias': {
            required: true,
            maxlength: 50
        },
        'contacto': {
            required: true,
            maxlength: 50
        },
        'email': {
            required: true,
            email: true
        }
    },
    messages: {
        'nombre': {
            required: "El campo es obligatorio",
            maxlength: "El campo debe tener menos de 50 caracteres"
        },
        'alias': {
            required: "El campo es obligatorio",
            maxlength: "El campo debe tener menos de 50 caracteres"
        },
        'contacto': {
            required: "El campo es obligatorio",
            maxlength: "El campo debe tener menos de 50 caracteres"
        },
        'email': {
            required: "El campo es obligatorio",
            email: "No es un email correcto"
        }
    },

    focusInvalid: false,
    invalidHandler: function (form, validator) {
        if (!validator.numberOfInvalids())
            return;
        $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top - 200
        }, 1000);

    },
});

//VALIDACIONES DEL FORM PROJECT
$('#form_project').validate({
    rules: {
        date: {
            required: true,
        },
        'project[alias]': {
            required: true,
            maxlength: 50
        },
        urltest: {
            required: true,
            minlength: 10
        },
        urlprod: {
            required: true,
            minlength: 10
        },
    },
    messages: {
        date: {
            required: "El campo es obligatorio",
        },
        'project[alias]': {
            required: "El campo es obligatorio",
            maxlength: "Debe contener menos de 50 caracteres"
        },
        urltest: {
            required: "El campo es obligatorio",
            minlength: "La URL de test debe ser correta"
        },
        urlprod: {
            required: "El campo es obligatorio",
            minlength: "La URL de producción debe ser correcta"
        },
    },
    focusInvalid: false,
    invalidHandler: function (form, validator) {
        if (!validator.numberOfInvalids())
            return;
        $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top - 200
        }, 1000);

    },
});

//VALIDACION DEL FORM TEST
$('#form_test').validate({
    rules: {
        'test[alias]': {
            required: true,
            maxlength: 50
        },
    },
    messages: {
        'test[alias]': {
            required: "El campo es obligatorio",
            maxlength: "Debe contener menos de 50 caracteres"
        },
    },
    focusInvalid: false,
    invalidHandler: function (form, validator) {
        if (!validator.numberOfInvalids())
            return;
        $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top - 200
        }, 1000);

    },
});

//VALIDACION DEL FORM BLOCK
$('#form_block_edit').validate({
    rules: {
        'block[alias]': {
            required: true,
            maxlength: 50
        },
        'block[position]': {
            required: true,
            digits: true
        },
    },
    messages: {
        'block[alias]': {
            required: "El campo es obligatorio",
            maxlength: "Debe conetener menos de 50 caracteres"
        },
        'block[position]': {
            required: "El campo es obligatorio",
            digits: "Debe contener numeros enteros y positivos"
        },
    }
});

//VALIDACION DE LA QUESTION
$('#form_question').validate();

//VALIDA LA EXTENSION DE LA IMAGEN
$.validator.addMethod('fileValidation', function (value) {
    var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
    if (!allowedExtensions.exec(value)) {
        if (value == '' || value == null || value == undefined) {
            return true;
        }
        return false;
    } else {
        return true;
    }
});

//VALIDATION SIZE FILE EDITION
$.validator.addMethod('sizeValidation', function (value, element, param) {
    console.log(value,element,param);
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0}');

/*$.validator.addMethod('sizeValidation', function (value, e) {

    if (value !== '' && value !== '' && value !== "undefined") {
        if (fileInput[0].files[0].size > 1000000) {
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
});*/

//EDITION QUESTION
$.validator.addMethod('sizeNewValidation', function (value, e) {
    let fileInput = document.getElementsByName(e.name);
    console.log(fileInput[0].files.length);
    if (fileInput[0].files.length > 0) {
        console.log(fileInput[0].files[0].size);
        if (fileInput[0].files[0].size > 1000000) {
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
});

//VALIDACION DE LA EDITION DE LA QUESTION
$('#form_question_edit').validate({
    rules: {
        'question[description]': {
            required: true,
            maxlength: 50
        },
        'image': {
            required: false,
            fileValidation: true,
            sizeValidation: 1000000,
        }
    },
    messages: {
        'question[description]': {
            required: "El campo es obligatorio",
            maxlength: "Debe tener menos de 50 caracteres"
        },
        'image': {
            fileValidation: "Debe ser una imagen en JPG JPEG PNG",
            sizeValidation: "La imagen no debe exceder de 1 MB"
        }
    }
});

//VALIDACION DE LA IP
$.validator.addMethod('IP4Checker', function (value) {
    var ip = "^([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3})$";
    return value.match(ip);
}, 'Invalid IP address');

//VALIDACION DEL SERVER
$('#form_server').validate({
    rules: {
        'server[nombrevps]': {
            required: true,
            maxlength: 50
        },
        'server[alias]': {
            required: true,
            maxlength: 50
        },
        'server[ip]': {
            required: true,
            IP4Checker: true
        },
        'server_urlacceso': {
            required: true,
            minlength: 10
        },
        'server[usuario]': {
            required: true,
            maxlength: 50
        },
        'password': {
            required: true,
            minlength: 4
        },
        'passwordrepeated': {
            required: true,
            equalTo: "#password",
        }
    },
    messages: {
        'server[nombrevps]': {
            required: "No puede estar vacio el campo",
            maxlength: "No puede contener mas de 50 caracteres"
        },
        'server[alias]': {
            required: "No puede estar vacio el campo",
            maxlength: "No puede contener mas de 50 caracteres"
        },
        'server[ip]': {
            required: "No puede estar vacio el campo",
            IP4Checker: "La IP debe ser correcta"
        },
        'server_urlacceso': {
            required: "No puede estar vacio el campo",
            minlength: "La URL de acceso debe ser correta"
        },
        'server[usuario]': {
            required: "No puede estar vacio el campo",
            maxlength: "No puede contener mas de 50 caracteres"
        },
        'password': {
            required: "No puede estar vacio el campo",
            minlength: "Debe contener como mínimo 4 caracteres"
        },
        'passwordrepeated': {
            required: "No puede estar vacio el campo",
            equalTo: "Las dos passwords deber coincidir",
        }

    },
    focusInvalid: false,
    invalidHandler: function (form, validator) {
        if (!validator.numberOfInvalids())
            return;
        $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top - 200
        }, 1000);

    },
});

$('#urltest').val("http://");
$('#urlprod').val("http://");
$('#server_urlacceso').val("http://");

$('#cancelar').on('click', function () {
    window.history.back();
});

