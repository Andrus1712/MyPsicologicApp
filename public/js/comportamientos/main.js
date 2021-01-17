var modal = $('#modal-comportamientos')
var modal2 = $('#modal-tc')
var AllRegister = [];

var getAct;

var permisos = [];

var rol;

var user;


$(document).ready(function () {
    Reload();

    $('#comportamientos-table').on('click', '[id^=Btn_act_]', function () {
        var id = $(this).attr('data-id');
        const filtro = AllRegister.filter(f => f.id == id);

        modal.modal('hide');

        if (filtro[0].titulo_tc == null) {
            modal2.modal('show');
            LoadModalTC(filtro);
            LoadTiposComportamientos(modal2);

            $('#save2').on('click', function () {
                var tipo_comportamiento_id = $("#tipo_comportamiento_id").val();

                $.ajax({
                    url: '/api/comportamientos/' + id,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'PUT',
                    data: {
                        tipo_comportamiento_id: tipo_comportamiento_id,
                    },
                })
                    .done(function () {
                        setTimeout(function () { modal2.modal("hide") }, 600);
                        toastr.info("información actualizada");
                        Reload();

                    })
                    .fail(function () {
                        toastr.error("Ha ocurrido un error");
                    })
                    .always(function () {
                        $("#save2").addClass("disabled");
                    });

                modal.modal('show');
            });

            $('#omitir').on('click', function () {
                setTimeout(function () { modal2.modal("hide") }, 600);
                modal.modal('show');
            });
        }

        if (filtro[0].titulo_tc != null) {
            modal.modal('show');
        }

        ModalActividades()
        $('#input_actividad').hide()
        LoadComportamientos(id)

        $('#save').on('click', function () {
            var comportamiento_id = $("#comportamiento_id").val(),
                titulo = $("#titulo").val(),
                descripcion = $("#descripcion").val(),
                fecha = $("#fecha").val(),
                estado = 3 //estado por defecto de las actividades

            if (comportamiento_id == '' || titulo == '' || descripcion == '' || fecha == '') {
                toastr.warning("Complete todos los campos")
            } else {
                $.ajax({
                    url: '/api/actividades',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: {
                        comportamiento_id: comportamiento_id,
                        titulo: titulo,
                        descripcion: descripcion,
                        fecha: fecha,
                        estado: estado,
                    },
                })
                    .done(function () {
                        setTimeout(function () { modal.modal("hide") }, 600);
                        Reload()
                    })
                    .fail(function () {
                        toastr.error("Ha ocurrido un error");
                    })
                    .always(function () {
                        $("#save").addClass("disabled");
                    });
            }

        })

    })

    $('#comportamientos-table').on('click', '[id^=Btn_Edit_]', function () {
        var id = $(this).attr('data-id');

        const filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            modal.modal("show");
            Modal()
            LoadEstudiantes()
            LoadTiposComportamientos(modal)


            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')

            // $('#rutaFile').removeClass('hide')
            // $("#rutaFile").attr('href', filtro[0].multimedia)
            // $('#rutaFile').attr('target', '_blank')
            // $("#rutaFile").text('Ver documento')

            $("#titulo").val(filtro[0].titulo)
            $("#estudiante_id").val(filtro[0].estudiante_id)
            $("#descripcion").val(filtro[0].descripcion)
            $("#fecha").val(filtro[0].fecha)
            // $("#emisor").val(filtro[0].emisor)

            $("#update").on('click', function () {

                var tipo_comportamiento_id = $("#tipo_comportamiento_id").val(),
                    estudiante_id = $("#estudiante_id").val(),
                    titulo = $("#titulo").val(),
                    descripcion = $("#descripcion").val(),
                    fecha = $("#fecha").val()

                if (estudiante_id == '' || titulo == '' || descripcion == '' || fecha == '') {
                    toastr.warning("Complete todos los campos")
                } else {

                    var form = new FormData();

                    var archivos = 0;
                    form.append('tempMultimedia', filtro[0].multimedia)

                    jQuery.each(jQuery('#multimedia')[0].files, function (i, file) {
                        form.append('file' + i, file);
                        archivos++;
                    });
                    form.append('archivos', archivos);


                    form.append('estudiante_id', estudiante_id)
                    form.append('titulo', titulo)
                    form.append('descripcion', descripcion)
                    form.append('fecha', fecha)
                    form.append('tipo_comportamiento_id', tipo_comportamiento_id)
                    form.append('method', 'update')
                    form.append('id', id)


                    $.ajax({
                        url: '/add_comportamientos',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: form,
                    })
                        .done(function () {
                            setTimeout(function () { modal.modal("hide") }, 600);
                            toastr.info("información actualizada");
                            Reload();
                        })
                        .fail(function () {
                            toastr.error("Ha ocurrido un error");
                        })
                        .always(function () {
                            $("#update").addClass("disabled");
                        });
                }
                // modal.find('.modal-content').empty()
            })
        }
    })

    $('#comportamientos-table').on('click', '[id^=Btn_delete_]', function () {
        var id = $(this).attr('data-id')

        swal({
            title: "¿Realmente deseas eliminar el acudiente?",
            text: "Ten en cuenta que eliminaras toda su información del sistema",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si, eliminar",
            closeOnConfirm: false
        },
            function () {
                $.ajax({
                    url: "/api/comportamientos/" + id,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                })
                    .done(function () {
                        swal("Eliminado!", "Se ha eliminado el acudiente", "success");
                        Reload();
                    })
                    .fail(function () {
                        swal("Error!", "Ha ocurrido un error", "error");
                    });

            });


    })

    $('#add-comportamientos').on('click', function () {
        modal.modal('show')
        Modal()
        $("#tc").hide();

        LoadEstudiantes()
        establecer_fecha()

        console.log(permisos);
        console.log(permisos.includes('tipos.comportamientos'));
        if (permisos.includes('tipos.comportamientos')) {
            LoadTiposComportamientos();
            $("#tc").show();
        }
        // $('#btn_add').on('click', function(){
        //     alert("agregar estudiante")
        // })

        $('#save').on('click', function () {
            var tipo_comportamiento_id = $("#tipo_comportamiento_id").val(),
                estudiante_id = $("#estudiante_id").val(),
                titulo = $("#titulo").val(),
                descripcion = $("#descripcion").val(),
                fecha = $("#fecha").val(),
                // emisor = "X",
                multimedia = $("#multimedia")[0].files;

            if (estudiante_id == '' || titulo == '' || descripcion == '' || fecha == '') {
                toastr.warning("Complete todos los campos")
            } else {
                var form = new FormData();
                var archivos = 0;
                jQuery.each(jQuery('#multimedia')[0].files, function (i, file) {
                    form.append('file' + i, file);
                    archivos++;
                });
                form.append('archivos', archivos);


                form.append('estudiante_id', estudiante_id)
                form.append('titulo', titulo)
                form.append('descripcion', descripcion)
                form.append('fecha', fecha)
                // form.append('emisor', emisor)
                form.append('tipo_comportamiento_id', tipo_comportamiento_id)
                // form.append('multimedia', multimedia)

                $.ajax({
                    url: '/add_comportamientos',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: form,
                    processData: false,
                    contentType: false,
                })
                    .done(function () {
                        toastr.success("Comportamiento registrado");
                        setTimeout(function () { modal.modal("hide") }, 600);
                        Reload()
                    })
                    .fail(function () {
                        toastr.error("Ha ocurrido un error");
                    })
                    .always(function () {
                        $("#save").addClass("disabled");
                    });
            }
        })
    })

    $('#comportamientos-table').on('click', '[id^=Btn_file_]', function () {
        modal.modal('show')
        var id = $(this).attr('data-id');

        const filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            var json = filtro[0].multimedia.split('PSIAPP');
            var html = ''
            var a = 0;
            for (var i = 0; i < json.length; i++) {
                if (json[i] != '') {
                    var icon = 'fa fa-file';

                    var extension = json[i].split('.')[2];
                    console.log(extension)

                    switch (extension) {
                        case 'doc':
                            icon = 'fa-file-word-o';
                            break;
                        case 'docx':
                            icon = 'fa-file-word-o';
                            break;
                        case 'xlsx':
                            icon = 'fa-file-excel-o bg-success bg-green';
                            break;
                        case 'pdf':
                            icon = 'fa-file-pdf bg-danger bg-red';
                            break;
                        case 'txt':
                            icon = 'fa-file-text';
                            break;
                        case 'jpeg':
                            icon = 'fa-file-image-o';
                            break;
                        case 'png':
                            icon = 'fa-file-image-o';
                            break;
                        case 'jpg':
                            icon = 'fa-file-image-o';
                            break;
                        case 'mp3':
                            icon = 'fa-file-audio-o bg-secondary';
                            break;
                        case 'mp4':
                            icon = 'fa-file-movie-o bg-secondary';
                            break;
                    }
                    html += `
                    <div class="col-md-3">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <i class="fa fa-book"></i>
                                <h3 class="box-title">Archivo ${a + 1}</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group" align="center">
                                    <a target="_blank" href="${json[i]}" type="button" style="font-size: 2em;" class="btn-link">
                                        <i class="fa ${icon}"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>`

                    a++;
                }

            }





            modal.find('.modal-content').empty().append(`
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Archivos cargados</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        ${html}
                    </div>
                    
                </div>
            `)
        }

    });

    $('#make-reporte').on('click', function () {

        modal.modal("show");
        ModalReporte();

        //Reporte general
        $('#btn_reporte_general').on('click', function () {
            modal.modal("hide");

            modal2.modal("show");
            ModalReporteGeneral();
            $('#back').on('click', function () {
                modal2.modal("hide");
                modal.modal("show");
            });


            //** ****************************DateRangepicker**************************** */
            // Se carga de dateRangePicker
            var start = moment().subtract(29, 'days');
            var end = moment();

            var fechas;
            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                fechas = {
                    fecha_i: start.format('YYYY-MM-DD'),
                    fecha_f: end.format('YYYY-MM-DD')
                };
                console.log(fechas);
            }


            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Ultimo mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "locale": {
                    "separator": " - ",
                    "applyLabel": "Aplicar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "DE",
                    "toLabel": "HASTA",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mie",
                        "Jue",
                        "Vie",
                        "Sáb"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                }
            }, cb);

            cb(start, end);
            //** ********************************************************************** */

            /** Acion al generar el pdf */
            $('#generar').on('click', function () {
                // https://quickchart.io/chart?bkg=white&c={type:%27bar%27,data:{labels:[2012,2013,2014,2015,2016],datasets:[{label:%27Users%27,data:[120,60,50,180,120]}]}}
                openWindowWithPostRequest('/download_pdf', fechas)
            });


        });
        // ************************

        //Reporte Avanzado
        $('#btn_reporte_avanzado').on('click', function () {
            modal.modal("hide");
            modal2.modal("show");
            ModalReporteAvanzado();
            $('#back').on('click', function () {
                modal2.modal("hide");
                modal.modal("show");
            });

            //** ****************************DateRangepicker**************************** */
            var start = moment().subtract(29, 'days');
            var end = moment();

            var fechas = [];
            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                fechas = {
                    fecha_i: start.format('YYYY-MM-DD'),
                    fecha_f: end.format('YYYY-MM-DD')
                };
                console.log(fechas);
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Ultimo mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "locale": {
                    "separator": " - ",
                    "applyLabel": "Aplicar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "DE",
                    "toLabel": "HASTA",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mie",
                        "Jue",
                        "Vie",
                        "Sáb"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                }
            }, cb);

            cb(start, end);
            //** ********************************************************************** */


            //** ****************************Slider**************************** */
            $('#range').html(`
                <input id="mySlider" type="text" class="span2" value="" data-slider-min="0" data-slider-max="50" data-slider-step="1" data-slider-value="[5,20]"/>
                <span style="
                margin-left: 10px;" id="mySliderCurrentSliderValLabel">Intervalo: 
                    [<span id="mySliderVal">5,20</span>] (años)
                </span>
            `);

            $("#mySlider").slider();

            $("#mySlider").on("slide", function (slideEvt) {
                $("#mySliderVal").text(slideEvt.value);
            });
            //** ********************************************************************** */


            //** ********************************************************************** */
            LoadTiposComportamientosCheck();

            $('#i_genero').on('click', function () {
                var checked = this.checked;

                if (checked) {
                    $('#check_genero').show();
                } else {
                    $('#check_genero').hide();
                }
            });

            var status = false;
            $('#i_grupo').on('click', function () {
                var checked = this.checked;
                if (!status) {
                    LoadGrupos();
                    status = true;
                }
                if (checked) {
                    $('#check_grupo').show();
                    $("#all_grupos").on('click', function () {
                        var checked = this.checked;
                        if (checked) {
                            $("#grupo_id option").prop('selected', true);
                            $("#grupo_id").trigger('change');
                        } else {
                            $("#grupo_id option").prop('selected', false);
                            $("#grupo_id").trigger('change');
                        }
                    });
                } else {
                    $('#check_grupo').hide();
                }
            });


            $('#i_edad').on('click', function () {
                var checked = this.checked;
                if (checked) {
                    $('#check_edad').show();
                } else {
                    $('#check_edad').hide();
                }
            });
            //** ********************************************************************** */

            $('#generar').on('click', function () {
                var ArrayConducta = [];
                var ArrayGenero = [];
                var ArrayEdad = [];
                var ArrayGrupo = [];

                $('input[name="conducta"]:checkbox:checked').each(
                    function () {
                        if ($(this).val() != 'on') {
                            ArrayConducta.push($(this).val());
                        }
                    }
                );
                $('input[name="genero"]:checkbox:checked').each(
                    function () {
                        if ($(this).val() != 'on') {
                            ArrayGenero.push($(this).val());
                        }
                    }
                );

                // var rangoEdad = $('#mySlider').val();
                ArrayEdad = $('#mySlider').val().split(",");
                ArrayGrupo = $('#grupo_id').val();

                let datos = {
                    fecha_i: fechas.fecha_i,
                    fecha_f: fechas.fecha_f,
                    conductas_id: ArrayConducta,
                    generos: ArrayGenero,
                    edades: ArrayEdad,
                    grupos_id: ArrayGrupo
                };
                openWindowWithPostRequest('/download_pdf2', datos);
            });
        });
        //** ********************************************************************** */


        // funcion Enviar
        // $('#save').on('click ', function () {
        //     ArrayTC = [];
        //     ArrayG = [];
        //     fecha = [];
        //     var valor;

        //     $('input[name="conducta"]:checkbox:checked').each(
        //         function () {
        //             if ($(this).val() != 'on') {
        //                 ArrayConducta.push($(this).val());
        //             }
        //         }
        //     );

        //     $('input[name="genero"]:checkbox:checked').each(
        //         function () {
        //             if ($(this).val() != 'on') {
        //                 ArrayGenero.push($(this).val());
        //             }
        //         }
        //     );
        //     fecha.push(fi);
        //     fecha.push(ff);
        //     valor = $('#mySlider').val();

        //     console.log("Conducta: " + ArrayTC);
        //     console.log("Genero: " + ArrayG);
        //     console.log("fecha: " + fecha);
        //     console.log("Rango edad: " + valor.split(","));
        // });


        // window.open("/comportamientosPdf", "_blank");
    });

    $('#import-data').on('click', function () {
        modal.modal("show");
        ModalImport();

        $('#save').on('click', function () {
            var form = new FormData();
            var archivos = 0;
            jQuery.each(jQuery('#multimedia')[0].files, function (i, file) {
                form.append('file' + i, file);
                archivos++;
            });
            form.append('archivos', archivos);

            $.ajax({
                url: "/import_xlsx",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form,
                processData: false,
                contentType: false,
            })
                .done(function (response) {
                    toastr.success("Comportamiento registrado");
                    setTimeout(function () { modal.modal("hide") }, 600);

                    var arr = response.split('XLSX');
                    console.log(arr[1]);


                    var url = arr[1];
                    var oReq = new XMLHttpRequest();
                    oReq.open("GET", url, true);
                    oReq.responseType = "arraybuffer";

                    oReq.onload = function (e) {
                        var arraybuffer = oReq.response;

                        /* convert data to binary string */
                        var data = new Uint8Array(arraybuffer);
                        var arr = new Array();
                        for (var i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);
                        var bstr = arr.join("");

                        /* Call XLSX */
                        var workbook = XLSX.read(bstr, { type: "binary" });

                        /* DO SOMETHING WITH workbook HERE */
                        var first_sheet_name = workbook.SheetNames[0];
                        /* Get worksheet */
                        var worksheet = workbook.Sheets[first_sheet_name];
                        var data = XLSX.utils.sheet_to_json(worksheet, { raw: true });
                        console.log(data);

                    }

                    oReq.send();
                })
                .fail(function () {
                    toastr.error("Ha ocurrido un error");
                })
                .always(function () {
                    $("#save").addClass("disabled");
                });
        });
    });


    function openWindowWithPostRequest(url, params) {
        var winName = 'reporte';
        var winURL = url;
        // var windowoption = 'resizable=yes,height=1000,width=800,location=0,menubar=0,scrollbars=1';

        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", winURL);
        form.setAttribute("target", winName);
        for (var i in params) {
            if (params.hasOwnProperty(i)) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = i;
                input.value = params[i];
                form.appendChild(input);
            }
        }

        let csrfField = document.createElement('input');
        csrfField.setAttribute('type', 'hidden');
        csrfField.setAttribute('name', '_token');
        csrfField.setAttribute('value', $('meta[name="csrf-token"]').attr('content'));
        form.appendChild(csrfField);

        document.body.appendChild(form);
        window.open('', winName);
        form.target = winName;
        form.submit();
        document.body.removeChild(form);
    }

    function LoadGrupos() {
        $("#grupo_id").select2({
            placeholder: 'Seleccione el grupo',
            allowClear: true,
            dropdownParent: modal2,
            dropdownAutoWidth: false,
        });

        $.ajax({
            url: '/api/grupos',
            type: "GET",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "JSON",
        })
            .done(function (response) {
                for (var i in response.data) {
                    $("#grupo_id").append(`<option value='${response.data[i].id}'>${response.data[i].grado} - ${response.data[i].curso}</option>`);
                }
            })
            .fail(function () {
                console.log("error");
            });
    }

    function LoadEstudiantes() {
        $("#estudiante_id").select2({
            placeholder: 'Seleccione el estudiante',
            allowClear: true,
            dropdownParent: modal,
            width: 'resolve'
        });

        $.ajax({
            url: '/getEstudiantes',
            type: "GET",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "JSON",
        })
            .done(function (response) {
                if (response.estudiantes.length != 0) {
                    for (var i = 0; i < response.estudiantes.length; i++) {
                        $("#estudiante_id").append(`<option value='${response.estudiantes[i].id}'>${response.estudiantes[i].nombres} ${response.estudiantes[i].apellidos} </option>`)
                    }
                } else {

                }


            })
            .fail(function () {
                console.log("error");
            })
    }

    function establecer_fecha() {
        var hoy = new Date();
        hoy.setMinutes(hoy.getMinutes() - hoy.getTimezoneOffset());
        hoy = hoy.toJSON().slice(0, 10);
        $("#fecha").val(hoy);
    }

    function LoadTiposComportamientos(modal_parent) {
        $("#tipo_comportamiento_id").select2({
            placeholder: 'Seleccione el tipo comportamiento',
            allowClear: true,
            dropdownParent: modal_parent,
            width: 'resolve'
        });

        $.ajax({
            url: '/api/tipo_comportamientos',
        })
            .done(function (response) {
                for (var i in response.data) {
                    $("#tipo_comportamiento_id").append(`<option value='${response.data[i].id}'>${response.data[i].titulo}</option>`)
                }

            })
            .fail(function () {
                console.log("error");
            })
    }

    function LoadTiposComportamientosCheck() {
        $.ajax({
            url: '/api/tipo_comportamientos',
        })
            .done(function (response) {
                for (var i in response.data) {
                    $("#check_conducta").append(`
                        <div class="checkbox">
                            <label>
                                <input id="tc_${i}" value="${response.data[i].id}" name="conducta" type="checkbox">${response.data[i].titulo}
                            </label>
                        </div>
                    `)
                }
            })
            .fail(function () {
                console.log("error");
            })
    }

    function LoadComportamientos(id) {
        $("#comportamiento_id").select2({
            placeholder: 'Seleccione el comportamiento',
            allowClear: true,
            dropdownParent: modal,
            width: 'resolve'
        });

        $.ajax({
            url: '/api/comportamientos',
        })
            .done(function (response) {
                for (var i in response.data) {
                    if (response.data[i].id == id) {
                        $("#comportamiento_id").append(`<option value='${response.data[i].id}'>${response.data[i].titulo} | ${response.data[i].nombres}  ${response.data[i].apellidos} | CMP${response.data[i].id} </option>`)
                    }
                }

            })
            .fail(function () {
                console.log("error");
            })
    }

    function Reload() {
        $.ajax({
            url: "/getComportamientos",
            type: "GET",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "JSON",
        })

            .done(function (response) {
                if (response.length != 0) {
                    AllRegister = response.comportamientos;
                    permisos = response.permisos;
                    rol = response.rol;
                    user = response.user;

                    if (user != null) {

                        var my_data = [];

                        for (let index = 0; index < AllRegister.length; index++) {
                            // const element = AllRegister[index];
                            if (JSON.parse(AllRegister[index].emis0r).email == user.email) {

                                my_data.push(AllRegister[index]);
                            }
                        }
                        DataTable(my_data);
                    } else {
                        DataTable(response.comportamientos);
                    }
                } else {
                    $('#comportamientos-table').dataTable().fnClearTable();
                    $('#comportamientos-table').dataTable().fnDestroy();
                    $('#comportamientos-table thead').empty()
                }
            })

            .fail(function () {
                console.log("error");
            });
    }

    function ModalReporteAvanzado() {
        $('#modal2_tam').removeClass('modal-lg');
        $('#modal2_tam').addClass('modal-md');
        modal2.find('.modal-content').empty().append(`
        <div class="modal-header">
            <a class="btn pull-left" id="back"><i class="fas fa-arrow-left"></i></a>
            <h4 class="modal-title">Crear Reporte</h4>
        </div>

        <div class="modal-body">


            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Fecha del registro: </label>
                    <div id="reportrange"
                        style="background: #fff; cursor: pointer; 
                        padding: 5px 10px; border: 1px solid #ccc; 
                        width: 100%; margin-bottom: 10px;>
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                </div>
            </div> 

            <div class="row">
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <label>Incluir</label>
                    <div class="checkbox">
                        <label>
                            <input id="i_grupo" type="checkbox">Grupo
                        </label>
                    </div>
                    <div id="check_grupo" style="display: none; margin-left: 10px;">
                        <div class="input-group">
                            <select class="form-control" name="gupos[]" multiple="multiple" id="grupo_id" style="width: 100% !important;">

                            </select>
                            <input type="checkbox" id="all_grupos" >Select All
                        </div>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="i_genero" type="checkbox">Genero
                        </label>
                    </div>
                    <div id="check_genero" style="display: none; margin-left: 10px;">
                        <div class="checkbox">
                            <label>
                                <input id="i_m" value="M" name="genero" type="checkbox">Masculino
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input id="i_f" value="F" name="genero" type="checkbox">Femenino
                            </label>
                        </div>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input id="i_edad" type="checkbox">Edad
                        </label>
                    </div>
                    <div id="check_edad" style="display: none; margin-left: 10px;">
                        <div style="margin-top: 10px;" id="range" style="margin-left: 10px;"></div>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <label>Tipos de conducta</label>
                    <div id="check_conducta">

                    </div>
                </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="generar">Generar PDF</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    `);
    }

    function ModalReporteGeneral() {
        $('#modal2_tam').removeClass('modal-lg');
        $('#modal2_tam').addClass('modal-md');
        modal2.find('.modal-content').empty().append(`
        <div class="modal-header">
            <a class="btn pull-left" id="back"><i class="fas fa-arrow-left"></i></a>
            <h4 class="modal-title">Crear Reporte</h4>
        </div>
        <div class="modal-body">

                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label>Fecha del registro: </label>
                        <div id="reportrange"
                            style="background: #fff; cursor: pointer; 
                            padding: 5px 10px; border: 1px solid #ccc; 
                            width: 100%; margin-bottom: 10px;>
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="generar">Generar PDF</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    `);
    }

    function ModalReporte() {
        $('#modal1_tam').removeClass('modal-lg');
        $('#modal1_tam').addClass('modal-md');
        modal.find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Crear Reporte</h4>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-6">
                    <a id="btn_reporte_general" class="btn bg-purple">Reporte General</a>
                </div>
                <div class="col-md-6">
                    <a id="btn_reporte_avanzado" class="btn bg-purple">Reporte vanzado</a>
                </div>
            </div>
        </div>
    `);

    }

    function ModalImport() {
        $('#modal1_tam').removeClass('modal-lg');
        $('#modal1_tam').addClass('modal-md');
        modal.find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Crear Reporte</h4>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <a class="btn btn-secondary hide" id="rutaFile"></a>
                            <br>
                        <label>Multimedia: </label>
                        <input type="file" name="files[]" id="multimedia">
                        
                        <p class="help-block">Suba archivo que ayude a reportar el comportamiento.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    `);

    }

    function Modal() {
        $('#modal_tam').removeClass('modal-md');
        $('#modal_tam').addClass('modal-lg');
        modal.find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Formulario de Comportamientos</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Titulo Comportamiento: </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-thumb-tack"></i></span>
                            <input type="text" class="form-control" placeholder="Titulo" id="titulo">
                        </div>
                    </div>

                    <div class="form-group" id="tc">
                        <label >Tipo de comportamiento: </label>
                        <div class="input-group">
                            <select class="form-control" id="tipo_comportamiento_id" style="width: 100%;">

                            </select>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label >Estudiante: </label>
                        <div class="input-group">
                            <select class="form-control" id="estudiante_id" style="width: 100%; heigh: 100px;">

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Fecha del Comportamiento: </label>
                        <div class="input-group date" id="timepicker">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="fecha" class="form-control pull-right" id="fecha" disabled>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descripcion: </label>
                        <textarea id="descripcion" class="form-control" style="resize: vertical;" rows="3" placeholder="Descripcion ..."></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <a class="btn btn-secondary hide" id="rutaFile"></a>
                            <br>
                        <label>Multimedia: </label>
                        <input type="file" name="files[]" id="multimedia" multiple>
                        
                        <p class="help-block">Suba archivo que ayude a reportar el comportamiento.</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    `)
        $("#timepicker").datetimepicker({
            format: "YYYY-MM-DD"
        });
    }

    function LoadModalTC(comp) {
        modal2.find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tipo de comportamiento</h4>
        </div>
        <div class="modal-body">
            <p>Por favor asigne un tipo de conducta al comportamiento*</p>
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label >Comportamiento: </label>
                        <div class="input-group">
                            <select class="form-control" id="tipo_comportamiento_id" style="width: 100%;">

                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save2">Guardar</button>
            <button type="button" class="btn btn-default" id="omitir" data-dismiss="modal">Omitir</button>
        </div>
    `)
    }

    function ModalActividades() {
        modal.find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Formulario de Actividades</h4>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label >Comportamiento: </label>
                        <div class="input-group">
                            <select class="form-control" id="comportamiento_id" style="width: 100%;">

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Titulo: </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="titulo de la actividad" id="titulo">
                        </div>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Fecha de la actividad: </label>
                        <div class="input-group date" id="timepicker">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="fecha" >
                        </div>
                    </div>

                    <div class="form-group" id="input_actividad">
                        <label>Estado de la actividad: </label>
                        <select class="form-control" id="estado">
                            <option value=""> Selecione un estado </option>
                            <option value="1"> cumplida </option>
                            <option value="2"> incumplida </option>
                            <option value="3"> en espera </option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descripcion la actividad: </label>
                        <textarea id="descripcion" class="form-control" style="resize: vertical;" rows="3" placeholder="Escriba aqui la descripción de la actividad ..."></textarea>
                    </div>
                </div>
            </div>

                
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    `)
        $("#fecha").datetimepicker({
            format: "YYYY-MM-DD"
        });
    }

    function DataTableReport(response) {

        if ($.fn.DataTable.isDataTable('#reportes-table')) {
            $('#reportes-table').dataTable().fnClearTable();
            $('#reportes-table').dataTable().fnDestroy();
            $('#reportes-table thead').empty()
        } else {
            $('#reportes-table thead').empty()
        }

        // console.log("info tabla " + response);

        if (response.length != 0) {
            let my_columns = []
            $.each(response[0], function (key, value) {
                var my_item = {};
                // my_item.class = "filter_C";
                my_item.data = key;
                if (key == "fecha_f") {

                    my_item.title = 'Fecha';

                    my_item.render = function (data, type, row) {
                        return `  <div> 
                                ${row.fecha_f}
                            </div>`
                    }
                    my_columns.push(my_item);

                } else if (key == "fecha_i") {

                    my_item.title = 'Fecha';

                    my_item.render = function (data, type, row) {
                        return `  <div> 
                                ${row.fecha_i}
                            </div>`
                    }
                    my_columns.push(my_item);

                }
            });
            $('#reportes-table').DataTable({
                // 'scrollX': my_columns.length >= 6 ? true : false,
                "destroy": true,
                data: response,
                "columns": my_columns,
                dom: 'Bfrtip',
                responsive: true,
                paging: true,
            });
        }

    }

    function DataTable(response) {


        if ($.fn.DataTable.isDataTable('#comportamientos-table')) {
            $('#comportamientos-table').dataTable().fnClearTable();
            $('#comportamientos-table').dataTable().fnDestroy();
            $('#comportamientos-table thead').empty()
        } else {
            $('#comportamientos-table thead').empty()
        }


        if (response.length != 0) {
            let my_columns = []
            $.each(response[0], function (key, value) {
                var my_item = {};
                // my_item.class = "filter_C";
                my_item.data = key;

                if (key == 'created_at') {
                    my_item.title = 'Acción';

                    my_item.render = function (data, type, row) {
                        var html = '';
                        for (let i = 0; i < permisos.length; i++) {
                            if (permisos[i] == "delete.comportamientos") {
                                html += `
                                    <a data-id=${row.id} id="Btn_delete_${row.id}" class='btn btn-circle btn-sm btn-danger'>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a> `
                            } else if (permisos[i] == "edit.comportamientos") {
                                html += `
                                    <a data-id=${row.id} id="Btn_Edit_${row.id}" class='btn btn-circle btn-sm btn-primary'>
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>
                                    `
                            } else if (permisos[i] == "create.actividades") {
                                html += `
                                    <a data-id=${row.id} id="Btn_act_${row.id}" class='btn btn-circle btn-sm btn-success'>
                                        <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                                    </a> `
                            }
                        }
                        return `<div align="center">
                                <div class="btn-group btn-group-circle btn-group-solid" align="center">
                                    ${html}
                                </div>
                            </div>`;

                    }
                    if (permisos.length != 0) {
                        my_columns.push(my_item);
                    }

                } else if (key == 'id') {

                    my_item.title = '#';

                    my_item.render = function (data, type, row) {
                        return `  <div'> 
                                CMP${row.id}
                            </div>`
                    }
                    my_columns.push(my_item);

                } else if (key == 'fecha') {

                    my_item.title = 'Fecha de reporte';

                    my_item.render = function (data, type, row) {
                        return `  <div'> 
                                ${row.fecha}
                            </div>`
                    }
                    my_columns.push(my_item);

                } else if (key == 'titulo') {

                    my_item.title = 'Titulo';

                    my_item.render = function (data, type, row) {
                        return `<div>
                                ${row.titulo} 
                            </div>`
                    }
                    my_columns.push(my_item);
                } else if (key == 'descripcion') {

                    my_item.title = 'Descripcion';

                    my_item.render = function (data, type, row) {
                        return `<div>
                                ${row.descripcion} 
                            </div>`
                    }
                    my_columns.push(my_item);
                } else if (key == 'nombres') {

                    my_item.title = 'Estudiante';

                    my_item.render = function (data, type, row) {
                        return `<div>
                                ${row.nombres + " " + row.apellidos} 
                            </div>`
                    }
                    my_columns.push(my_item);
                } else if (key == 'nombre_acudiente') {

                    my_item.title = 'Acudiente';

                    my_item.render = function (data, type, row) {
                        return `<div>
                                ${row.nombre_acudiente + " " + row.apellido_acudiente}
                            </div>`
                    }
                    my_columns.push(my_item);
                } else if (key == 'grado') {

                    my_item.title = 'Curso';

                    my_item.render = function (data, type, row) {
                        return `<div>
                                ${row.grado + "-" + row.curso} 
                            </div>`
                    }
                    my_columns.push(my_item);
                } else if (key == 'multimedia') {

                    my_item.title = 'Multimedia';

                    my_item.render = function (data, type, row) {
                        return `<div align="center">
                                <a class="btn btn-default ${row.multimedia == 'undefined' || row.multimedia == null ? 'disabled' : ''}" id="Btn_file_${row.id}" data-id=${row.id} >
                                    <i class="fa fa-file"></i>
                                </a>
                            </div>`
                    }
                    my_columns.push(my_item);
                } else if (key == 'emisor') {

                    my_item.title = 'Emisor';

                    my_item.render = function (data, type, row) {
                        return `<div>
                                ${JSON.parse(row.emisor).email}
                            </div>`
                    }
                    my_columns.push(my_item);
                } else if (key == 'titulo_tc') {

                    my_item.title = 'Tipo de conducta';

                    my_item.render = function (data, type, row) {
                        return `<div>
                                ${row.titulo_tc == null ? `<span class="label label-warning">Sin asignar</span>` : row.titulo_tc}
                            </div>`
                    }
                    my_columns.push(my_item);
                }
            })
            //${JSON.parse(row.emisor).email}

            $('#comportamientos-table').DataTable({
                //'responsive': true,
                'scrollX': my_columns.length >= 6 ? true : false,
                "destroy": true,
                data: response,
                "columns": my_columns,
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No hay datos registrados",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ comportamientos",
                    "infoEmpty": "No hay comportamientos registrados",
                    "infoFiltered": "(Filtrado de _MAX_  comportamientos)",
                    "lengthMenu": "_MENU_ comportamientos",
                    "search": "Buscar:",
                    "zeroRecords": "No se han encontrado registros"
                },
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                "order": [
                    [2, 'asc']
                ],
                "lengthMenu": [
                    [10, 15, 20, -1],
                    [10, 15, 20, "Todos"]
                ],
                "createdRow": function (row, data, dataIndex) {
                    if (AllRegister[dataIndex].id_actividad == null) {
                        $(row).css('background-color', '#ffedd9');
                    }
                }
            });

            $('thead > tr> th:nth-child(1)').css({ 'min-width': '30px', 'max-width': '30px' });
            $('thead > tr> th:nth-child(2)').css({ 'min-width': '100px', 'max-width': '100px' });
            $('thead > tr> th:nth-child(3)').css({ 'min-width': '160px', 'max-width': '160px' });
            $('thead > tr> th:nth-child(4)').css({ 'min-width': '80px', 'max-width': '80px' });
            $('thead > tr> th:nth-child(5)').css({ 'min-width': '120px', 'max-width': '120px' });
            $('thead > tr> th:nth-child(6)').css({ 'min-width': '120px', 'max-width': '120px' });
            $('thead > tr> th:nth-child(7)').css({ 'min-width': '120px', 'max-width': '120px' });
            $('thead > tr> th:nth-child(11)').css({ 'min-width': '120px', 'max-width': '120px' })


        }
    }
});