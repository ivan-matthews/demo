function equal(first,second){
	if(first === second){
		return true;
	}
	return false;
}
function parse_url(url) {
	let parser = document.createElement('a');
	parser.href = url;
	return {
		href: parser.href,
		host: parser.host,
		protocol: parser.protocol,
		hostname: parser.hostname,
		port: parser.port,
		pathname: parser.pathname,
		search: parser.search,
		hash: parser.hash,
	};
}
function str_replace(search,replace,subject){
	let result = subject;
	if(typeof search !== 'string'){
		for(let i=0;i<count(length);i++){
			let regex = new RegExp(search[i].replace(/(\W)/g,'\\$1'),"g");
			let place = (typeof replace !== 'string') ? replace[i] : replace;
			result = result.replace(regex,place);
		}
	}else{
		let regex = new RegExp(search.replace(/(\W)/g,'\\$1'),"g");
		result = result.replace(regex,replace);
	}
	return result;
}
function str_ireplace(search,replace,subject){
	let result = subject;
	if(typeof search !== 'string'){
		for(let i=0;i<count(search);i++){
			let regex = new RegExp(search[i].replace(/(\W)/g,'\\$1'),"gi");
			let place = (typeof replace !== 'string') ? replace[i] : replace;
			result = result.replace(regex,place);
		}
	}else{
		let regex = new RegExp(search.replace(/(\W)/g,'\\$1'),"gi");
		result = result.replace(regex,replace);
	}
	return result;
}
function isset(s){
	if(!is_null(s) && defined(s)){
		return true;
	}
	return false;
}
function empty(s){
	if(!defined(s.length)){ return false; }
	if(s.length === 0){
		return true;
	}
	return false;
}
function count(s){
	if(defined(s.length)){
		return s.length;
	}
	return 0;
}
function is_null(s){
	if(s === null){
		return true;
	}
	return false;
}
function defined(variable){
	if(variable !== undefined){
		return true;
	}
	return false;
}
function explode(delimiter,string){
	if(defined(string)){
		return string.split(delimiter);
	}
	return [];
}
function implode(glue,array){
	if(typeof array !== "object"){
		return array;
	}
	return array.join(glue);
}
function join(glue,array){
	return implode(glue,array);
}
function rand(min,max=false){
	return Math.floor(Math.random() * (max - min + 1) + min);
}