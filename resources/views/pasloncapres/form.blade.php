<div class="box-body">

	@php
	$class = $errors->has('no_urut') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('no_urut') ? $errors->first('no_urut') : '';
	@endphp
	<div class="{{$class}}">
		<label for="no_urut" data-toggle="tooltip" title="{{$message}}">No Urut</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::text('no_urut',null,['class'=> 'form-control','placeholder'=>'Isi No Urut', 'id' => 'no_urut']) !!}
		</div>
	</div>

	@php
	$class = $errors->has('paslon_capres') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('paslon_capres') ? $errors->first('paslon_capres') : '';
	@endphp
	<div class="{{$class}}">
		<label for="paslon_capres" data-toggle="tooltip" title="{{$message}}">Paslon Capres</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::text('paslon_capres',null,['class'=> 'form-control','placeholder'=>'Isi Paslon Capres', 'id' => 'paslon_capres']) !!}
		</div>
	</div>

	@php
	$class = $errors->has('foto') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('foto') ? $errors->first('foto') : '';
	@endphp
	<div class="{{$class}}">
		<label for="foto" data-toggle="tooltip" title="{{$message}}">Foto</label>
		@if(isset($paslonCapres) && file_exists(storage_path('app/public/files/foto/' . $paslonCapres->id)))
			<a href="{{asset('storage/files/foto/' . $paslonCapres->id)}}?nocache={{time()}}" target="_blank">
				<img class="img-responsive" src="{{asset('storage/files/foto/' . $paslonCapres->id)}}?nocache={{time()}}">
			</a>
		@elseif(isset($paslonCapres))
			<img class="img-responsive" src="{{asset('storage/assets/inf')}}">
		@endif
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::file('foto',['class'=> 'form-control','id' => 'foto']) !!}
		</div>
	</div>

</div>