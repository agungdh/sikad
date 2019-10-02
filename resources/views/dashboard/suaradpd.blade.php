@extends('template.template')

@section('title')
Suara
@endsection

@section('nav')
@include('dashboard.nav')
<li><a href="{{ route('dashboard.suaradpd.index', $pemilihan->id) }}"> Suara</a></li>
@endsection

@section('content')
<script type="text/javascript">
  var PieData = [];
</script>
<div class="row">
 
  <div class="col-md-12">
    <div class="box animated jackInTheBox box-primary" style="box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);">
      
      <div class="box-body">

        <div class="col-md-3">
          <div class="col-md-12">
            <div class="form-group">
              <label for="periode">Periode</label>
              <div>
                {!! Form::text('periode',$pemilihan->periode->periode,['class'=> 'form-control','placeholder'=>'Isi Periode', 'id' => 'periode', 'disabled' => true]) !!}
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label for="pemilihan">Pemilihan</label>
              <div>
                {!! Form::text('pemilihan',ADHhelper::displayTipePemilihan($pemilihan->tipe),['class'=> 'form-control','placeholder'=>'Isi pemilihan', 'id' => 'pemilihan', 'disabled' => true]) !!}
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <a target="_blank" class="btn btn-success" href="{{route('dashboard.suaradpd.pdf', $pemilihan->id)}}">PDF</a>
            </div>
          </div>
        </div>

        <div class="col-md-9">
          <h3>Grafik</h3>
          <canvas id="pieChart" style="height:250px"></canvas>
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
              <div class="">
                <table class="table table-bordered table-hover datatable" style="width: 100%">
                  <thead>
                      <tr>
                        <th>Nama</th>
                        @foreach($kabupatens as $kabupaten)
                        <th>{{$kabupaten->kabupaten}}</th>
                        @endforeach
                        <th>Jumlah</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php
                      $jumlahSuaraSah = [];
                      $jumlahTotalSuaraSah = 0;
                      
                      $jumlahTotalSuaraTidakSah = 0;
                      $jumlahSuaraTidakSah = [];

                      $jumlahTotalSuaraPemilih = 0;
                      $jumlahSuaraPemilih = [];

                      $jumlahTotalSuaraTidakMemilih = 0;
                      $jumlahSuaraTidakMemilih = [];

                      foreach ($kabupatens as $kabupaten) {
                        $jumlahSuaraSah[$kabupaten->id] = 0;
                        $jumlahSuaraTidakSah[$kabupaten->id] = 0;
                        $jumlahSuaraPemilih[$kabupaten->id] = 0;
                        $jumlahSuaraTidakMemilih[$kabupaten->id] = 0;
                      }

                      @endphp
                      @foreach($dpds as $dpd)
                      @php
                      $jumlahAllDPD = 0;
                      @endphp
                      <tr>
                          <td>{{$dpd->nama}}</td>
                          @foreach($kabupatens as $kabupaten)
                            @php
                              $kecamatans_raw = App\Models\Kecamatan::where('id_kabupaten', $kabupaten->id)->get();
                              $kecamatans = [];
                              foreach ($kecamatans_raw as $kecamatan_raw) {
                                $kecamatans[] = $kecamatan_raw->id;
                              }
                              
                              $jumlahSahRaw = DB::select('SELECT sum(ds.jumlah) jumlah
                                FROM pemilihan pl, suara_pemilihan sp, detil_suara_pemilihan ds
                                WHERE ds.id_suara_pemilihan = sp.id
                                AND sp.id_pemilihan = pl.id
                                AND pl.id = ?
                                AND ds.id_calon_dpd = ?
                                AND sp.id_kecamatan IN (' . implode(",", $kecamatans) . ')', [$pemilihan->id, $dpd->id]);
                              $jumlah = $jumlahSahRaw[0]->jumlah;
                              $jumlahAllDPD += $jumlah;
                              $jumlahSuaraSah[$kabupaten->id] += $jumlah;

                              $jumlahTidakSahRaw = DB::select('SELECT sum(sp.jumlah_suara_tidak_sah) jumlah
                                FROM pemilihan pl, suara_pemilihan sp, detil_suara_pemilihan ds
                                WHERE ds.id_suara_pemilihan = sp.id
                                AND sp.id_pemilihan = pl.id
                                AND pl.id = ?
                                AND ds.id_calon_dpd = ?
                                AND sp.id_kecamatan IN (' . implode(",", $kecamatans) . ')', [$pemilihan->id, $dpd->id]);
                              $jumlahTidakSah = $jumlahTidakSahRaw[0]->jumlah;
                              $jumlahSuaraTidakSah[$kabupaten->id] += $jumlahTidakSah;

                              $jumlahPemilihRaw = DB::select('SELECT sum(sp.jumlah_pemilih) jumlah
                                FROM pemilihan pl, suara_pemilihan sp, detil_suara_pemilihan ds
                                WHERE ds.id_suara_pemilihan = sp.id
                                AND sp.id_pemilihan = pl.id
                                AND pl.id = ?
                                AND ds.id_calon_dpd = ?
                                AND sp.id_kecamatan IN (' . implode(",", $kecamatans) . ')', [$pemilihan->id, $dpd->id]);
                              $jumlahPemilih = $jumlahPemilihRaw[0]->jumlah;
                              $jumlahSuaraPemilih[$kabupaten->id] += $jumlahPemilih;
                            @endphp
                            <td>{{ADHhelper::rupiah($jumlah, false, false)}}</td>
                          @endforeach
                          <td>{{ADHhelper::rupiah($jumlahAllDPD, false, false)}}</td>
                          <script type="text/javascript">
                                PieData.push({
                                  value    : {{$jumlahAllDPD}},
                                  @php
                                  $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
                                  @endphp
                                  color    : '{{$color}}',
                                  highlight: '{{$color}}',
                                  label    : '{{$dpd->nama}}'
                                });
                          </script>
                      </tr>
                      @endforeach
                  </tbody>
                  @php
                  foreach ($jumlahSuaraSah as $item) {
                    $jumlahTotalSuaraSah += $item;
                  }
                  foreach ($jumlahSuaraTidakSah as $item) {
                    $jumlahTotalSuaraTidakSah += $item;
                  }
                  foreach ($jumlahSuaraPemilih as $item) {
                    $jumlahTotalSuaraPemilih += $item;
                  }
                  foreach ($jumlahSuaraTidakMemilih as $item) {
                    $jumlahTotalSuaraTidakMemilih += $item;
                  }
                  @endphp
                  <tfoot>
                    <tr>
                      <th colspan="1">Jumlah Suara Sah</th>
                      @foreach($kabupatens as $kabupaten)
                      <th>{{ADHhelper::rupiah($jumlahSuaraSah[$kabupaten->id], false, false)}}</th>
                      @endforeach
                      <th>{{ADHhelper::rupiah($jumlahTotalSuaraSah, false, false)}}</th>
                    </tr>
                    <tr>
                      <th colspan="1">Jumlah Suara Tidak Sah</th>
                      @foreach($kabupatens as $kabupaten)
                      <th>{{ADHhelper::rupiah($jumlahSuaraTidakSah[$kabupaten->id], false, false)}}</th>
                      @endforeach
                      <th>{{ADHhelper::rupiah($jumlahTotalSuaraTidakSah, false, false)}}</th>
                    </tr>
                    <tr>
                      <th colspan="1">Jumlah Memilih</th>
                      @foreach($kabupatens as $kabupaten)
                      <th>{{ADHhelper::rupiah($jumlahSuaraSah[$kabupaten->id] + $jumlahSuaraTidakSah[$kabupaten->id], false, false)}}</th>
                      @endforeach
                      <th>{{ADHhelper::rupiah($jumlahTotalSuaraSah + $jumlahTotalSuaraTidakSah, false, false)}}</th>
                    </tr>
                    <tr>
                      <th colspan="1">Jumlah Tidak Memilih</th>
                      @foreach($kabupatens as $kabupaten)
                      <th>{{ADHhelper::rupiah($jumlahSuaraPemilih[$kabupaten->id] - ($jumlahSuaraSah[$kabupaten->id] + $jumlahSuaraTidakSah[$kabupaten->id]), false, false)}}</th>
                      @endforeach
                      <th>{{ADHhelper::rupiah($jumlahTotalSuaraPemilih - ($jumlahTotalSuaraSah + $jumlahTotalSuaraTidakSah), false, false)}}</th>
                    </tr>
                    <tr>
                      <th colspan="1">Jumlah Pemilih</th>
                      @foreach($kabupatens as $kabupaten)
                      <th>{{ADHhelper::rupiah($jumlahSuaraPemilih[$kabupaten->id], false, false)}}</th>
                      @endforeach
                      <th>{{ADHhelper::rupiah($jumlahTotalSuaraPemilih, false, false)}}</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
    </div>
</div>
@endsection

@section('js')
@parent
<script type="text/javascript">
   //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)

    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions)
</script>
@endsection