"use strict";
var KTDatatablesAdvancedColumnRenderingUsuarios = function() {

    var initTable1 = function() {
        var table = $('#kt_table_1');

        // begin first table
        table.DataTable({
            responsive: true,
            paging: true,
            columnDefs: [{
                    targets: 1,
                    render: function(data, type, full, meta) {
                        return '<a class="kt-link" href="mailto:' + data + '">' + data + '</a>';
                    },
                },
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return '\<a href="edit-usuarios.html" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Editar Usuario">\
                          <i class="la la-edit"></i>\
                        </a>\
                        \<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Desactivar Usuario">\
                          <i class="la la-trash"></i>\
                        </a>';
                    },
                },
                {
                    targets: 2,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: { 'title': 'WIP', 'class': 'kt-badge--brand' },
                            2: { 'title': 'CLIENTE', 'class': ' kt-badge--danger' },
                        };

                        return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
                    },
                },
                {
                    targets: 4,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: { 'title': 'Activo', 'state': 'success' },
                            2: { 'title': 'Desactivado', 'state': 'danger' },
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                            '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                    },
                },
            ],
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable1();
        }
    };
}();
var KTDatatablesAdvancedColumnRenderingClientes = function() {

    var initTable2 = function() {
        var table = $('#kt_table_2');

        // begin first table
        table.DataTable({
            responsive: true,
            paging: true,
            columnDefs: [{
                    targets: 3,
                    render: function(data, type, full, meta) {
                        return '<a class="kt-link" href="mailto:' + data + '">' + data + '</a>';
                    },
                },
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return '\<a href="edit-clientes.html" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Editar Cliente">\
                        <i class="la la-edit"></i>\
                      </a>\
                      \<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Desactivar Cliente">\
                        <i class="la la-trash"></i>\
                      </a>';
                    },
                },
                {
                    targets: 4,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: { 'title': 'Activo', 'state': 'success' },
                            2: { 'title': 'Desactivado', 'state': 'danger' },
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                            '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                    },
                },
            ],
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable2();
        }
    };
}();
var KTDatatablesAdvancedColumnRenderingProyectos = function() {

    var initTable3 = function() {
        var table = $('#kt_table_3');

        // begin first table
        table.DataTable({
            responsive: true,
            paging: true,
            columnDefs: [{
                    targets: 3,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: { 'title': 'Symfony', 'state': 'success' },
                            2: { 'title': 'Prestashop', 'state': 'danger' },
                            3: { 'title': 'Wordpress', 'state': 'warning' },
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                            '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                    },
                },
                {
                    targets: 4,
                    render: function(data, type, full, meta) {
                        return '<a class="kt-link" href="' + data + '">' + data + '</a>';
                    },
                },
                {
                    targets: 5,
                    render: function(data, type, full, meta) {
                        return '<a class="kt-link" href="' + data + '">' + data + '</a>';
                    },
                },
                {
                    targets: 7,
                    render: function(data, type, full, meta) {
                        return '<a class="kt-link" href="mailto:' + data + '">' + data + '</a>';
                    },
                },
                {
                    targets: 9,
                    render: function(data, type, full, meta) {
                        return '<a class="kt-link" href="mailto:' + data + '">' + data + '</a>';
                    },
                },
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return '\<a href="edit-proyectos.html" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Editar Proyecto">\
                        <i class="la la-edit"></i>\
                      </a>\
                      \<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Desactivar Proyecto">\
                        <i class="la la-trash"></i>\
                        </a>\
                        \<a href="tests.html" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Ver Tests">\
                          <i class="la la-tasks"></i>\
                        </a>';
                    },
                },
                {
                    targets: 10,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: { 'title': 'Alpha', 'state': 'success' },
                            2: { 'title': 'Beta', 'state': 'danger' },
                            3: { 'title': 'Producción', 'state': 'warning' },
                            4: { 'title': 'Cerrado', 'state': 'dark' },
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                            '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                    },
                },
            ],
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable3();
        }
    };
}();

var KTDatatablesAdvancedColumnRenderingTests = function() {

    var initTable4 = function() {
        var table = $('#kt_table_4');

        // begin first table
        table.DataTable({
            responsive: true,
            paging: true,
            columnDefs: [{
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return '\<a href="edit-tests.html" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Editar Tests">\
                        <i class="la la-edit"></i>\
                      </a>\
                      \<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Desactivar Test">\
                        <i class="la la-trash"></i>\
                        </a>\
                        \<a href="realizar-test.html" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Realizar Test">\
                        <i class="la la-clock-o"></i>\
                        </a>\
                        \<a href="preguntas-tests.html" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Ver Preguntas">\
                          <i class="la la-tasks"></i>\
                        </a>';
                    },
                },
                {
                    targets: 3,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: { 'title': 'Alpha', 'state': 'success' },
                            2: { 'title': 'Beta', 'state': 'danger' },
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                            '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                    },
                },
                {
                    targets: 4,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: { 'title': 'No Iniciado', 'state': 'brand' },
                            2: { 'title': 'En curso', 'state': 'warning' },
                            3: { 'title': 'Realizado', 'state': 'dark' },
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                            '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                    },
                },

            ],
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable4();
        }
    };
}();

var KTDatatablesAdvancedColumnRenderingBloques = function() {

    var initTable5 = function() {
        var table = $('#kt_table_5');

        // begin first table
        table.DataTable({
            responsive: true,
            paging: true,
            columnDefs: [{
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return '\<a href="edit-preguntas-tests.html" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Ver preguntas Tests">\
                        <i class="la la-edit"></i>\
                      </a>\
                      \<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Desactivar Test">\
                        <i class="la la-trash"></i>\
                        </a>';
                    },
                },
                {
                    targets: 2,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: { 'title': 'Realizada', 'state': 'success' },
                            2: { 'title': 'No realizada', 'state': 'danger' },
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                            '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                    },
                },

            ],
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable5();
        }
    };
}();

var KTDatatablesAdvancedColumnRenderingPreguntas = function() {

    var initTable6 = function() {
        var table = $('#kt_table_6');

        // begin first table
        table.DataTable({
            responsive: true,
            paging: true,
            columnDefs: [{
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return '\<a href="edit-preguntas-tests.html" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Ver preguntas Tests">\
                        <i class="la la-edit"></i>\
                      </a>\
                      \<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Desactivar Test">\
                        <i class="la la-trash"></i>\
                        </a>';
                    },
                },
                {
                    targets: 2,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: { 'title': 'TEST OK', 'state': 'success' },
                            2: { 'title': 'TEST KO', 'state': 'danger' },
                            3: { 'title': 'NO IMPLEMENTADO', 'state': 'warning' },
                            4: { 'title': 'NO TESTEADO', 'state': 'dark' },
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                            '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                    },
                },

            ],
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable6();
        }
    };
}();

var KTDatatablesAdvancedColumnRenderingTestsRealizados = function() {

    var initTable7 = function() {
        var table = $('#kt_table_7');

        // begin first table
        table.DataTable({
            responsive: true,
            paging: true,
            columnDefs: [{
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return '\<a href="realizar-test.html" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Volver a Realizar Test">\
                        <i class="la la-clock-o"></i>\
                        </a>\
                        \<a href="preguntas-tests.html" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Ver Preguntas">\
                          <i class="la la-tasks"></i>\
                        </a>';
                    },
                },
                {
                    targets: 5,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: { 'title': 'TEST OK', 'state': 'success' },
                            2: { 'title': 'TEST KO', 'state': 'danger' },
                            3: { 'title': 'NO IMPLEMENTADO', 'state': 'warning' },
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                            '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                    },
                },

            ],
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable7();
        }
    };
}();


jQuery(document).ready(function() {
    KTDatatablesAdvancedColumnRenderingUsuarios.init();
    KTDatatablesAdvancedColumnRenderingClientes.init();
    KTDatatablesAdvancedColumnRenderingProyectos.init();
    KTDatatablesAdvancedColumnRenderingTests.init();
    KTDatatablesAdvancedColumnRenderingBloques.init();
    KTDatatablesAdvancedColumnRenderingPreguntas.init();
    KTDatatablesAdvancedColumnRenderingTestsRealizados.init();

});