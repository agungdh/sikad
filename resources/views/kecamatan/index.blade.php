@extends('template.template')

@section('title')
Kecamatan
@endsection

@section('nav')
@include('kecamatan.nav')
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
        <div class="box animated jackInTheBox box-primary" style="box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);">
      <div class="box-body">
        <div class="col-md-12">
          <div class="form-group">
            <label for="kabupaten">Kabupaten</label>
            <div>
              {!! Form::text('kabupaten',$kabupaten->kabupaten,['class'=> 'form-control','placeholder'=>'Isi Kabupaten', 'id' => 'kabupaten', 'disabled' => true]) !!}
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
              <h3 class="box-title">Data Kecamatan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <a class="btn btn-success btn-sm" href="{{route('kecamatan.create', $kabupaten->id)}}">
                  <i class="glyphicon glyphicon-plus"></i> Tambah
                </a><br><br>
              <table class="table table-bordered table-hover datatable" style="width: 100%">
                <thead>
                    <tr>
                      <th>Kecamatan</th>
                      <th>Proses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kecamatans as $item)

                    <tr>
                        <td>{{$item->kecamatan}}</td>
                        
                        <td>

                            {!! Form::open(['id' => 'formHapus' . $item->id, 'route' => ['kecamatan.destroy', $item->id], 'method' => 'delete']) !!}

                                <a class="btn btn-primary btn-sm" href="{{route('kecamatan.edit', $item->id)}}">
                                  <i class="glyphicon glyphicon-pencil"></i> Edit
                                </a>

                                <button type="button" class="btn btn-danger btn-sm" onclick="hapus('{{ $item->id }}')"><i class="glyphicon glyphicon-trash"></i> Hapus</button>

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