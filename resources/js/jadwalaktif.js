import Vue from 'vue';
import axios from 'axios';
import _ from 'lodash';

import Swal from 'sweetalert2'

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(Loading);

import VueToastr from '@deveodk/vue-toastr'
import '@deveodk/vue-toastr/dist/@deveodk/vue-toastr.css'
Vue.use(VueToastr, {
    defaultPosition: 'toast-top-right',
});

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect)

window.vpage = new Vue({
    el: '#page',
    data: {
      tableSorting: {
        colNo: 1,
        asc: true,
      },
      tableData: [],
      tableInfo: {
        maxPage: null,
        from: 0,
        to: 0,
        total: 0,
      },
      tableNav: {
        first: false,
        prev: false,
        next: true,
        last: true,
      },
      formDisplayDataErrors: [],
      formState: '',
      formStateAdd: true,
      isLoading: false,
      tableParam: {
        search: {
          // START EDIT ================================================
          // EDIT HERE
          nidn: '',
          nama: '',
          kodemk: '',
          namamk: '',
          npm: '',
          namamhs: '',
          // END EDIT HERE
        },
        perPage: 5,
        maxPage: 1,
        page: 1,
      },

      formData: {
        // EDIT HERE
        id: '',
        id_jadwal: '',
        id_mahasiswa: '',
        // END EDIT HERE
      },
      formDataErrors: {
        // EDIT HERE
        id: '',
        id_jadwal: '',
        id_mahasiswa: '',
        // END EDIT HERE
      },
      vselectOptions: {
        // EDIT HERE
        id_jadwal: [],
        id_mahasiswa: [],
        // END EDIT HERE
      },
      vselectValue: {
        // EDIT HERE
        id_jadwal: null,
        id_mahasiswa: null,
        // END EDIT HERE
      },

    },
    components: {
        Loading
    },
    methods: {
      resetForm: function() {
        vpage.formDisplayDataErrors = [];
      vpage.formData = {
        // EDIT HERE
        id: '',
        id_jadwal: '',
        id_mahasiswa: '',
      };
      vpage.formDataErrors = {
        // EDIT HERE
        id: '',
        id_jadwal: '',
        id_mahasiswa: '',
        // END EDIT HERE
      };
      // EDIT HERE
      vpage.vselectValue.id_jadwal = null;
      vpage.vselectValue.id_mahasiswa = null;
      // END EDIT HERE
      },
      initVselectOptions: function() {
        // EDIT HERE
        vpage.initJadwalSearch();
        vpage.initMahasiswaSearch();
        // END EDIT HERE
      },
      // EDIT HERE
      initJadwalSearch: function(search = '') {
        axios.post(baseUrl + '/jadwalaktif/getJadwal', {search: search})
        .then(function (response) {
          for (let key in response.data) {
            vpage.vselectOptions.id_jadwal.push({
              key: response.data[key].id,
              value: `${response.data[key].nidn} | ${response.data[key].nama} => ${response.data[key].kodemk} | ${response.data[key].namamk} => ${response.data[key].kelas} | ${response.data[key].hari} | ${response.data[key].waktu} | ${response.data[key].ruangan} | ${response.data[key].semester}`,
            });
          }
        })
        .catch(function (error) {
          Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
        });
      },
      onJadwalSearch(search, loading) {
        loading(true);
        this.jadwalSearch(loading, search, this);
      },
      jadwalSearch: _.debounce((loading, search, vm) => {
        vpage.vselectOptions.id_jadwal = [];
          axios.post(baseUrl + '/jadwalaktif/getJadwal', {search: search})
        .then(function (response) {
          for (let key in response.data) {
            vpage.vselectOptions.id_jadwal.push({
              key: response.data[key].id,
              value: `${response.data[key].nidn} | ${response.data[key].nama} => ${response.data[key].kodemk} | ${response.data[key].namamk} => ${response.data[key].kelas} | ${response.data[key].hari} | ${response.data[key].waktu} | ${response.data[key].ruangan} | ${response.data[key].semester}`,
            });
          }
          loading(false);
        })
        .catch(function (error) {
          loading(false);
          Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
        });
      }, 100),
      initMahasiswaSearch: function(search = '') {
        axios.post(baseUrl + '/jadwalaktif/getMahasiswa', {search: search})
        .then(function (response) {
          for (let key in response.data) {
            vpage.vselectOptions.id_mahasiswa.push({
              key: response.data[key].id,
              value: `${response.data[key].npm} => ${response.data[key].nama}`,
            });
          }
        })
        .catch(function (error) {
          Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
        });
      },
      onMahasiswaSearch(search, loading) {
        loading(true);
        this.mahasiswaSearch(loading, search, this);
      },
      mahasiswaSearch: _.debounce((loading, search, vm) => {
        vpage.vselectOptions.id_mahasiswa = [];
        axios.post(baseUrl + '/jadwalaktif/getMahasiswa', {search: search})
      .then(function (response) {
        for (let key in response.data) {
          vpage.vselectOptions.id_mahasiswa.push({
            key: response.data[key].id,
            value: `${response.data[key].npm} => ${response.data[key].nama}`,
          });
        }
        loading(false);
      })
      .catch(function (error) {
        loading(false);
        Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
      });
      }, 100),
      // END EDIT HERE
      store: function() {
      axios.post(baseUrl + '/jadwalaktif', vpage.formData)
      .then(function (response) {
        vpage.stopLoading();
        vpage.resetForm();
        vpage.call();
        vpage.toast('success', 'Berhasil Tambah Data', 'Sukses !!!');
        $('#modal-page').modal('hide');
      })
      .catch(function (error) {
        vpage.call();
        if (error.response.data.errors) {
          vpage.formDisplayDataErrors = [];
          let formErrors = error.response.data.errors;

          // EDIT HERE
          vpage.formDataErrors.id_jadwal = formErrors.id_jadwal ? formErrors.id_jadwal[0] : '';
          vpage.formDataErrors.id_mahasiswa = formErrors.id_mahasiswa ? formErrors.id_mahasiswa[0] : '';
          vpage.formDataErrors.kelas = formErrors.kelas ? formErrors.kelas[0] : '';
          vpage.formDataErrors.hari = formErrors.hari ? formErrors.hari[0] : '';
          vpage.formDataErrors.waktu = formErrors.waktu ? formErrors.waktu[0] : '';
          vpage.formDataErrors.ruangan = formErrors.ruangan ? formErrors.ruangan[0] : '';
          vpage.formDataErrors.semester = formErrors.semester ? formErrors.semester[0] : '';
          // END EDIT HERE

          for (let key1 in formErrors) {
            for (let key2 in formErrors[key1]) {
              vpage.formDisplayDataErrors.push(formErrors[key1][key2]);
          }
        }
        } else {
          Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
        }
      });
      },
      getData: function(id) {
        vpage.startLoading();
      axios.get(baseUrl + '/jadwalaktif/' + id)
      .then(function (response) {
        vpage.changeFormState(false, 'Ubah Data');
        $("#modal-page").modal('show');
        vpage.stopLoading();
        // EDIT HERE
        vpage.formData.id = response.data.id;
        vpage.formData.kelas = response.data.kelas;
        vpage.formData.hari = response.data.hari;
        vpage.formData.waktu = response.data.waktu;
        vpage.formData.ruangan = response.data.ruangan;
        vpage.formData.semester = response.data.semester;

        vpage.vselectValue.id_jadwal = {key: response.data.dosen.id, value:`${response.data.dosen.nidn} => ${response.data.dosen.nama}`};
        vpage.vselectValue.id_mahasiswa = {key: response.data.matkul.id, value:`${response.data.matkul.kode} => ${response.data.matkul.matkul}`};
        
        // END EDIT HERE
      })
      .catch(function (error) {
        vpage.call();
        Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
      });
      },
      update: function(id) {
      axios.put(baseUrl + '/jadwalaktif/' + id, vpage.formData)
      .then(function (response) {
        vpage.stopLoading();
        vpage.resetForm();
        vpage.call();
        vpage.toast('success', 'Berhasil Ubah Data', 'Sukses !!!');
        $('#modal-page').modal('hide');
      })
      .catch(function (error) {
        vpage.call();
        if (error.response.data.errors) {
          vpage.formDisplayDataErrors = [];
          let formErrors = error.response.data.errors;
          
          // EDIT HERE
          vpage.formDataErrors.id_jadwal = formErrors.id_jadwal ? formErrors.id_jadwal[0] : '';
          vpage.formDataErrors.id_mahasiswa = formErrors.id_mahasiswa ? formErrors.id_mahasiswa[0] : '';
          vpage.formDataErrors.kelas = formErrors.kelas ? formErrors.kelas[0] : '';
          vpage.formDataErrors.hari = formErrors.hari ? formErrors.hari[0] : '';
          vpage.formDataErrors.waktu = formErrors.waktu ? formErrors.waktu[0] : '';
          vpage.formDataErrors.ruangan = formErrors.ruangan ? formErrors.ruangan[0] : '';
          vpage.formDataErrors.semester = formErrors.semester ? formErrors.semester[0] : '';
          // END EDIT HERE
          for (let key1 in formErrors) {
            for (let key2 in formErrors[key1]) {
              vpage.formDisplayDataErrors.push(formErrors[key1][key2]);
          }
        }
        } else {
          Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
        }
      });
      },
      toast: function(p1, p2, p3) {
        this.$toastr(p1, p2, p3);
      },
      startLoading: function() {
        vpage.isLoading = true;
      },
      stopLoading: function() {
        vpage.isLoading = false;
      },
      call: function() {
        vpage.startLoading();

      axios.post(baseUrl + '/jadwalaktif/getTableData', {
        perPage: vpage.tableParam.perPage,
        search: vpage.tableParam.search,
        sorting: {
          colNo: vpage.tableSorting.colNo,
          asc: vpage.tableSorting.asc,
        },
        page: vpage.tableParam.page,
      })
      .then(function (response) {
        vpage.stopLoading();

        vpage.tableData = response.data.data;
        vpage.tableParam.maxPage = response.data.last_page;
        vpage.tableInfo.from = response.data.from;
        vpage.tableInfo.to = response.data.to;
        vpage.tableInfo.total = response.data.total;
        vpage.tableParam.page = response.data.current_page;
        vpage.tableParam.perPage = response.data.per_page;

        vpage.setTableNav();

        vpage.setMaxPageInfo();
      })
      .catch(function (error) {
        vpage.stopLoading();
        Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
      });
      },
      save: function() {
        vpage.startLoading();

        // EDIT HERE
        vpage.formData.id_jadwal = vpage.vselectValue.id_jadwal != null ? vpage.vselectValue.id_jadwal.key : '';
        vpage.formData.id_mahasiswa = vpage.vselectValue.id_mahasiswa != null ? vpage.vselectValue.id_mahasiswa.key : '';
        // END EDIT HERE
        // END EDIT ================================================

        if (vpage.formStateAdd) {
          vpage.store();
        } else {
          vpage.update(vpage.formData.id);
        }
      },
      delete: function(id) {
      vpage.startLoading();
      axios.delete(baseUrl + '/jadwalaktif/' + id)
      .then(function (response) {
        vpage.stopLoading();
        vpage.toast('success', 'Berhasil Hapus Data', 'Sukses !!!');
        vpage.call();
      })
      .catch(function (error) {
        vpage.call();
          Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
      });
      },
      sort: function(colNo) {
         if (vpage.tableSorting.colNo == colNo) {
          vpage.tableSorting.asc = !vpage.tableSorting.asc;
         } else {
          vpage.tableSorting.colNo = colNo;
          vpage.tableSorting.asc = true;
         }

      vpage.call();
      },
      firstPage: function() {
        vpage.tableParam.page = 1;

        vpage.call();
      },
      nextPage: function() {
        vpage.tableParam.page++;

        vpage.call();
      },
      prevPage: function() {
        vpage.tableParam.page--;

        vpage.call();
      },
      lastPage: function() {
        vpage.tableParam.page = vpage.tableParam.maxPage;

        vpage.call();
      },
      setTableNav: function() {
        if (vpage.tableParam.page > vpage.tableParam.maxPage) {
          vpage.tableParam.page = vpage.tableParam.maxPage;

          vpage.call();
        }

        if (vpage.tableParam.maxPage == 1) {
          vpage.tableNav.first = false;
          vpage.tableNav.prev = false;
          vpage.tableNav.next = false;
          vpage.tableNav.last = false;
        } else if (vpage.tableParam.page >= vpage.tableParam.maxPage) {
          vpage.tableNav.first = true;
          vpage.tableNav.prev = true;
          vpage.tableNav.next = false;
          vpage.tableNav.last = false;          
        } else if (vpage.tableParam.page <= 1) {
          vpage.tableNav.first = false;
          vpage.tableNav.prev = false;
          vpage.tableNav.next = true;
          vpage.tableNav.last = true;
        } else {
        vpage.tableNav.first = true;
        vpage.tableNav.prev = true;
        vpage.tableNav.next = true;
        vpage.tableNav.last = true;
        }
      },
      changeFormState: function(add, text) {
        vpage.formStateAdd = add;
        vpage.formState = text;
        vpage.resetForm();
      },
      hapusData: function(id) {
        Swal.fire({
          title: "Yakin Hapus ???",
          text: "Data yang sudah dihapus tidak dapat dikembalikan lagi !!!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Hapus",
        }).then((result) => {
          if (result.value) {
            vpage.delete(id);
          }
        });
      },
      setMaxPageInfo: function() {
        vpage.tableInfo.maxPage = `of ${vpage.tableParam.maxPage}`;
      }
    },
    mounted: function () {
    this.$nextTick(function () {
     vpage.call();

     vpage.setMaxPageInfo();
     
     vpage.initVselectOptions();
    });
  },
});