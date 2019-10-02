@extends('template.template')

@section('title')
Kecamatan
@endsection

@section('nav')
@include('kecamatan.nav')
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
        <div class="box animated jackInTheBox box-primary" style="box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);">
			<div class="box-header with-border">
				<h3 class="box-title">Tambah Kecamatan</h3>
			</div>

			{!! Form::open(['route' => ['kecamatan.store', $kabupaten->id], 'role' => 'form']) !!}
				@include('kecamatan.form')

				<div class="box-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<a href="{{route('kecamatan.index', $kabupaten->id)}}" class="btn btn-info">Batal</a>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection