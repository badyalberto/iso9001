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


//VALIDACION DEL CORREO DEL CUSTOMER
/*$('#customer_pmmail').blur(function () {
        let valor = $('#customer_pmmail').val();
        if (/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(valor)) {
            $('.emailcustomer').css("display", "none");
        } else {
            $(".emailcustomer").html("El campo email no es valido");
            $('.emailcustomer').css("display", "block");
        }
    }
)
;*/

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

/*$('#test_customer').blur(function () {
    $('#test_customer').removeClass('is-invalid');
    $('#cliente').removeClass('invalid-feedback');
});

$('#test_project').blur(function () {
    $('#test_project').removeClass('is-invalid');
    $('#proyecto').removeClass('invalid-feedback');
});

$('#errorblock').blur(function () {
    $('#errorblock').removeClass('invalid-feedback');
    $('#errorblock').addClass('failed_block');
});*/


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
        console.log("hola");
        $.ajax({
            type: "POST",
            url: url_blocks,
            data: {
                alias: $('#test_blocks___name___alias').val(),
                position: $('#test_blocks___name___position').val(),
                padre: $('#test_blocks___name___bloque_padre').val()
            },
            success: function (r) {
                console.log("funciona2");
                console.log(r);
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
$("#disabled-test").click(function (e) {
    Swal.fire("El Test ha sido desactivado");
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


})

//VALIDACIONES DEL FORM USER
$("#form_user").validate({
    rules: {
        'user[password]': {
            required: true,
            minlength: 4
        }
    },
    messages: {
        'user[password]': "El password requiere 4 caracteres como mínimo"
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
        urltest: "La URL de test debe ser correta",
        urlprod: "La URL de producción debe ser correcta"
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
            required: true
        },
        'block[position]': {
            required: true,
            digits: true
        },
    },
    messages: {
        'block[alias]': "El alias es obligatorio!",
        'block[position]': "La posicion debe ser un numero positivo!"
    }
});

$('#form_question').validate();
$('#form_question_edit').validate({
    rules: {
        'question[description]': {
            required: true,
            maxlength: 50
        }
    },
    messages: {
        'block[description]': "La pregunta no puede tener mas de 50 caracteres!",
    }
});

$('#urltest').val("http://");
$('#urlprod').val("http://");

