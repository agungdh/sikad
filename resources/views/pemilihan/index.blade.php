@extends('template.template')

@section('title')
Pemilihan
@endsection

@section('nav')
@include('pemilihan.nav')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box animated slideInLeft box-primary" style="box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);">
            <div class="box-header">
              <h3 class="box-title">Data Pemilihan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @if(ADHhelper::getUserData()->level == 'opprov')
                <a class="btn btn-success btn-sm" href="{{route('pemilihan.create')}}">
                  <i class="glyphicon glyphicon-plus"></i> Tambah
                </a><br><br>
              @endif
              <table class="table table-bordered table-hover datatable" style="width: 100%">
                <thead>
                    <tr>
                      <th>Pemilihan</th>
                      <th>Periode</th>
                      <th>Proses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemilihans as $item)

                    <tr>
                        <td>{{ADHhelper::displayTipePemilihan($item->tipe)}}</td>
                        <td>{{$item->periode->periode}}</td>
                        
                        <td>
                          
                                {!! Form::open(['id' => 'formHapus' . $item->id, 'route' => ['pemilihan.destroy', $item->id], 'method' => 'delete']) !!}

                                    <a class="btn btn-primary btn-sm" href="{{route('suara.index', $item->id)}}">
                                      <i class="glyphicon glyphicon-pencil"></i> Suara
                                    </a>                                
                                @if(ADHhelper::getUserData()->level == 'opprov')
                                
                                    <a class="btn btn-primary btn-sm" href="{{route('pemilihan.edit', $item->id)}}">
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