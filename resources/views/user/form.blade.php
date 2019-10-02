<div class="box-body">

	@php
	$class = $errors->has('nama') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('nama') ? $errors->first('nama') : '';
	@endphp
	<div class="{{$class}}">
		<label for="nama" data-toggle="tooltip" title="{{$message}}">Nama</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::text('nama',null,['class'=> 'form-control', 'placeholder'=>'Isi Nama', 'id' => 'nama']) !!}
		</div>
	</div>

	@php
	$class = $errors->has('username') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('username') ? $errors->first('username') : '';
	@endphp
	<div class="{{$class}}">
		<label for="username" data-toggle="tooltip" title="{{$message}}">Username</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::text('username',null,['class'=> 'form-control', 'placeholder'=>'Isi Username', 'id' => 'username']) !!}
		</div>
	</div>

	@php
	$class = $errors->has('level') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('level') ? $errors->first('level') : '';
	@endphp
	<div class="{{$class}}">
		<label for="level" data-toggle="tooltip" title="{{$message}}">Level</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::select('level',[
					'opkab' => 'Operator Kabupaten',
					'opprov' => 'Operator Provinsi',
				],null,['class'=> 'form-control select2','placeholder'=>'Pilih Level','id'=>'level','style'=>'width: 100%']) !!}
		</div>
	</div>

	<div id="div__id_kabupaten">
		@php
		$class = $errors->has('id_kabupaten') ? 'form-group has-error' : 'form-group';
		$message = $errors->has('id_kabupaten') ? $errors->first('id_kabupaten') : '';
		@endphp
		<div class="{{$class}}">
			<label for="id_kabupaten" data-toggle="tooltip" title="{{$message}}">Kabupaten</label>
			<div data-toggle="tooltip" title="{{$message}}">
				{!! Form::select('id_kabupaten', $kabupatens,null,['class'=> 'form-control select2','placeholder'=>'Pilih Kabupaten','id'=>'id_kabupaten','style'=>'width: 100%']) !!}
			</div>
		</div>
	</div>

	@php
	$class = $errors->has('password') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('password') ? $errors->first('password') : '';
	@endphp
	<div class="{{$class}}">
		<label for="password" data-toggle="tooltip" title="{{$message}}">Password</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::password('password',['class'=> 'form-control','placeholder'=>'Isi Password', 'id' => 'password']) !!}
		</div>
	</div>
	
	@php
	$class = $errors->has('password') ? 'form-group has-error' : 'form-group';
	$message = $errors->has('password') ? $errors->first('password') : '';
	@endphp
	<div class="{{$class}}">
		<label for="password_confirmation" data-toggle="tooltip" title="{{$message}}">Password Konfirmasi</label>
		<div data-toggle="tooltip" title="{{$message}}">
			{!! Form::password('password_confirmation',['class'=> 'form-control','placeholder'=>'Isi Password Konfirmasi', 'id' => 'password_confirmation']) !!}
		</div>
	</div>
	
</div>

@section('js')
@parent
<script type="text/javascript">
	$("#level").change(function() {
		if ($("#level").val() == 'opkab') {
			$("#div__id_kabupaten").show();
		} else {
			$("#id_kabupaten").val('').trigger('change');
			$("#div__id_kabupaten").hide();
		}
	});

	$("#level").trigger("change");
</script>
@endsection