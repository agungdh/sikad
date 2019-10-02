@extends('template.template')

@section('title')
Dashboard
@endsection

@section('nav')
@include('dashboard.nav')
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
                          @php
                          switch ($item->tipe) {
                            case 'presiden':
                              $tipe = 'suaracapres';
                              break;
                            case 'dpr':
                            case 'dprdk':
                            case 'dprdp':
                              $tipe = 'suarapartai';
                              break;
                            case 'dpd':
                              $tipe = 'suaradpd';
                              break;
                            default:
                              $tipe = 'Error !!!';
                              break;
                          }
                          @endphp
                          <a class="btn btn-primary btn-sm" href="{{route('dashboard.' . $tipe . '.index', $item->id)}}">
                            <i class="glyphicon glyphicon-pencil"></i> Suara
                          </a>   
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