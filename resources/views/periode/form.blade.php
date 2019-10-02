<div class="box-body">

	@php
	$class = $errors->has('periode') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('periode') ? $errors->first('periode') : '';
	@endphp
	<div class="{{$class}}">
		<label for="periode" data-toggle="tooltip" title="{{$message}}">Periode</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::text('periode',null,['class'=> 'form-control','placeholder'=>'Isi Periode', 'id' => 'periode']) !!}
		</div>
	</div>

</div>