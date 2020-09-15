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
    console.log(valor);
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
                console.log("No se ha podido obtener la información");
            }
        });
    }

});

//VALIDA QUE LOS CAMPOS CUSTOMER Y PROJECT ESTEN RELLENOS EN TEST
$('#guardartest').click(function (e) {
        let customer = $('#test_customer').val();
        let project = $('#test_project').val();
        e.preventDefault();
        //console.log(customer);
        //console.log(project);
        let c = false;
        let p = false;
        if (customer == 0) {
            //e.preventDefault();

            $('#test_customer').addClass('is-invalid');
            $('#cliente').addClass('invalid-feedback');
            $('#cliente').css('display', 'block');
            $('html, body').animate({
                scrollTop: 0
            }, 1000);
        } else {
            c = true;
        }
        if (project == 0) {
            //e.preventDefault();
            $('#test_project').addClass('is-invalid');
            $('#proyecto').addClass('invalid-feedback');
            $('#proyecto').css('display', 'block');
            $('html, body').animate({
                scrollTop: 0
            }, 1000);
        } else {
            p = true;
        }

        $.ajax({
            type: "POST",
            url: url_consulta_blocks,
            success: function (r) {
                console.log(r);
                if (r == true) {
                    //e.preventDefault();
                    $('#errorblock').removeClass('failed_block')
                    $('#errorblock').addClass('invalid-feedback');
                    $('#errorblock').css('display', 'block');
                } else {
                    if (c == true && p == true) {
                        console.log(c, p);
                        $('#form_test').submit();
                    }
                }
            },
            error: function () {
                console.log("No se ha podido obtener la información");
            }
        });

    }
);

$('#test_customer').blur(function () {
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
});


//AÑADIR BLOQUE

function isEmpty(a) {
    if (a === '' || a === null || a === undefined) {
        return true;
    } else {
        return false;
    }
}

$('#addblock').click(function () {
    //console.log(isEmpty($('#alias')));
    console.log($('#alias').val())
    //console.log(isEmpty($('#position')));
    console.log($('#position').val());
    console.log($('#exampleSelect1').val());

    if (!isEmpty($('#alias').val()) && !isEmpty($('#position').val())) {
        console.log("correcto")
        $.ajax({
            type: "POST",
            url: url_blocks,
            data: {
                alias: $('#alias').val(),
                position: $('#position').val(),
                padre: $('#exampleSelect1').val()
            },
            success: function (r) {
                console.log(r);
                let texto = `<tr><td>${r.alias}</td><td>${r.position}</td><td>${r.padre}</td><td nowrap=\"\"><a href=\"edit-preguntas-tests.html\" class=\"btn btn-sm btn-clean btn-icon btn-icon-md\" title=\"Ver preguntas Tests\">                        <i class=\"la la-edit\"></i>                      </a>                      <a href=\"javascript:;\" class=\"btn btn-sm btn-clean btn-icon btn-icon-md\" title=\"Desactivar Test\">                        <i class=\"la la-trash\"></i>                        </a></td></tr>`;
                $('#bloquestabla').append(texto);
                $('#alias').val("");
                $('#position').val("");
            },
            error: function () {
                console.log("No se ha podido obtener la información");
            }
        });
    } else {
        if (isEmpty($('#alias').val())) {
            $('#failedalias').css('display', 'block');

        }
        if (isEmpty($('#position').val())) {
            $('#failedposition').css('display', 'block');
        }
    }
});

$('#alias').blur(function () {
    $('#failedalias').css('display', 'none');
});
$('#position').blur(function () {
    $('#failedposition').css('display', 'none');
});
