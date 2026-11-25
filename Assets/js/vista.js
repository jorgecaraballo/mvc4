'use strict';
class Vista {
	constructor() {
		//this.divLoading = document.getElementById('divLoading');
		}
	bindEstilo(elemento) {
		elemento.style.backgroundColor = '#2f4050';
		elemento.style.color = 'white';
		elemento.addEventListener('focus', function() {
			this.style.backgroundColor = '#333';
			this.style.color = 'lightblue';
			});
		elemento.addEventListener('blur', function() {
			this.style.backgroundColor = '#2f4050';
			});
		}
	}
