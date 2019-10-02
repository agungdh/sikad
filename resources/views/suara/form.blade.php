<div class="box-body">

        <div class="col-md-6">
          <div class="form-group">
            <label for="periode">Periode</label>
            <div>
              {!! Form::text('periode',$pemilihan->periode->periode,['class'=> 'form-control','placeholder'=>'Isi Periode', 'id' => 'periode', 'disabled' => true]) !!}
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="pemilihan">Pemilihan</label>
            <div>
              {!! Form::text('pemilihan',ADHhelper::displayTipePemilihan($pemilihan->tipe),['class'=> 'form-control','placeholder'=>'Isi pemilihan', 'id' => 'pemilihan', 'disabled' => true]) !!}
            </div>
          </div>
        </div>

	<div class="col-md-12">

		@php
		$class = $errors->has('id_kecamatan') ? 'form-group has-error' : 'form-group';
		$message = $errors->has('id_kecamatan') ? $errors->first('id_kecamatan') : '';
		@endphp
		<div class="{{$class}}">
			<label for="id_kecamatan" data-toggle="tooltip" title="{{$message}}">Kecamatan</label>
			<div data-toggle="tooltip" title="{{$message}}">
				{!! Form::select('id_kecamatan',$kecamatans,null,['class'=> 'form-control select2','placeholder'=>'Pilih Kecamatan','id'=>'id_kecamatan']) !!}
			</div>
		</div>

		@php
		$class = $errors->has('jumlah_kelurahan') ? 'form-group has-error' : 'form-group';
		$message = $errors->has('jumlah_kelurahan') ? $errors->first('jumlah_kelurahan') : '';
		@endphp
		<div class="{{$class}}">
			<label for="jumlah_kelurahan" data-toggle="tooltip" title="{{$message}}">Jumlah Kelurahan</label>
			<div data-toggle="tooltip" title="{{$message}}">
				{!! Form::text('jumlah_kelurahan',null,['class'=> 'form-control mask_ribuan','placeholder'=>'Isi Jumlah Kelurahan', 'id' => 'jumlah_kelurahan']) !!}
			</div>
		</div>

		@php
		$class = $errors->has('jumlah_tps') ? 'form-group has-error' : 'form-group';
		$message = $errors->has('jumlah_tps') ? $errors->first('jumlah_tps') : '';
		@endphp
		<div class="{{$class}}">
			<label for="jumlah_tps" data-toggle="tooltip" title="{{$message}}">Jumlah TPS</label>
			<div data-toggle="tooltip" title="{{$message}}">
				{!! Form::text('jumlah_tps',null,['class'=> 'form-control mask_ribuan','placeholder'=>'Isi Jumlah TPS', 'id' => 'jumlah_tps']) !!}
			</div>
		</div>

		@php
		$class = $errors->has('jumlah_pemilih') ? 'form-group has-error' : 'form-group';
		$message = $errors->has('jumlah_pemilih') ? $errors->first('jumlah_pemilih') : '';
		@endphp
		<div class="{{$class}}">
			<label for="jumlah_pemilih" data-toggle="tooltip" title="{{$message}}">Jumlah Pemilih</label>
			<div data-toggle="tooltip" title="{{$message}}">
				{!! Form::text('jumlah_pemilih',null,['class'=> 'form-control mask_ribuan','placeholder'=>'Isi Jumlah Pemilih', 'id' => 'jumlah_pemilih']) !!}
			</div>
		</div>

		@php
		$class = $errors->has('jumlah_suara_tidak_sah') ? 'form-group has-error' : 'form-group';
		$message = $errors->has('jumlah_suara_tidak_sah') ? $errors->first('jumlah_suara_tidak_sah') : '';
		@endphp
		<div class="{{$class}}">
			<label for="jumlah_suara_tidak_sah" data-toggle="tooltip" title="{{$message}}">Jumlah Suara Tidak Sah</label>
			<div data-toggle="tooltip" title="{{$message}}">
				{!! Form::text('jumlah_suara_tidak_sah',null,['class'=> 'form-control mask_ribuan','placeholder'=>'Isi Jumlah Suara Tidak Sah', 'id' => 'jumlah_suara_tidak_sah']) !!}
			</div>
		</div>

	</div>

</div>