
(function(){
'use strict';

var section = document.getElementsByClassName('section');

var title = document.getElementsByClassName('title');
var box = document.getElementsByClassName('box');
var i;

for(i = 0; i < section.length; i++){
	section[i].addEventListener('click', function(e){
		e.preventDefault();
		
		for(i = 0; i < box.length; i++){
			box[i].className = 'box';
		}
  		
  		document.getElementById(this.dataset.id).className = 'box activeBox';
				

	});
}


var text = document.getElementsByClassName('text');
var j;

for( j = 0; j < title.length; j++){
	title[j].addEventListener('click', function (e){
		e.preventDefault();
		
		for(i = 0; i < text.length; i++){
			text[i].className = 'text';
		}
		
		if(document.getElementById(this.dataset.id).className == 'text'){
			document.getElementById(this.dataset.id).className = 'active';
		}else{
			document.getElementById(this.dataset.id).className = 'text';
		}
	});
}


var edit = document.getElementsByClassName('edit');
var k;
for(k = 0; k < edit.length; k++){
	edit[k].addEventListener('click', function(e){
		e.preventDefault();
			
			document.getElementById(this.dataset.id).className = 'hiddenform';
			document.getElementById(this.dataset.form).className = 'seeform';
			document.getElementById(this.dataset.editdust).className = 'fa fa-times editDust';
		

var editDust = document.getElementsByClassName('editDust');
var l;
for(l = 0; l < editDust.length; l++){
	editDust[l].addEventListener('click', function(e){
		e.preventDefault();
			document.getElementById(this.dataset.id).className = 'seeform';
			document.getElementById(this.dataset.form).className = 'hiddenform';
	this.className = 'editDustHide';			



	});
}

	});
}


		






})();
