@extends('template.palih')

@section('title')
<h1><i class="fa fa-th-list"></i> Dosen</h1>
@endsection

@section('nav')
<li class="breadcrumb-item"><a href="{{route('dosen.index')}}">Dosen</a></li>
@endsection

@section('content')
<div class="col-md-12">
  <div class="tile">
    <h3 class="tile-title">Data Dosen</h3>
    <div class="tile-body"> 
      <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            <div class="col-sm-12 col-md-6">
              <input :disabled="isLoading" type="number" class="form-control form-control-sm" placeholder="Jumlah Data Per Halaman" type="number" v-model="tableParam.perPage" min="1" @@change="recall">
            </div>
            <div class="col-sm-12 col-md-6">
              <input :disabled="isLoading" type="text" class="form-control form-control-sm" placeholder="Cari" v-model="tableParam.search" @@change="recall">
            </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-striped dataTable">
                <thead>
                  <tr>
                    <th @@click="sort(1)" :class="tableSorting.colNo == 1 ? tableSorting.asc ? 'sorting_asc' : 'sorting_desc' : 'sorting'">NIDN</th>  
                    <th @@click="sort(2)" :class="tableSorting.colNo == 2 ? tableSorting.asc ? 'sorting_asc' : 'sorting_desc' : 'sorting'">Nama</th>  
                    <th>Proses</th>
                  </tr>
                </thead>
                <tbody>
                   <tr v-for="item in tableData">
                    <td>@{{ item.nidn }}</td>
                    <td>@{{ item.nama }}</td>
                    <td>
                      <button class="btn btn-primary" type="button" @@click="getData(item.id)">Ubah</button>
                      <button class="btn btn-danger" type="button" @@click="hapusData(item.id)">Hapus</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
              <a>Menampilkan @{{tableInfo.from}} sampai @{{tableInfo.to}} dari @{{tableInfo.total}} data</a>
            </div>
            <div class="col-sm-12 col-md-6">
              <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
                  <ul class="pagination">
                      <div v-if="!tableNav.first">
                        <li class="paginate_button page-item previous disabled" id="sampleTable_previous"><a href="#" class="page-link"><span class="fa fa-angle-double-left"></span></a></li>
                      </div>
                      <div v-else>
                        <li @@click="firstPage" class="paginate_button page-item previous" id="sampleTable_previous"><a href="#" class="page-link"><span class="fa fa-angle-double-left"></span></a></li>
                      </div>

                      <div v-if="!tableNav.prev">
                        <li class="paginate_button page-item previous disabled" id="sampleTable_previous"><a href="#" class="page-link"><span class="fa fa-angle-left"></span></a></li>
                      </div>
                      <div v-else>
                        <li @@click="prevPage" class="paginate_button page-item previous" id="sampleTable_previous"><a href="#" class="page-link"><span class="fa fa-angle-left"></span></a></li>
                      </div>

                        <input :disabled="isLoading" type="number" class="form-control form-control-sm" min="1" @@change="recall" :max="tableParam.maxPage" v-model="tableParam.page">
                        <input disabled type="text" class="form-control form-control-sm" v-model="tableInfo.maxPage">

                      <div v-if="!tableNav.next">
                        <li class="paginate_button page-item next disabled" id="sampleTable_next"><a href="#" class="page-link"><span class="fa fa-angle-right"></span></a></li>
                      </div>
                      <div v-else>
                        <li @@click="nextPage" class="paginate_button page-item next" id="sampleTable_next"><a href="#" class="page-link"><span class="fa fa-angle-right"></span></a></li>
                      </div>

                      <div v-if="!tableNav.last">
                        <li class="paginate_button page-item next disabled" id="sampleTable_next"><a href="#" class="page-link"><span class="fa fa-angle-double-right"></span></a></li>
                      </div>
                      <div v-else>
                        <li @@click="lastPage" class="paginate_button page-item next" id="sampleTable_next"><a href="#" class="page-link"><span class="fa fa-angle-double-right"></span></a></li>
                      </div>
                  </ul>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal-page">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@{{formState}}</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="button">Save changes</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('jsbottom')
<script src="{{ADHhelper::mix('compiled/js/dosen.js')}}"></script>
@endsection