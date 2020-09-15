"use strict"


// VALIDACION DEL CORREO DEL USER

$('#user_correo').blur(function () {
        let valor = $('#user_correo').val();
        if (/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(valor)) {
            $('.emailuser').css("display", "none");
        } else {
            $(".emailuser").html("El campo email no es valido");
            $('.emailuser').css("display", "block");
        }
    }
)
;

//VALIDACION DEL CORREO DEL CUSTOMER
$('#customer_pmmail').blur(function () {
        let valor = $('#customer_pmmail').val();
        if (/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(valor)) {
            $('.emailcustomer').css("display", "none");
        } else {
            $(".emailcustomer").html("El campo email no es valido");
            $('.emailcustomer').css("display", "block");
        }
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

//MUESTRA EL DESPLEGABLE DE PROYECTOS EN EL APARTADO DE TESTS
$(document).ready(function () {
    $('#test_project').prop('disabled', true);
});

$('#test_customer').click(function () {
    let valor = $('#test_customer').val();
    //console.log(valor);
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
            console.log("No se ha podido obtener la información");
        }
    });
});

$('#form_test').submit(function (e) {
        let customer = $('#test_customer').val();
        let project = $('#test_project').val();

        console.log(customer);
        console.log(project);
        if (customer == 0) {
            e.preventDefault();
            $('#test_customer').addClass('is-invalid');
            $('.invalid-feedback').css('display','block');
            $('html, body').animate({
                scrollTop: 0
            }, 1000);
        }
        if (project == 0) {
            e.preventDefault();
            $('#test_project').addClass('is-invalid');
            $('.invalid-feedback').css('display','block');
            $('html, body').animate({
                scrollTop: 0
            }, 1000);
        }

    }
);
