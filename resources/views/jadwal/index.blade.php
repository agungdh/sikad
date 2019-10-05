@extends('template.palih')

@section('title')
<h1><i class="fa fa-th-list"></i> Jadwal Kuliah</h1>
@endsection

@section('nav')
<li class="breadcrumb-item"><a href="{{route('matkul.index')}}">Jadwal Kuliah</a></li>
@endsection

@section('content')
<div class="col-md-12">
  <div class="tile">
    <h3 class="tile-title">Data Jadwal Kuliah</h3>
    <div class="tile-body"> 
      <p class="bs-component">
        <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#modal-page" @@click="changeFormState(true, 'Tambah Data')">Tambah</button>
      </p>
      <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-striped dataTable">
                <thead>
                  <tr>
                    <th @@click="sort(1)" :class="tableSorting.colNo == 1 ? tableSorting.asc ? 'sorting_asc' : 'sorting_desc' : 'sorting'">Hari</th>  
                    <th @@click="sort(2)" :class="tableSorting.colNo == 2 ? tableSorting.asc ? 'sorting_asc' : 'sorting_desc' : 'sorting'">Waktu</th>  
                    <th @@click="sort(3)" :class="tableSorting.colNo == 3 ? tableSorting.asc ? 'sorting_asc' : 'sorting_desc' : 'sorting'">Ruangan</th>  
                    <th @@click="sort(4)" :class="tableSorting.colNo == 4 ? tableSorting.asc ? 'sorting_asc' : 'sorting_desc' : 'sorting'">Kode Mata Kuliah</th>  
                    <th @@click="sort(5)" :class="tableSorting.colNo == 5 ? tableSorting.asc ? 'sorting_asc' : 'sorting_desc' : 'sorting'">Nama Mata Kuliah</th>  
                    <th @@click="sort(6)" :class="tableSorting.colNo == 6 ? tableSorting.asc ? 'sorting_asc' : 'sorting_desc' : 'sorting'">Nama Kelas</th>  
                    <th @@click="sort(7)" :class="tableSorting.colNo == 7 ? tableSorting.asc ? 'sorting_asc' : 'sorting_desc' : 'sorting'">Semester</th>  
                    <th @@click="sort(8)" :class="tableSorting.colNo == 8 ? tableSorting.asc ? 'sorting_asc' : 'sorting_desc' : 'sorting'">Dosen</th>  
                    <th>Proses</th>
                  </tr>
                  <tr>
                    <th>
                      <input :disabled="isLoading" type="text" class="form-control form-control-sm" placeholder="Cari Hari" v-model.lazy="tableParam.search.hari" @@change="call">
                    </th>
                    <th>
                      <input :disabled="isLoading" type="text" class="form-control form-control-sm" placeholder="Cari Waktu" v-model.lazy="tableParam.search.waktu" @@change="call">
                    </th>
                    <th>
                      <input :disabled="isLoading" type="text" class="form-control form-control-sm" placeholder="Cari Ruangan" v-model.lazy="tableParam.search.ruangan" @@change="call">
                    </th>
                    <th>
                      <input :disabled="isLoading" type="text" class="form-control form-control-sm" placeholder="Cari Kode Mata Kuliah" v-model.lazy="tableParam.search.kodemk" @@change="call">
                    </th>
                    <th>
                      <input :disabled="isLoading" type="text" class="form-control form-control-sm" placeholder="Cari Nama Mata Kuliah" v-model.lazy="tableParam.search.namamk" @@change="call">
                    </th>
                    <th>
                      <input :disabled="isLoading" type="text" class="form-control form-control-sm" placeholder="Cari Nama Kelas" v-model.lazy="tableParam.search.kelas" @@change="call">
                    </th>
                    <th>
                      <input :disabled="isLoading" type="text" class="form-control form-control-sm" placeholder="Cari Semester" v-model.lazy="tableParam.search.semester" @@change="call">
                    </th>
                    <th>
                      <input :disabled="isLoading" type="text" class="form-control form-control-sm" placeholder="Cari Dosen" v-model.lazy="tableParam.search.dosen" @@change="call">
                    </th>
                  </tr>
                </thead>
                <tbody>
                   <tr v-for="item in tableData">
                    <td>@{{ item.hari }}</td>
                    <td>@{{ item.waktu }}</td>
                    <td>@{{ item.ruangan }}</td>
                    <td>@{{ item.kodemk }}</td>
                    <td>@{{ item.namamk }}</td>
                    <td>@{{ item.kelas }}</td>
                    <td>@{{ item.semester }}</td>
                    <td>@{{ item.dosen }}</td>
                    <td>
                      <button class="btn btn-info btn-sm" type="button" @@click="getData(item.id)">Ubah</button>
                      <button class="btn btn-danger btn-sm" type="button" @@click="hapusData(item.id)">Hapus</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
              <a>Menampilkan @{{tableInfo.from}} sampai @{{tableInfo.to}} dari @{{tableInfo.total}} data</a>
            </div>
            <div class="col-sm-12 col-md-4">
              <input :disabled="isLoading" type="number" class="form-control form-control-sm" placeholder="Jumlah Data Per Halaman" type="number" v-model.lazy="tableParam.perPage" min="1" @@change="call">
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
                  <ul class="pagination">
                      <div v-if="!tableNav.first">
                        <li class="paginate_button page-item previous disabled" id="sampleTable_previous"><a class="page-link"><span class="fa fa-angle-double-left"></span></a></li>
                      </div>
                      <div v-else>
                        <li @@click="firstPage" class="paginate_button page-item previous" id="sampleTable_previous"><a class="page-link"><span class="fa fa-angle-double-left"></span></a></li>
                      </div>

                      <div v-if="!tableNav.prev">
                        <li class="paginate_button page-item previous disabled" id="sampleTable_previous"><a class="page-link"><span class="fa fa-angle-left"></span></a></li>
                      </div>
                      <div v-else>
                        <li @@click="prevPage" class="paginate_button page-item previous" id="sampleTable_previous"><a class="page-link"><span class="fa fa-angle-left"></span></a></li>
                      </div>

                        <input :disabled="isLoading" type="number" class="form-control form-control-sm" min="1" @@change="call" :max="tableParam.maxPage" v-model.lazy="tableParam.page">
                        <input disabled type="text" class="form-control form-control-sm" v-model.lazy="tableInfo.maxPage">

                      <div v-if="!tableNav.next">
                        <li class="paginate_button page-item next disabled" id="sampleTable_next"><a class="page-link"><span class="fa fa-angle-right"></span></a></li>
                      </div>
                      <div v-else>
                        <li @@click="nextPage" class="paginate_button page-item next" id="sampleTable_next"><a class="page-link"><span class="fa fa-angle-right"></span></a></li>
                      </div>

                      <div v-if="!tableNav.last">
                        <li class="paginate_button page-item next disabled" id="sampleTable_next"><a class="page-link"><span class="fa fa-angle-double-right"></span></a></li>
                      </div>
                      <div v-else>
                        <li @@click="lastPage" class="paginate_button page-item next" id="sampleTable_next"><a class="page-link"><span class="fa fa-angle-double-right"></span></a></li>
                      </div>
                  </ul>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-page">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@{{formState}}</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">

          <div v-if="formDisplayDataErrors.length > 0">
            <div class="alert alert-danger alert-dismissible">
              <h5><i class="icon fa fa-ban"></i> Alert!</h5>
              <ul v-for="item in formDisplayDataErrors">
                <li>@{{item}}</li>
              </ul>
            </div>
          </div>

          <div class="form-group">
            <label :title="formDataErrors.id_dosen" :style="{ color: formDataErrors.id_dosen != '' ? 'red' : null }">Dosen</label>
            <v-select placeholder="Dosen" :disabled="isLoading" :title="formDataErrors.id_dosen" :options="vselectOptions.id_dosen" label="value" v-model.lazy="vselectValue.id_dosen" @@search="onDosenSearch"></v-select>
          </div>

          <div class="form-group">
            <label :title="formDataErrors.id_matkul" :style="{ color: formDataErrors.id_matkul != '' ? 'red' : null }">Mata Kuliah</label>
            <v-select placeholder="Mata Kuliah" :disabled="isLoading" :title="formDataErrors.id_matkul" :options="vselectOptions.id_matkul" label="value" v-model.lazy="vselectValue.id_matkul" @@search="onMatkulSearch"></v-select>
          </div>

          <div class="form-group">
            <label :title="formDataErrors.kelas" :style="{ color: formDataErrors.kelas != '' ? 'red' : null }">Kelas</label>
            <input :disabled="isLoading" :title="formDataErrors.kelas" :class="{ 'form-control': true, 'is-invalid': formDataErrors.kelas != '' }" @@keyup.enter="save" type="text" class="form-control" v-model.lazy="formData.kelas" placeholder="Kelas">
          </div>

          <div class="form-group">
            <label :title="formDataErrors.hari" :style="{ color: formDataErrors.hari != '' ? 'red' : null }">Hari</label>
            <input :disabled="isLoading" :title="formDataErrors.hari" :class="{ 'form-control': true, 'is-invalid': formDataErrors.hari != '' }" @@keyup.enter="save" type="text" class="form-control" v-model.lazy="formData.hari" placeholder="Hari">
          </div>

          <div class="form-group">
            <label :title="formDataErrors.waktu" :style="{ color: formDataErrors.waktu != '' ? 'red' : null }">Waktu</label>
            <input :disabled="isLoading" :title="formDataErrors.waktu" :class="{ 'form-control': true, 'is-invalid': formDataErrors.waktu != '' }" @@keyup.enter="save" type="text" class="form-control" v-model.lazy="formData.waktu" placeholder="Waktu">
          </div>

          <div class="form-group">
            <label :title="formDataErrors.ruangan" :style="{ color: formDataErrors.ruangan != '' ? 'red' : null }">Ruangan</label>
            <input :disabled="isLoading" :title="formDataErrors.ruangan" :class="{ 'form-control': true, 'is-invalid': formDataErrors.ruangan != '' }" @@keyup.enter="save" type="text" class="form-control" v-model.lazy="formData.ruangan" placeholder="Ruangan">
          </div>

          <div class="form-group">
            <label :title="formDataErrors.semester" :style="{ color: formDataErrors.semester != '' ? 'red' : null }">Semester</label>
            <input :disabled="isLoading" :title="formDataErrors.semester" :class="{ 'form-control': true, 'is-invalid': formDataErrors.semester != '' }" @@keyup.enter="save" type="text" class="form-control" v-model.lazy="formData.semester" placeholder="Semester">
          </div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="button" @@click="save">Save changes</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('jsbottom')
<script src="{{ADHhelper::mix('compiled/js/jadwal.js')}}"></script>
@endsection