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

    @include('layouts.scripts')

@endsection
