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



            var options = [
                {text:"Option 1", value: "OPTION1"},
                {text:"Option 2", value: "OPTION2"},
                {text:"Selected option", value: "OPTION3", selected:true}
            ];
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

$('#submitcustomer').click(function (e) {
    e.preventDefault();
    console.log(array);
    $.ajax({
        type: "POST",
        url: '/wiip/public/index.php/clientes/crear',
        data: {
            users: array,
            nombre: $('#nombrec').val(),
            alias: $('#aliasc').val(),
            email: $('#emailc').val(),
            contacto: $('#contactoc').val(),
            activo: $('#activoc').val()
        },
        success: function (r) {
            console.log(r);
            if(r.correcto == 200){
                window.location.href = r.ruta;
            }else{
                console.log("Error en la peticion ajax");
            }
            //window.location.href = 'http://localhost/wiip/public/index.php/tests/listar';
            //header("Location: http://www.cristalab.com");
            //$('#form_test').submit();
        },
        error: function () {
            console.log("No se ha podido obtener la información");
        }
    });
});