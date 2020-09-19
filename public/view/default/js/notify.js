window.notifyObj = {
	stringToColor: function(str){
/*		let rgb = "rgb(";
		rgb += rand(0,255);
		rgb += ',';
		rgb += rand(0,255);
		rgb += ',';
		rgb += rand(0,255);
		rgb += ')';
		return rgb;*/

		let hash = 0;
		let color = '#';
		let i;
		let value;
		let strLength;

		if(!str){
			return color + '333333';
		}

		strLength = str.length;

		for(i = 0; i < strLength; i++){
			hash = str.charCodeAt(i)+((hash << 5)-hash);
		}

		for(i = 0; i < 3; i++){
			value = (hash >> (i * 8))&0xFF;
			color += ('00' + value.toString(16)).substr(-2);
		}

		return color;
	},
	setAvatar: function(k,v){
		let name = $('.user-info-name',this).text();
		name = str_ireplace(["\t","\n","\r"],'',name);

		let avatar = $('.user-info-avatar',this);
		let letter = name.substring(0,1);
		let backgroundColor = notifyObj.stringToColor(name);

		avatar.html(letter);
		avatar.css('background-color',backgroundColor);
	},
};

$(document).ready(function(){
	$.each($('.item-text-photo .user-info'),notifyObj.setAvatar);
});

