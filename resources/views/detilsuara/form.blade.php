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

        <div class="col-md-6">
          <div class="form-group">
            <label for="kecamatan">Kecamatan</label>
            <div>
              {!! Form::text('kecamatan',$suara->kecamatan->kecamatan,['class'=> 'form-control','placeholder'=>'Isi kecamatan', 'id' => 'kecamatan', 'disabled' => true]) !!}
            </div>
          </div>
        </div>

	<div class="col-md-12">

		@php
		$class = $errors->has(ADHhelper::displayIdKandidat($pemilihan->tipe)) ? 'form-group has-error' : 'form-group';
		$message = $errors->has(ADHhelper::displayIdKandidat($pemilihan->tipe)) ? $errors->first(ADHhelper::displayIdKandidat($pemilihan->tipe)) : '';
		@endphp
		<div class="{{$class}}">
			<label for="{{ADHhelper::displayIdKandidat($pemilihan->tipe)}}" data-toggle="tooltip" title="{{$message}}">{{ADHhelper::displayKandidat($pemilihan->tipe)}}</label>
			<div data-toggle="tooltip" title="{{$message}}">
				{!! Form::select(ADHhelper::displayIdKandidat($pemilihan->tipe),ADHhelper::getSelectKandidat($pemilihan->tipe),null,['class'=> 'form-control select2','placeholder'=>'Pilih ' . ADHhelper::displayKandidat($pemilihan->tipe),'id'=>ADHhelper::displayIdKandidat($pemilihan->tipe)]) !!}
			</div>
		</div>

		@php
		$class = $errors->has('jumlah') ? 'form-group has-error' : 'form-group';
		$message = $errors->has('jumlah') ? $errors->first('jumlah') : '';
		@endphp
		<div class="{{$class}}">
			<label for="jumlah" data-toggle="tooltip" title="{{$message}}">Jumlah</label>
			<div data-toggle="tooltip" title="{{$message}}">
				{!! Form::text('jumlah',null,['class'=> 'form-control mask_ribuan','placeholder'=>'Isi Jumlah', 'id' => 'jumlah']) !!}
			</div>
		</div>

	</div>

</div>