'use strict';
var array = [];
// Class definition
var KTDualListbox = function () {

    // Private functions
    var initDualListbox = function () {
        // Dual Listbox
        var listBoxes = $('.kt-dual-listbox');

        listBoxes.each(function () {
            var $this = $(this);
            // get titles
            var availableTitle = ($this.attr('data-available-title') != null) ? $this.attr('data-available-title') : 'Available options';
            var selectedTitle = ($this.attr('data-selected-title') != null) ? $this.attr('data-selected-title') : 'Selected options';

            // get button labels
            var addLabel = ($this.attr('data-add') != null) ? $this.attr('data-add') : 'Add';
            var removeLabel = ($this.attr('data-remove') != null) ? $this.attr('data-remove') : 'Remove';
            var addAllLabel = ($this.attr('data-add-all') != null) ? $this.attr('data-add-all') : 'Add All';
            var removeAllLabel = ($this.attr('data-remove-all') != null) ? $this.attr('data-remove-all') : 'Remove All';

            // get options
            // get options
            var sPaginaURL = window.location.pathname.substring(1);
            var sURLVariables = sPaginaURL.split('/');
            var id = sURLVariables[sURLVariables.length - 1];
            console.log(sURLVariables[sURLVariables.length - 1]);

            /*var users = [];

            if (sURLVariables[sURLVariables.length - 2] == "editar" && sURLVariables[sURLVariables.length - 3] == "clientes") {
                console.log(sURLVariables[sURLVariables.length - 2]);

                var options = [
                    {text: "Selected option", value: "OPTION3", selected: true}
                ];

                $.ajax({
                    type: "POST",
                    url: '/wiip/public/index.php/clientes/busca',
                    data: {
                        'id': id
                    },
                    success: function (r) {

                        if (r.correcto == 200) {
                            for (let i = 0; i < r.users.length; i++) {
                                for (let j = 0;j<options.length;j++){
                                    if(options[j]['value'] == r.users[i]['id']){
                                        //options[j]['selected'] = true;
                                        console.log(r.users[i]['nombre']);
                                        //options['text'] = r.users[i]['nombre'];
                                        //options['value'] = r.users[i]['id'];
                                        options[j]['selected'] = true;
                                    }
                                }
                            }
                            //console.log(options);
                        } else {
                            console.log("Error en la peticion ajax");
                        }
                    },
                    error: function () {
                        console.log("No se ha podido obtener la información");
                    }
                });
            }

            console.log(options);*/

            $this.children('option').each(function () {
                var value = $(this).val();
                var label = $(this).text();
                var selected = !!($(this).is(':selected'));
                options.push({text: label, value: value, selected: selected});
            });

            // get search option
            var search = ($this.attr('data-search') != null) ? $this.attr('data-search') : '';

            // clear duplicates
            $this.empty();

            // init dual listbox
            var dualListBox = new DualListbox('select'/*$this.get(0)*/, {
                addEvent: function (value) {
                    console.log(array);
                    array.push(value);
                },
                removeEvent: function (value) {
                    console.log(array);
                    removeItemFromArr(array, value);

                },
                availableTitle: availableTitle,
                selectedTitle: selectedTitle,
                addButtonText: addLabel,
                removeButtonText: removeLabel,
                addAllButtonText: addAllLabel,
                removeAllButtonText: removeAllLabel,
                options: options,
            });

            if (search == 'false') {
                dualListBox.search.classList.add('dual-listbox__search--hidden');
            }
        });
    };

    return {
        // public functions
        init: function () {
            initDualListbox();
        },
    };
}();

KTUtil.ready(function () {
    KTDualListbox.init();
});

function removeItemFromArr(arr, item) {
    var i = arr.indexOf(item);

    if (i !== -1) {
        arr.splice(i, 1);
    }
}

/*$('#submitcustomer').click(function (e) {
    e.preventDefault();
    console.log($('select[name="users[]_helper2"]').val())
    $.ajax({
        type: "POST",
        url: '/wiip/public/index.php/clientes/crear',
        data: {
            users: $('select[name="users[]_helper2"]').val(),
            nombre: $('#nombrec').val(),
            alias: $('#aliasc').val(),
            email: $('#emailc').val(),
            contacto: $('#contactoc').val(),
            activo: $('#activoc').val()
        },
        success: function (r) {
            if (r.correcto == 200) {
                window.location.href = r.ruta;
            } else {
                console.log("Error en la peticion ajax");
            }
        },
        error: function () {
            console.log("No se ha podido obtener la información");
        }
    });
});*/