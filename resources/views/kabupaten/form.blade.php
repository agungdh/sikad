<div class="box-body">

	@php
	$class = $errors->has('kabupaten') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('kabupaten') ? $errors->first('kabupaten') : '';
	@endphp
	<div class="{{$class}}">
		<label for="kabupaten" data-toggle="tooltip" title="{{$message}}">Kabupaten</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::text('kabupaten',null,['class'=> 'form-control','placeholder'=>'Isi Kabupaten', 'id' => 'kabupaten']) !!}
		</div>
	</div>

</div>