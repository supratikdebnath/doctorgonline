function maxLength (e) {	
	if (!document.createElement('textarea').maxLength) {
		var max = e.attributes.maxLength.value;
		e.onkeypress = function () {
			if(this.value.length >= max) return false;
		};
	}
}

