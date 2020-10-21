@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Comportamiento
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('comportamientos.show_fields')
                    <a href="{{ route('comportamientos.index') }}" class="btn btn-default">Atrás</a>
                </div>
            </div>
        </div>
    </div>
    @include('comportamientos.create')

    @include('layouts.scripts')
    <script>
        var modal = $("#modal-comportamientos");
        var ruta = $('#ruta_archivo').val();
    
        $('#showfile').on('click', function () {
        modal.modal('show')

        
        var json = ruta.split('PSIAPP');
        console.log(json)
        var html = ''
        var a=0;
        for(var i=0; i<json.length; i++)
        {
            if( json[i] != '')
            {
                var icon = 'fa fa-file';

                var extension = json[i].split('.')[2];
                switch(extension)
                {
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
                            <h3 class="box-title">Archivo ${a+1}</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group" align="center">
                                <a target="_blank" href="../${json[i]}" type="button" style="font-size: 2em;" class="btn-link">
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
    
        
    });
    
    </script>
@endsection
