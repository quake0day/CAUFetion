// JavaScript Document

function $(el){ return document.getElementById(el);}
var douban = {
	baseUrl:'http://api.douban.com/people/quake/collection',
	params:{
		cat:'book',
		'start-index':1,
		'max-results':10,
		alt:'xd',
		apikey:'0664d6e9e576ac44132e84bdb06404cc',
		callback:'douban.appendHTML'
	},
	magicBox:'douban',
	buildUrl:function(){
		var ps = this.params,string='';
		for(var i in ps)
			string += i + '='+ ps[i]+ '&amp;';
		return this.baseUrl+"?"+string;
	},
	appendRequestScript:function(url){
		var head = document.getElementsByTagName("head")[0];
		var script = document.createElement("script");
		script.src = url;
		script.charset = 'utf-8';
		head.appendChild(script);
	},
	appendHTML:function(json){
		$(this.magicBox).innerHTML = this.render(this.parseJSON(json));
	},
	parseJSON:function(json){
		var itemCollection=[];
		for(var i in json.entry)
			itemCollection.push(this.parseEntry(json.entry[i]));
		return itemCollection;
	},
	parseEntry:function(entry){
		var linkItem = {};
		var linkEntry  = entry["db:subject"]["link"];
		linkItem.title = entry["db:subject"]["title"]["$t"];
		linkItem.src = 'http://panweizeng.com/images/douban-no-image.jpg';
		for(var i in linkEntry){
			if(linkEntry[i]['@rel'] == 'image')
				linkItem.src = linkEntry[i]['@href'];
			if(linkEntry[i]['@rel'] == 'alternate')
				linkItem.link = linkEntry[i]['@href'];
		}
		return linkItem;
	},
	render:function(itemCollection){
		var html='<table><tr>';
		for(var i in itemCollection){
			html+='<td><a href="'
				+itemCollection[i].link+'" target="_blank"><img src="'
				+itemCollection[i].src+'" alt="'
				+itemCollection[i].title+'" border="0" /></a></td>';
		}
		return html+"</tr></table>";
	},
	init:function(){
		this.appendRequestScript(this.buildUrl());
	}
}
douban.init();
