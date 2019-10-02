@extends('template.template')

@section('title')
Kabupaten
@endsection

@section('nav')
@include('kabupaten.nav')
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
        <div class="box animated jackInTheBox box-primary" style="box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);">
			<div class="box-header with-border">
				<h3 class="box-title">Tambah Kabupaten</h3>
			</div>

			{!! Form::open(['route' => 'kabupaten.store', 'role' => 'form', 'files' => true]) !!}
				@include('kabupaten.form')

				<div class="box-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<a href="{{route('kabupaten.index')}}" class="btn btn-info">Batal</a>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection