<li><a href="{{ route('pemilihan.index') }}"><i class="fa fa-home"></i> Pemilihan</a></li>
<li><a href="{{ route('suara.index', $pemilihan->id) }}"> Suara</a></li>
<li><a href="{{ route('detilsuara.index', $suara->id) }}"> Detil</a></li>