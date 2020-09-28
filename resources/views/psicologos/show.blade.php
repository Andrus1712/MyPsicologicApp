@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Psicologo
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('psicologos.show_fields')
                    <a href="{{ route('psicologos.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
