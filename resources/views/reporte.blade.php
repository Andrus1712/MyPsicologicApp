@extends('layouts.app')

@section('content')
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">

                    <div id="contenido" style="width:70%">
                        <h1>Hello, world!</h1>
                        <p>This jQuery plugin takes the HTML from any element on the page and converts it (all on the client-side) to MHTML (MIME-HTML) with .doc as the file extension. What this does is that it archives the HTML by embedding images into the file for offline viewing, and then Microsoft Word will open the file and automatically interpret it into a rich document with header and body styles as well as images. Go ahead and click the link on the right to try it out. Note that it won't work on a phone or tablet, and you'll need to open with Microsoft Word for it to correctly interpret the file (currently, the output file doesn't get handled properly by LibreOffice).</p>
                    </div>
                </div>
            </div>
            
                <!-- Export to DOC button -->
                <button id="ExportToWord" class="btn btn-default"> Exportar a Word(.doc) </button>
        </div>
    </div>

@endsection

@include('layouts.scripts')
<script src="js/reportes/main.js"></script>