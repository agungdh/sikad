<h3><center>REKAPITULASI HASIL SEMENTARA PENGHITUNGAN SUARA PEMILU DPD DI PROVINSI LAMPUNG {{$pemilihan->periode->periode}}</center></h3>
<table style="width: 100%" border="1">
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