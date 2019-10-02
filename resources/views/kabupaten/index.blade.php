@extends('template.template')

@section('title')
Kabupaten
@endsection

@section('nav')
@include('kabupaten.nav')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box animated slideInLeft box-primary" style="box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);">
            <div class="box-header">
              <h3 class="box-title">Data Kabupaten</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <a class="btn btn-success btn-sm" href="{{route('kabupaten.create')}}">
                  <i class="glyphicon glyphicon-plus"></i> Tambah
                </a><br><br>
              <table class="table table-bordered table-hover datatable" style="width: 100%">
                <thead>
                    <tr>
                      <th>Kabupaten</th>
                      <th>Proses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kabupatens as $item)

                    <tr>
                        <td>{{$item->kabupaten}}</td>
                        
                        <td>

                            {!! Form::open(['id' => 'formHapus' . $item->id, 'route' => ['kabupaten.destroy', $item->id], 'method' => 'delete']) !!}

                                <a class="btn btn-primary btn-sm" href="{{route('kecamatan.index', $item->id)}}">
                                  <i class="glyphicon glyphicon-map-marker"></i> Kecamatan
                                </a>

                                <a class="btn btn-primary btn-sm" href="{{route('kabupaten.edit', $item->id)}}">
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