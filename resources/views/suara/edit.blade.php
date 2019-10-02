@extends('template.template')

@section('title')
Suara
@endsection

@section('nav')
@include('suara.nav')
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
        <div class="box animated jackInTheBox box-primary" style="box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);">
			<div class="box-header with-border">
				<h3 class="box-title">Ubah Suara</h3>
			</div>

			{!! Form::model($suara, ['route' => ['suara.update', $suara->id], 'role' => 'form', 'method' => 'put', 'files' => true]) !!}
				@include('suara.form')

				<div class="box-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<a href="{{route('suara.index', $pemilihan->id)}}" class="btn btn-info">Batal</a>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection