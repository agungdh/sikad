<div class="box-body">

	@php
	$class = $errors->has('id_partai') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('id_partai') ? $errors->first('id_partai') : '';
	@endphp
	<div class="{{$class}}">
		<label for="id_partai" data-toggle="tooltip" title="{{$message}}">Partai</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::select('id_partai',$partais,null,['class'=> 'form-control select2','placeholder'=>'Pilih Partai','id'=>'id_partai']) !!}
		</div>
	</div>

	@php
	$class = $errors->has('nama') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('nama') ? $errors->first('nama') : '';
	@endphp
	<div class="{{$class}}">
		<label for="nama" data-toggle="tooltip" title="{{$message}}">Calon DPD</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::text('nama',null,['class'=> 'form-control','placeholder'=>'Isi Calon DPD', 'id' => 'nama']) !!}
		</div>
	</div>

</div>