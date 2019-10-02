@extends('template.template')

@section('title')
Suara
@endsection

@section('nav')
@include('dashboard.nav')
<li><a href="{{ route('dashboard.suara.index', $pemilihan->id) }}"> Suara</a></li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
        <div class="box animated jackInTheBox box-primary" style="box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);">
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
      </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box animated slideInLeft box-primary" style="box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);">
            <div class="box-header">
              <h3 class="box-title">Data Suara</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @if(ADHhelper::getUserData()->level == 'opkab')
                <a class="btn btn-success btn-sm" href="{{route('dashboard.create', $pemilihan->id)}}">
                  <i class="glyphicon glyphicon-plus"></i> Tambah
                </a><br><br>
              @endif
              <div class="table-responsive">
                <table class="table table-bordered table-hover" style="width: 100%">
                  <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Partai</th>
                        <th>Logo Partai</th>
                        @foreach(App\Models\Kabupaten::all() as $kabupaten)
                        <th>{{$kabupaten->kabupaten}}</th>
                        @endforeach
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($suaras as $item)
                      @php
                      $jumlahSuaraSah = 0;
                      foreach ($item->detilSuaras as $detilSuara) {
                        $jumlahSuaraSah += $detilSuara->jumlah;
                      }
                      @endphp
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$item->partai}}</td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
    </div>
</div>
@endsection