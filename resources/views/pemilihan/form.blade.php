<div class="box-body">

	@php
	$class = $errors->has('id_periode') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('id_periode') ? $errors->first('id_periode') : '';
	@endphp
	<div class="{{$class}}">
		<label for="id_periode" data-toggle="tooltip" title="{{$message}}">Periode</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::select('id_periode',$periodes,null,['class'=> 'form-control select2','placeholder'=>'Pilih Periode','id'=>'id_periode']) !!}
		</div>
	</div>

	@php
	$class = $errors->has('tipe') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('tipe') ? $errors->first('tipe') : '';
	@endphp
	<div class="{{$class}}">
		<label for="tipe" data-toggle="tooltip" title="{{$message}}">Tipe</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::select('tipe',$tipes,null,['class'=> 'form-control select2','placeholder'=>'Pilih Tipe','id'=>'tipe']) !!}
		</div>
	</div>

</div>