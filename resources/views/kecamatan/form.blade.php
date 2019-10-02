<div class="box-body">

	<div class="col-md-12">
		<div class="form-group">
			<label for="kabupaten">Kabupaten</label>
			<div>
				{!! Form::text('kabupaten',$kabupaten->kabupaten,['class'=> 'form-control','placeholder'=>'Isi Kabupaten', 'id' => 'kabupaten', 'disabled' => true]) !!}
			</div>
		</div>
	</div>

	<div class="col-md-12">
		@php
		$class = $errors->has('kecamatan') ? 'form-group has-error' : 'form-group';
		$message = $errors->has('kecamatan') ? $errors->first('kecamatan') : '';
		@endphp
		<div class="{{$class}}">
			<label for="kecamatan" data-toggle="tooltip" title="{{$message}}">kecamatan</label>
			<div data-toggle="tooltip" title="{{$message}}">
				{!! Form::text('kecamatan',null,['class'=> 'form-control','placeholder'=>'Isi kecamatan', 'id' => 'kecamatan']) !!}
			</div>
		</div>
	</div>

</div>