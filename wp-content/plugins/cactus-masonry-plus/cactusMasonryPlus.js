/**
	Cactus Masonry Plus.
	
	Copyright (C) 2016 cactus.cloud
	
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published
    by the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
**//*!@preserve Copyright 2016 cactus.cloud - Licensed under GNU AGPLv3. See <license.txt> or <http://www.gnu.org/licenses/>.*/

function CactusMasonryPlus() {
	this.brickH; //String
	this.brickW; //String
	this.brickMinW; //String
	this.brickMinH; //String
	this.brickMaxW; //String
	this.brickMaxH; //String
	this.defaultColor; //String
	this.gallery; //CactusGallery
	this.margin; //Integer
	this.tolerance; //Decimal
	this.lightbox; //Boolean
	this.queue; //Array(CactusBrick)
	this.infiniteScroll = false; //Boolean
	this.lazyLoad = true; //Boolean
	//Should the height of the metabox be included in the brick height 
	this.evalMeta; //Boolean
}

CactusMasonryPlus.prototype.init = function(el) {
	this.gallery = new CactusGallery();
	this.gallery.infiniteScroll = this.infiniteScroll;
	this.gallery.lazyLoad = this.lazyLoad;
	this.gallery.evalMeta = this.evalMeta;
	var outer = el.children[0];
	var inner = outer.children[0];
	this.gallery.init(outer, inner, this.margin * 2, parseFloat(this.tolerance));
	inner.style.margin = -this.margin + "px";
	this.queue = new Array();	
}

CactusMasonryPlus.prototype.addBrick = function(b) {
	b.margin = this.margin;
	b.color = this.defaultColor;
	b.lazyLoad = this.lazyLoad;
	var initW = b.w, initH = b.h;
	if(this.brickW != "auto") b.w = this.brickW;
	if(this.brickH != "auto") b.h = this.brickH;
	if(this.brickMinW != "auto") b.minW = this.brickMinW;
	if(this.brickMinH != "auto") b.minH = this.brickMinH;
	if(this.brickMaxW != "auto") b.maxW = this.brickMaxW;
	if(this.brickMaxH != "auto") b.maxH = this.brickMaxH;
	this.gallery.addBrick(b.build(), initW, initH);
}

function CMBrick() {
	var brick;
	var img;
}

CMBrick.prototype.init = function(b) {
	this.brick = b;
	this.img = new Image();
}

CactusMasonryPlus.prototype.queueBrick = function(b) {
	var t = new CMBrick();
	t.init(b);
	this.queue.push(t);
	this.triggerQueue();
}

CactusMasonryPlus.prototype.triggerQueue = function() {
	if(this.queue.length > 0) {
		var b = this.queue[0];
		if(b.brick.img != "") {
			b.img.onload = this.loadHandler.bind(this);
			b.img.src = b.brick.img;
		} else this.loadHandler();
	}
}

CactusMasonryPlus.prototype.loadHandler = function() {
	var b = this.queue[0].brick;
	this.queue.shift();
	this.addBrick(b);
	this.triggerQueue(); 
}

CactusMasonryPlus.prototype.destroy = function(b) {
	this.queue.length = 0;
	this.gallery.destroy();
}

function CactusMasonryBrick() {
	this.url = "";
	this.lazyLoad = false;
	this.authorUrl = "";
	this.img = "";
	this.w = "";
	this.h = "";
	this.aspect = "";
	this.minW = "";
	this.minH = "";
	this.maxW = "";
	this.maxH = "";
	this.color;
	this.margin;
	//Meta
	this.title = "";
	this.author = "";
	this.date = "";
	this.category = "";
}

CactusMasonryBrick.prototype.build = function() {
	var d = document.createElement("div");
	d.className = "brick";
	jQuery(d).css({	width				:	this.w,
					height				:	this.h,
					minWidth			:	this.minW,
					minHeight			:	this.minH,
					maxWidth			:	this.maxW,
					maxHeight			:	this.maxH
				});
	var i = document.createElement("div");
	i.className = "inner";
	
	var innerArgs = {	top					:	this.margin + "px",
						left				:	this.margin + "px",
						right				:	this.margin + "px",
						bottom				:	this.margin + "px"
					};
	d.loadPending = false;
	if(this.img == "" || this.img == null || typeof this.img === "undefined") innerArgs.backgroundColor = this.generateColor();
	else if(this.lazyLoad) {
		d.loadPending = true;
		i.dataSource = this.img;
		d.setAttribute("source", i.dataSource);
		innerArgs.opacity = 0;
	} else innerArgs.backgroundImage = "url('" + this.img + "')";
	
	if(this.url != "") i.innerHTML = "<a class=\"postLink\" href=\"" + this.url + "\"></a>";
	
	jQuery(i).css(innerArgs);

	var meta = "";
	if(this.title != "") meta += "<div class=\"title\">" + this.title + "</div>";
	if(this.author != "") {
		meta += "<div class=\"author\">";
		if(this.authorUrl != "") meta += "<a href=\"" + this.authorUrl + "\">" + this.author + "</a></div>";
		else meta += this.author + "</div>";
	}
	if(this.date != "") meta += "<div class=\"date\">" + this.date + "</div>";
	
	if(this.category != "") meta += "<div class=\"category\">" + this.category + "</div>";

	if(meta != "") i.innerHTML += "<div class=\"meta\">" + meta + "</div>";
	d.appendChild(i);

	return d;
}

CactusMasonryBrick.prototype.generateColor = function() {
	if(this.color === "pastel") {
		var r = Math.floor(((Math.random() * 255) + 255) / 2);
		var g = Math.floor(((Math.random() * 255) + 255) / 2);
		var b = Math.floor(((Math.random() * 255) + 255) / 2);
		return "rgb(" + r + ", " + g + ", " + b + ")";
	}
	if(this.color === "random") {
		var r = Math.floor((Math.random() * 255));
		var g = Math.floor((Math.random() * 255));
		var b = Math.floor((Math.random() * 255));
		return "rgb(" + r + ", " + g + ", " + b + ")";
	} 
	return this.color;
}