window.Vue = require('vue');
window.axios = require('axios');

import Swal from 'sweetalert2'

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(Loading);

import VueToastr from '@deveodk/vue-toastr'
import '@deveodk/vue-toastr/dist/@deveodk/vue-toastr.css'
Vue.use(VueToastr, {
    defaultPosition: 'toast-top-right',
});

window.vpage = new Vue({
    el: '#page',
    data: {
      tableSorting: {
        colNo: 1,
        asc: true,
      },
      tableData: [],
      tableParam: {
        search: {
          kode: '',
          matkul: '',
        },
        perPage: 5,
        maxPage: 1,
        page: 1,
      },
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
      formData: {
        id: '',
        kode: '',
        matkul: '',
      },
      formDataErrors: {
        id: '',
        kode: '',
        matkul: '',
      },
      formDisplayDataErrors: [],
      formState: '',
      formStateAdd: true,
      isLoading: false,
    },
    components: {
        Loading
    },
    methods: {
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

      axios.post(baseUrl + '/matkul/getTableData', {
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
        console.log(error);
      });
      },
      save: function() {
        vpage.startLoading();
        if (vpage.formStateAdd) {
          vpage.store();
        } else {
          vpage.update(vpage.formData.id);
        }
      },
      store: function() {
      axios.post(baseUrl + '/matkul', vpage.formData)
      .then(function (response) {
        vpage.stopLoading();
        vpage.resetForm();
        vpage.call();
        vpage.toast('success', 'Berhasil Tambah Data', 'Sukses !!!');
        $('#modal-page').modal('hide');
      })
      .catch(function (error) {
        vpage.stopLoading();
        if (error.response.data.errors) {
          vpage.formDisplayDataErrors = [];
          let formErrors = error.response.data.errors;

          vpage.formDataErrors.kode = formErrors.kode ? formErrors.kode[0] : '';
          vpage.formDataErrors.matkul = formErrors.matkul ? formErrors.matkul[0] : '';

          for (let key1 in formErrors) {
            for (let key2 in formErrors[key1]) {
              vpage.formDisplayDataErrors.push(formErrors[key1][key2]);
          }
        }
        } else {
          Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
          console.log(error);
        }
      });
      },
      getData: function(id) {
        vpage.startLoading();
      axios.get(baseUrl + '/matkul/' + id)
      .then(function (response) {
        vpage.changeFormState(false, 'Ubah Data');
        $("#modal-page").modal('show');
        vpage.stopLoading();
        vpage.formData.id = response.data.id;
        vpage.formData.kode = response.data.kode;
        vpage.formData.matkul = response.data.matkul;
      })
      .catch(function (error) {
        if (error.response.data.message) {
          Swal.fire('ERROR !!!', error.response.data.message, 'error');
        } else {
          Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
          console.log(error);
        }
      });
      },
      update: function(id) {
      axios.put(baseUrl + '/matkul/' + id, vpage.formData)
      .then(function (response) {
        vpage.stopLoading();
        vpage.resetForm();
        vpage.call();
        vpage.toast('success', 'Berhasil Ubah Data', 'Sukses !!!');
        $('#modal-page').modal('hide');
      })
      .catch(function (error) {
        vpage.stopLoading();
        if (error.response.data.errors) {
          vpage.formDisplayDataErrors = [];
          let formErrors = error.response.data.errors;

          vpage.formDataErrors.kode = formErrors.kode ? formErrors.kode[0] : '';
          vpage.formDataErrors.matkul = formErrors.matkul ? formErrors.matkul[0] : '';

          for (let key1 in formErrors) {
            for (let key2 in formErrors[key1]) {
              vpage.formDisplayDataErrors.push(formErrors[key1][key2]);
          }
        }
        } else {
          Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
          console.log(error);
        }
      });
      },
      delete: function(id) {
      vpage.startLoading();
      axios.delete(baseUrl + '/matkul/' + id)
      .then(function (response) {
        vpage.stopLoading();
        vpage.toast('success', 'Berhasil Hapus Data', 'Sukses !!!');
        vpage.call();
      })
      .catch(function (error) {
        if (error.response.data.message) {
          vpage.stopLoading();
          Swal.fire('ERROR !!!', error.response.data.message, 'error');
        } else {
          vpage.stopLoading();
          Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
          console.log(error);
      }
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
      resetForm: function() {
        vpage.formDisplayDataErrors = [];
      vpage.formData = {
        id: '',
        kode: '',
        matkul: '',
      };
      vpage.formDataErrors = {
        id: '',
        kode: '',
        matkul: '',
      };
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
    });
  },
});