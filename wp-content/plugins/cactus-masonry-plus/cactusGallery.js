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


function CactusGallery() {
	this.container;
	this.outerContainer;
	this.h;
	this.w;
	this.countW;//Find the gallery content's maximum width
	this.bricks;
	this.additionRequested;
	this.count;
	this.resizeTimer;
	this.scrollBarListener;
	this.margin = 0;
	this.tolerance;
	this.evalMeta =  false;
	this.infiniteScroll = false;
	
	//Lazy loading
	this.lazyLoad = false;
	this.lazyLoadQueue;
	this.lazyLoadImage = null;
	this.lazyLoadBusy = false;
	this.lazyLoadBrick;
	this.lazyLoadIndex;
}

CactusGallery.prototype.init = function(outerContainer, container, brickMargin, tolerance) {
	this.container = container;
	this.outerContainer = outerContainer;
	this.margin = brickMargin;
	this.tolerance = (tolerance <= 0 || tolerance > 1 || this.evalMeta) ? 1 : tolerance;
	this.w = jQuery(outerContainer).outerWidth(false) + brickMargin;
	this.h = 0;
	this.countW = 0;
	if(typeof this.bricks == "object") this.bricks.length = 0;
	if(typeof this.brickQueue == "object") this.brickQueue.length = 0;
	if(typeof this.lazyLoadQueue == "object") this.lazyLoadQueue.length = 0;
	this.bricks = new Array();
	this.brickQueue = new Array();
	this.lazyLoadQueue = new Array();
	this.additionRequested = false;
	//Handle infinite scroll
	if(this.infiniteScroll) {
		this.lazyLoadBusy = false;
		jQuery(window).on("scroll.cactusGallery", this.infiniteScrollListener.bind(this));
		if(window.top != window) jQuery(window.top).on("scroll.cactusGallery", this.infiniteScrollListener.bind(this));
	}
	//Handle lazy load
	if(this.lazyLoad) {
		jQuery(window).on("scroll.cactusGallery resize.cactusGallery orientationchange.cactusGallery", this.lazyLoadListener.bind(this));
		if(window.top != window) jQuery(window.top).on("scroll.cactusGallery", this.lazyLoadListener.bind(this));
	}
	//Handle scroll bar detection (resize gallery once scroll bar has appeared)
	jQuery(window).on("resize.cactusGallery orientchange.cactusGallery", this.scheduleRefresh.bind(this));
	this.count = 0;
	var sb = document.createElement("iframe");
	sb.id = 'cacsds';
	sb.style.cssText = "height: 0; background-color: transparent; margin: 0; padding: 0; overflow: hidden; border-width: 0; position: absolute; width: 100%;";
	this.scrollBarListener = sb;
	jQuery(sb).on("load", this.internalScrollListenerReady.bind(this));
	document.body.appendChild(sb);
}

CactusGallery.prototype.scheduleRefresh = function() {
	clearTimeout(this.resizeTimer);
	this.resizeTimer = setTimeout(this.redrawGallery.bind(this), 25);
}

CactusGallery.prototype.redrawGallery = function() {
	if(!window.requestAnimationFrame) this.internalRedrawGallery();
    else if(!this.additionRequested) {
		this.additionRequested = true;
        window.requestAnimationFrame(this.internalRedrawGallery.bind(this));
    }
}

CactusGallery.prototype.addBrick = function(b, initWidth, initHeight) {
	b.initWidth = initWidth;
	b.initHeight = initHeight;
	this.brickQueue.unshift(b);
	if(!window.requestAnimationFrame) this.internalProcessQueue();
    else if(!this.additionRequested) {
		this.additionRequested = true;
        window.requestAnimationFrame(this.internalProcessQueue.bind(this));
    }
}

CactusGallery.prototype.destroy = function(b) {
	jQuery(window).off("resize.cactusGallery orientchange.cactusGallery");
	clearTimeout(this.resizeTimer);
	jQuery(this.scrollBarListener).remove();
	this.scrollBarListener = null;
	this.resizeTimer = null;
	this.container.innerHTML = '';
	this.container = null;
	this.bricks.length = 0;
	this.brickQueue.length = 0;
	this.additionRequested = false;
}

CactusGallery.prototype.internalProcessQueue = function() {
	while(this.brickQueue.length > 0 && (!this.infiniteScroll || this.infiniteScrollReady(-2000))) {
		var dom = this.brickQueue.pop();
		dom.style.visibility = "hidden";
		this.container.appendChild(dom);
		var b = new CactusBrick();
		b.init(dom, this.count, this.tolerance, this.evalMeta, this.w, dom.initHeight, dom.initWidth);
		this.bricks.push(b);
		this.count++;
		this.internalPositionBrick(b);
		if(this.lazyLoad && b.DOM.loadPending) this.lazyLoadQueue.push(b);
	}
	this.additionRequested = false;
	jQuery(this.container).css({height : 	this.h + "px",
								width :		this.countW + "px"});
	if(this.lazyLoad) this.processLazyLoad();
}

CactusGallery.prototype.infiniteScrollReady = function(offset) {
	if(!this.infiniteScroll) return true;
	var y;
	var wt = window.top;
	//Handle galleries embedded in an iframe
	if(window != wt) {
		var y = jQuery(window).scrollTop() + jQuery(wt).scrollTop() + jQuery(wt).height();
		y -= (jQuery(window.frameElement).offset().top + jQuery(this.container).offset().top + this.h);
	} else {//Handle non-embedded galleries
		var y = jQuery(window).scrollTop() + jQuery(window).height();
		y -= (jQuery(this.container).offset().top + this.h);
	}
	return (y > offset);
}

CactusGallery.prototype.infiniteScrollListener = function() {
	if(this.infiniteScrollReady(-500)) this.internalProcessQueue();
}

CactusGallery.prototype.processLazyLoad = function() {
	if(this.lazyLoadBusy) return;
	var i = 0, j = this.lazyLoadQueue.length;
	if(j == 0) {
		this.lazyLoadBrick = null;
		jQuery(this.lazyLoadImage).off("error load");
		this.lazyLoadImage = null;
		return;
	}
	var b, wt = window.top;
	var wTop, wBtm;
	//Handle galleries embedded in an iframe
	if(window != wt) {
		var wTop = jQuery(window).scrollTop() + jQuery(wt).scrollTop() - jQuery(this.container).position().top - jQuery(window.frameElement).offset().top;
		var wBtm = wTop + jQuery(wt).height() + 1000;
	} else {//Handle non-embedded galleries
		var wTop = jQuery(window).scrollTop() - jQuery(this.container).position().top;
		var wBtm = wTop + jQuery(window).height() + 1000;
	}
	for(; i < j; i++) {
		b = this.lazyLoadQueue[i];
		//If the brick is visible on the screen
		if((b.y + b.h >= wTop) && (b.y <= wBtm)) {
			this.lazyLoadBusy = true;
			this.lazyLoadBrick = b;
			jQuery(this.lazyLoadImage).off("error load");
			this.lazyLoadImage = null;
			this.lazyLoadImage = new Image();
			this.lazyLoadIndex = i;
			jQuery(this.lazyLoadImage).one("error", this.imageLoadError.bind(this));
			jQuery(this.lazyLoadImage).one("load", this.imageLoaded.bind(this));
			var dom = b.DOM;
			jQuery(dom).addClass("loading");
			this.lazyLoadImage.src = dom.firstElementChild.dataSource;
			return;
		}
	}
}

CactusGallery.prototype.imageLoadError = function(ev) {
	jQuery(this.lazyLoadBrick.DOM).removeClass("loading");
	this.lazyLoadBusy = false;
	console.log('image load error');
	this.processLazyLoad();
}

CactusGallery.prototype.imageLoaded = function() {
	var br = this.lazyLoadBrick.DOM;
	jQuery(br).removeClass("loading");
	br.loadPending = false;
	var el = br.firstElementChild;
	el.style.backgroundImage = "url('" + el.dataSource + "')";
	el.style.opacity = 1;
	this.lazyLoadQueue.splice(this.lazyLoadIndex, 1);
	this.lazyLoadBusy = false;
	this.processLazyLoad();
}

CactusGallery.prototype.lazyLoadListener = function() {
	if(!this.lazyLoadBusy) this.processLazyLoad();
}

CactusGallery.prototype.internalRedrawGallery = function() {
	var w1 = jQuery(this.outerContainer).outerWidth(false) + this.margin;
	if(this.w !== w1) {
		this.w = w1;
		this.h = 0;
		this.countW = 0;
		//Invalidate all bricks
		var i = 0, j = this.bricks.length;
		for(; i < j; i++) {
			this.bricks[i].updateWidth(this.w);
		}
		//Position each brick
		for(i = 0; i < j; i++) {
			this.internalPositionBrick(this.bricks[i]);
		}
	}
	this.additionRequested = false;
	jQuery(this.container).css({height : 	this.h + "px",
								width :		this.countW + "px"});
}

CactusGallery.prototype.internalPositionBrick = function(br) {
	var i, j = this.bricks.length, t, mw;
	var b = new CactusBrick();
	var rowHeight = 9999999;
	b.clone(br);
	b.x = 0;
	b.y = 0;
	var positioned = false;
	while(!positioned) {
		positioned = true;
		for(i = 0; i < j; i++) {
			t = this.bricks[i];
			if(t.rendered && t.id !== b.id && (t.intersects(b)/* || (b.x + b.minW > this.w+1)*/)) {
				if(i === j - 1) positioned = false;
				positioned = false;
				rowHeight = Math.min(rowHeight, (t.y + t.h + t.metaH));
				if(b.x + b.minW > this.w+1) {
					b.y = rowHeight;
					rowHeight = 9999999;
					b.x = 0;
				}
				break;
			} else this.countW = Math.max(this.countW, b.x + b.w-1);
		}
	}
	this.h = Math.max(this.h, b.y + b.h + b.metaH);
	//Handle overhang
	if(b.scalable && b.x + b.w > this.w) b.w = this.w - b.x;
	else if(b.w > this.w) b.w = this.w;
	br.clone(b);
	br.update();
}

CactusGallery.prototype.internalScrollListenerReady = function() {
	this.scrollBarListener.contentWindow.addEventListener("resize", function() {
		jQuery(window).trigger("resize");
	});
}