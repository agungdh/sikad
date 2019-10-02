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
      	search: '',
      	perPage: 5,
      	maxPage: 1,
      	page: 1,
      },
      tableParamPrev: {
      	search: null,
      	perPage: null,
      	maxPage: null,
      	page: null,
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
        nidn: '',
        nama: '',
      },
      formDataErrors: {
        id: '',
        nidn: '',
        nama: '',
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
    	recall: function() {
    		let recall = false;

    		if (vpage.tableParam.search != vpage.tableParamPrev.search) {
    			vpage.tableParamPrev.search = vpage.tableParam.search;

    			recall = true;
    		}

    		if (vpage.tableParam.perPage != vpage.tableParamPrev.perPage) {
    			vpage.tableParamPrev.perPage = vpage.tableParam.perPage;

    			recall = true;
    		}

    		if (vpage.tableParam.page != vpage.tableParamPrev.page) {
    			vpage.tableParamPrev.page = vpage.tableParam.page;

    			recall = true;
    		}

    		if (recall) {
				vpage.call();
    		}
    	},
    	call: function() {
        vpage.startLoading();

			axios.post(baseUrl + '/dosen/getTableData', {
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

		    vpage.setTableNav();
		  })
		  .catch(function (error) {
        vpage.stopLoading();

		  	Swal.fire('Whoops!!!', 'Something bad happend...', 'error');
		    console.log(error);
		  });
    	},
    	save: function() {
    		if (vpage.formStateAdd) {
    			vpage.store();
    		} else {
    			vpage.update(vpage.formData.id);
    		}
    	},
    	store: function() {
			axios.post(baseUrl + '/dosen', vpage.formData)
		  .then(function (response) {
		  	vpage.resetForm();
		  	vpage.call();
		  	vpage.toast('success', 'Berhasil Tambah Data', 'Sukses !!!');
		  	$('#modal-default').modal('hide');
		  })
		  .catch(function (error) {
		  	if (error.response.data.errors) {
		  		vpage.formDisplayDataErrors = [];
		  		let formErrors = error.response.data.errors;

		  		vpage.formDataErrors.nidn = formErrors.nidn ? formErrors.nidn[0] : '';
		  		vpage.formDataErrors.nama = formErrors.nama ? formErrors.nama[0] : '';

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
			axios.get(baseUrl + '/dosen/' + id)
		  .then(function (response) {
		  	vpage.changeFormState(false, 'Ubah Data');
		  	$("#modal-default").modal('show');

		  	vpage.formData.id = response.data.id;
		  	vpage.formData.nidn = response.data.nidn;
		  	vpage.formData.nama = response.data.nama;
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
			axios.put(baseUrl + '/dosen/' + id, vpage.formData)
		  .then(function (response) {
		  	vpage.resetForm();
		  	vpage.call();
		  	vpage.toast('success', 'Berhasil Ubah Data', 'Sukses !!!');
		  	$('#modal-default').modal('hide');
		  })
		  .catch(function (error) {
		  	if (error.response.data.errors) {
		  		vpage.formDisplayDataErrors = [];
		  		let formErrors = error.response.data.errors;

		  		vpage.formDataErrors.nidn = formErrors.nidn ? formErrors.nidn[0] : '';
		  		vpage.formDataErrors.nama = formErrors.nama ? formErrors.nama[0] : '';

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
			axios.delete(baseUrl + '/dosen/' + id)
		  .then(function (response) {
		  	setTimeout(function(){
	  			vpage.toast('success', 'Berhasil Hapus Data', 'Sukses !!!');
	  		}, 100);
		  	vpage.call();
		  })
		  .catch(function (error) {
		  	if (error.response.data.message) {
		  		setTimeout(function(){
		  			Swal.fire('ERROR !!!', error.response.data.message, 'error');
		  		}, 100);
		  	} else {
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
    	},
    	resetForm: function() {
    		vpage.formDisplayDataErrors = [];
			vpage.formData = {
				id: '',
				nidn: '',
				nama: '',
			};
			vpage.formDataErrors = {
				id: '',
				nidn: '',
				nama: '',
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
    	}
    },
    mounted: function () {
		this.$nextTick(function () {
		 vpage.call();

     vpage.tableInfo.maxPage = `of ${vpage.tableParam.maxPage}`;
		});
	},
});