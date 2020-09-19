window.homeObj = {
	setTimeoutFormatDateTime : function(times=60){
		homeObj.formatDateTime();
		let date = new Date();
		let time = (times-date.getSeconds()) * 1000;
		setTimeout(homeObj.setTimeoutFormatDateTime,time);
	},
	formatDateTime : function(){
		let selector = $('.date-block');
		let lang_pack = indexObj.getLanguagePack();

		if(!lang_pack){ return false; }

		$.each(selector,function(k,v){
			let timestamp = parseInt($('.invisible-timestamp',this).html());
			let time_result;
			if(isNaN(timestamp)){
				time_result = lang_pack.date.long_ago;
			}else{
				time_result =  homeObj.prepareDate(timestamp,lang_pack.date);
			}
			$('.visible-formatted-date',this).html(time_result);
		});
	},
	prepareDate : function(server_time,lang_pack){
		server_time = server_time*1000;
		let server_date = new Date();
		server_date.setTime(server_time);
		let server_obj = {
			year: server_date.getFullYear(),
			mon: server_date.getMonth(),
			day: server_date.getDate(),
			hour: server_date.getHours(),
			min: server_date.getMinutes(),
			sec: server_date.getSeconds(),
		};
		let client_date = new Date();
		let client_obj = {
			year: client_date.getFullYear(),
			mon: client_date.getMonth(),
			day: client_date.getDate(),
			hour: client_date.getHours(),
			min: client_date.getMinutes(),
			sec: client_date.getSeconds(),
		};
		if(client_obj.year === server_obj.year){
			if(client_obj.mon === server_obj.mon){
				if(client_obj.day === server_obj.day){
					if(client_obj.hour === server_obj.hour){
						if(client_obj.min === server_obj.min){
							if(client_obj.sec === server_obj.sec){
								return lang_pack.now;
							}
						}
						return homeObj.prepareTime(server_date,client_date,lang_pack);
					}
					return lang_pack.tod + ', ' +
						lang_pack.in + ' ' +
						server_obj.hour + ':' +
						('0' + server_obj.min).slice(-2)
					+ ':' + ('0' + server_obj.sec).slice(-2);
				}
				if(server_obj.day === client_obj.day+1){
					return lang_pack.tom + ', ' +
						lang_pack.in + ' ' +
						server_obj.hour + ':' +
						('0' + server_obj.min).slice(-2)
					+ ':' + ('0' + server_obj.sec).slice(-2);
				}
				if(server_obj.day === client_obj.day-1){
					return lang_pack.yes + ', ' +
						lang_pack.in + ' ' +
						server_obj.hour + ':' +
						('0' + server_obj.min).slice(-2)
					+ ':' + ('0' + server_obj.sec).slice(-2);
				}
			}
			return server_obj.day + ' ' +
				lang_pack.months[server_obj.mon] + ', ' +
				lang_pack.in + ' ' +
				server_obj.hour + ':' +
				('0' + server_obj.min).slice(-2)
			+ ':' + ('0' + server_obj.sec).slice(-2);
		}
		return server_obj.day + ' ' +
			lang_pack.months[server_obj.mon] + ' ' +
			server_obj.year + '' +
			lang_pack.year + ', ' +
			lang_pack.in + ' ' +
			server_obj.hour + ':' +
			('0' + server_obj.min).slice(-2)
		+ ':' + ('0' + server_obj.sec).slice(-2);
	},
	prepareTime : function(server_date,client_date,lang_pack){
		server_date = parseInt(server_date/1000);
		client_date = parseInt(client_date/1000);
		let lang,minus_time,format;
		if(server_date > client_date){
			format = true;
			minus_time = server_date-client_date;
		}else{
			format = false;
			minus_time = client_date-server_date;
		}
		lang = lang_pack.secs;
		if(minus_time >= 60 && minus_time < 3600){
			lang = lang_pack.mins;
			minus_time = parseInt(minus_time/60);
		}
		let prepared_time = homeObj.prepareEnd(minus_time,lang);
		return !format ? minus_time + ' ' + prepared_time + ' ' + lang_pack.down :
			lang_pack.up + ' ' + minus_time + ' ' + prepared_time;
	},
	prepareEnd : function(number,lang){
		let ending,i;
		number = number % 100;
		if(number>=11 && number<=19){
			ending=lang[2];
		}else{
			i = number % 10;
			switch (i) {
				case (1): ending = lang[0]; break;
				case (2):
				case (3):
				case (4): ending = lang[1]; break;
				default: ending=lang[2];
			}
		}
		return ending;
	},
};

$(document).ready(homeObj.setTimeoutFormatDateTime);