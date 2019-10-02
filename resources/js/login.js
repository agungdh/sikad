window.Vue = require('vue');

const app = new Vue({
    el: '#app',
    data: {
    	username: '',
    	password: '',
    },
  	methods: {
		login: function (event) {
			swal('asf');
			// alert('asdfasdf');
	    }
  }
});
