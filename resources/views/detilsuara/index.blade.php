@extends('template.template')

@section('title')
Detil
@endsection

@section('nav')
@include('detilsuara.nav')
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

        <div class="col-md-6">
          <div class="form-group">
            <label for="kecamatan">Kecamatan</label>
            <div>
              {!! Form::text('kecamatan',$suara->kecamatan->kecamatan,['class'=> 'form-control','placeholder'=>'Isi kecamatan', 'id' => 'kecamatan', 'disabled' => true]) !!}
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
              <h3 class="box-title">Data Detil</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @if(ADHhelper::getUserData()->level == 'opkab')
                <a class="btn btn-success btn-sm" href="{{route('detilsuara.create', $suara->id)}}">
                  <i class="glyphicon glyphicon-plus"></i> Tambah
                </a><br><br>
              @endif
              <table class="table table-bordered table-hover datatable" style="width: 100%">
                <thead>
                    <tr>
                      <th>{{ADHhelper::displayKandidat($pemilihan->tipe)}}</th>
                      <th>Jumlah</th>
                      <th>Proses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detilSuaras as $item)

                    <tr>
                        <td>{{ADHhelper::displayDataKandidat($pemilihan->tipe, $item)}}</td>
                        <td>{{ADHhelper::rupiah($item->jumlah, false, false)}}</td>
                        
                        <td>

                            {!! Form::open(['id' => 'formHapus' . $item->id, 'route' => ['detilsuara.destroy', $item->id], 'method' => 'delete']) !!}

                                @if(ADHhelper::getUserData()->level == 'opkab')
                                  <a class="btn btn-primary btn-sm" href="{{route('detilsuara.edit', $item->id)}}">
                                    <i class="glyphicon glyphicon-pencil"></i> Edit
                                  </a>

                                  <button type="button" class="btn btn-danger btn-sm" onclick="hapus('{{ $item->id }}')"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
                                @endif

                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
function hapus(id) {
    swal({
      title: "Yakin Hapus ???",
      text: "Data yang sudah dihapus tidak dapat dikembalikan lagi !!!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Hapus",
    }, function(){
      $("#formHapus" + id).submit();
    });
}
</script>
@endsection