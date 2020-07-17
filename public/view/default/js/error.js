openOrClosePreviewCode = function(self,selector){
	let selector_obj = document.querySelectorAll(".code-preview-parent" + selector);

	if(selector_obj[0] !== undefined && selector_obj[0].classList !== undefined){
		let parents = document.querySelectorAll('.code-preview-parent');
		if(parents[0] !== undefined && parents[0].classList !== undefined){
			for(let o=0;o<parents.length;o++){
				parents[o].classList.remove('view');
				parents[o].classList.add('hide');
			}
			selector_obj[0].classList.add('view');
			selector_obj[0].classList.remove('hide');

			if(self.classList !== undefined){
				let self_parents = document.querySelectorAll('.backtrace');
				if(self_parents[0] !== undefined && self_parents[0].classList !== undefined){
					for(let u=0;u<self_parents.length;u++){
						self_parents[u].classList.remove('active');
					}
					self.classList.add('active');
				}
			}
		}
	}
};