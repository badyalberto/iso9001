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


// ERROR DE LA POSICION DEL BLOQUE
/*$('#test_blocks___name___position').blur(function () {
    if ($('#test_blocks___name___position').val() !== "") {
        $('#failedposition').css('display', 'none');
    } else {
        $('#failedposition').css('display', 'block');
    }

});

//ERROR DEL BLOQUE PADRE
$('#test_blocks___name___bloque_padre').blur(function () {
    if ($('#test_blocks___name___bloque_padre').val() !== "") {
        $('#failedpadre').css('display', 'none');
    } else {
        $('#failedpadre').css('display', 'block');
    }

});

//ERROR DEL ALIAS
$('#test_blocks___name___alias').blur(function () {
    if ($('#test_blocks___name___alias').val() !== "") {
        $('#failedalias').css('display', 'none');
    } else {
        $('#failedalias').css('display', 'block');
    }

});*/

/*$("#form_test").submit(function (e) {
    //e.preventDefault();
    console.log($("#form_test").val());
})*/

/*$(document).ready(function () {
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
            let texto = `<tr><td>${r.alias}</td><td>${r.position}</td><td>${r.padre}</td><td nowrap=\"\"><a href=\"{{ path('crear-pregunta')}}\" class=\"btn btn-sm btn-clean btn-icon btn-icon-md\" title=\"Añadir pregunta bloque\">                        <i class=\"la la-edit\"></i>                      </a>                      <a href=\"javascript:;\" class=\"btn btn-sm btn-clean btn-icon btn-icon-md\" title=\"Desactivar Test\">                        <i class=\"la la-trash\"></i>                        </a></td></tr>`;
            $('#bloquestabla').append(texto);
            $('#alias').val("");
            $('#position').val("");
        },
        error: function () {
            console.log("No se ha podido obtener la información");
        }
    });
});
*/
$(".denegar").click(function (e) {
    e.preventDefault();
    Swal.fire("La pregunta esta desactivada");
});
$("#disabled-test").click(function (e) {
    Swal.fire("El Test ha sido desactivado");
});

$('select[name="users[]"]').bootstrapDualListbox();
$('select[name="customers[]"]').bootstrapDualListbox();

//MANYTOMANY de USER y CUSTOMER
$(document).ready(function () {

    var sPaginaURL = window.location.pathname;
    var sURLVariables = sPaginaURL.split('/');
    var id = sURLVariables[sURLVariables.length - 1];
    console.log(sURLVariables[sURLVariables.length - 1]);

    //EDITAR UN CLIENTE
    /*if (sURLVariables[sURLVariables.length - 2] == "editar" && sURLVariables[sURLVariables.length - 3] == "clientes") {
        $.ajax({
            type: "GET",
            url: '/wiip/public/index.php/clientes/busca/' + id,
            success: function (r) {
                //console.log(r);
                if (r.correcto == 200) {
                    for (let i = 0; i < r.users.length; i++) {
                        console.log(r.users[i].nombre);
                        if(r.users[i].selected == true){
                            $('select[name="users[]_helper2"]').append(`<option value="${r.users[i].id}" data-sortindex="${i}">${r.users[i].nombre}</option>`);
                        }else{
                            $('select[name="users[]_helper1"]').append(`<option value="${r.users[i]['id']}" >${r.users[i].nombre}</option>`);
                        }

                    }
                } else {
                    console.log("Error en la peticion ajax");
                }
            },
            error: function () {
                console.log("No se ha podido obtener la información");
            }
        });
    }*/

    //EDITAR UN USUARIO
    /*if (sURLVariables[sURLVariables.length - 2] == "editar" && sURLVariables[sURLVariables.length - 3] == "usuarios") {
        $.ajax({
            type: "GET",
            url: '/wiip/public/index.php/usuarios/busca/' + id,
            success: function (r) {
                //console.log(r);
                if (r.correcto == 200) {
                    for (let i = 0; i < r.customers.length; i++) {
                        //console.log(r.customers[i]['nombre']);
                        $('select[name="customers[]_helper2"]').append(`<option value="${r.customers[i]['id']}" data-sortindex="${i}">${r.customers[i]['nombre']}</option>`);
                    }
                } else {
                    console.log("Error en la peticion ajax");
                }
            },
            error: function () {
                console.log("No se ha podido obtener la información");
            }
        });
    }*/


    /*$('select[name="users[]"]').on('click', function (e) {
        e.preventDefault();
        var valors = $('select[name="customers[]_helper2"]').val();
        //console.log(valors);
    })*/


    //ELIMINAR UN USUARIO
    $('.deleteuser').click(function (e) {
        e.preventDefault();
        console.log($('.deleteuser').attr('href'));
        $.confirm({
            title: 'Eliminar!',
            content: '¿Estas seguro de que deseas eliminarlo?',
            buttons: {
                ok: {
                    action: function () {
                        //e.preventDefault();
                        console.log($('.deleteuser').attr('href'));
                        window.location.href = $('.deleteuser').attr('href');
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
        var customer = $(this).attr('href');
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
        var project = $(this).attr('href');
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

$('#urltest').val("http://");
$('#urlprod').val("http://");

