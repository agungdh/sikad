window.Vue = require('vue');
window.axios = require('axios');

import Tooltip from 'vue-directive-tooltip';
import 'vue-directive-tooltip/dist/vueDirectiveTooltip.css';

Vue.use(Tooltip);

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
        text1: '',
        text2: '',
        text3: '',
      },
      formDataErrors: {
        id: '',
        text1: '',
        text2: '',
        text3: '',
      },
      formDisplayDataErrors: [],
      formState: '',
      formStateAdd: true,
    },
    methods: {
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
			axios.post(baseUrl + '/test/getTableData', {
		    perPage: vpage.tableParam.perPage,
		    search: vpage.tableParam.search,
		    sorting: {
			    colNo: vpage.tableSorting.colNo,
			    asc: vpage.tableSorting.asc,
		    },
		    page: vpage.tableParam.page,
		  })
		  .then(function (response) {
		    vpage.tableData = response.data.data;
		    vpage.tableParam.maxPage = response.data.last_page;
		    vpage.tableInfo.from = response.data.from;
		    vpage.tableInfo.to = response.data.to;
		    vpage.tableInfo.total = response.data.total;

		    vpage.setTableNav();
		  })
		  .catch(function (error) {
		  	swal('Whoops!!!', 'Something bad happend...', 'error');
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
			axios.post(baseUrl + '/test', vpage.formData)
		  .then(function (response) {
		  	vpage.resetForm();
		  	vpage.call();
		  	swal('SUKSES !!!', 'Berhasil Simpan Data !!!', 'success');
		  	$('#modal-default').modal('hide');
		  })
		  .catch(function (error) {
		  	if (error.response.data.errors) {
		  		vpage.formDisplayDataErrors = [];
		  		let formErrors = error.response.data.errors;

		  		vpage.formDataErrors.text1 = formErrors.text1 ? formErrors.text1[0] : '';
		  		vpage.formDataErrors.text2 = formErrors.text2 ? formErrors.text2[0] : '';
		  		vpage.formDataErrors.text3 = formErrors.text3 ? formErrors.text3[0] : '';

		  		for (let key1 in formErrors) {
				    for (let key2 in formErrors[key1]) {
					    vpage.formDisplayDataErrors.push(formErrors[key1][key2]);
					}
				}
		  	} else {
			  	swal('Whoops!!!', 'Something bad happend...', 'error');
			    console.log(error);
		  	}
		  });
    	},
    	getData: function(id) {
			axios.get(baseUrl + '/test/' + id)
		  .then(function (response) {
		  	vpage.changeFormState(false, 'Ubah Data');
		  	$("#modal-default").modal('show');

		  	vpage.formData.id = response.data.id;
		  	vpage.formData.text1 = response.data.text1;
		  	vpage.formData.text2 = response.data.text2;
		  	vpage.formData.text3 = response.data.text3;
		  })
		  .catch(function (error) {
		  	if (error.response.data.message) {
		  		swal('ERROR !!!', error.response.data.message, 'error');
		  	} else {
			  	swal('Whoops!!!', 'Something bad happend...', 'error');
			    console.log(error);
		  	}
		  });
    	},
    	update: function(id) {
			axios.put(baseUrl + '/test/' + id, vpage.formData)
		  .then(function (response) {
		  	vpage.resetForm();
		  	vpage.call();
		  	swal('SUKSES !!!', 'Berhasil Ubah Data !!!', 'success');
		  	$('#modal-default').modal('hide');
		  })
		  .catch(function (error) {
		  	if (error.response.data.errors) {
		  		vpage.formDisplayDataErrors = [];
		  		let formErrors = error.response.data.errors;

		  		vpage.formDataErrors.text1 = formErrors.text1 ? formErrors.text1[0] : '';
		  		vpage.formDataErrors.text2 = formErrors.text2 ? formErrors.text2[0] : '';
		  		vpage.formDataErrors.text3 = formErrors.text3 ? formErrors.text3[0] : '';

		  		for (let key1 in formErrors) {
				    for (let key2 in formErrors[key1]) {
					    vpage.formDisplayDataErrors.push(formErrors[key1][key2]);
					}
				}
		  	} else {
			  	swal('Whoops!!!', 'Something bad happend...', 'error');
			    console.log(error);
		  	}
		  });
    	},
    	delete: function(id) {
			axios.delete(baseUrl + '/test/' + id)
		  .then(function (response) {
		  	setTimeout(function(){
	  			swal('SUKSES !!!', 'Berhasil Simpan Data !!!', 'success');
	  		}, 100);
		  	vpage.call();
		  })
		  .catch(function (error) {
		  	if (error.response.data.message) {
		  		setTimeout(function(){
		  			swal('ERROR !!!', error.response.data.message, 'error');
		  		}, 100);
		  	} else {
			  	swal('Whoops!!!', 'Something bad happend...', 'error');
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
				text1: '',
				text2: '',
				text3: '',
			};
			vpage.formDataErrors = {
				id: '',
				text1: '',
				text2: '',
				text3: '',
			};
    	},
    	hapusData: function(id) {
    		swal({
		      title: "Yakin Hapus ???",
		      text: "Data yang sudah dihapus tidak dapat dikembalikan lagi !!!",
		      type: "warning",
		      showCancelButton: true,
		      confirmButtonColor: "#DD6B55",
		      confirmButtonText: "Hapus",
		    }, function(){
		      vpage.delete(id);
		    });
    	}
    },
    mounted: function () {
		this.$nextTick(function () {
		 vpage.call();
		});
	},
});