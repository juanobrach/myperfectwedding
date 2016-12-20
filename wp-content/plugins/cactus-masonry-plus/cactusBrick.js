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


function CactusBrick() {
	//Element data
	this.DOM;
	this.meta;
	
	//Options
	this.tolerance = 0.75;
	
	//Virtual metadata
	this.id;
	this.rendered = false;
	this.evalMaxW;
	this.evalMaxH;
	this.evalMeta;
	
	//Stored spatial data
	this.x;
	this.y;
	this.h;
	this.w;
	this.initialW;
	this.initialH;
	this.minW;
	this.minH = 0;
	this.maxH;
	
	this.maxResH;
	this.maxResW;
	
	this.metaH;
	
	this.aspect = 1;

	//Store text CSS values
	this.cssW;
	this.cssH;
	this.cssMinW;
	this.cssMinH;
	this.cssMaxW;
	this.cssMaxH;
	
	//Store data derived from CSS values
	this.hasH;
	this.hasMinW;
	this.hasMinH;
	this.hasMaxW;
	this.hasMaxH;

	this.scalable;
	this.scalableMinW;
	this.scalableMaxW;
	
	//Store numerical CSS derived measurements
	this.cssValH;
	this.cssValMinW;
	this.cssValMinH;
	this.cssValMaxW;
	this.cssValMaxH;
}

CactusBrick.prototype.init = function(b, id, tolerance, evalMeta, parentW, maxResH, maxResW) {
	this.id = id;
	this.DOM = b;
	this.meta = jQuery(b).find(".meta")[0];
	this.evalMeta = evalMeta;
	this.tolerance = tolerance;
	var aspect = maxResH / maxResW;
	if(!isNaN(aspect)) this.aspect = aspect;
	this.maxResH = maxResH;
	this.maxResW = maxResW;
	this.initialW = Math.floor(jQuery(b).outerWidth());
	this.initialH = Math.floor(jQuery(b).outerHeight());
	this.getCSS();
	this.updateSizing(parentW);
}

CactusBrick.prototype.clone = function(b) {
	//Element data
	this.DOM = b.DOM;
	
	//Options
	this.tolerance = b.tolerance;
	
	//Virtual metadata
	this.id = b.id;
	this.rendered = b.rendered;
	this.evalMaxW = b.evalMaxW;
	this.evalMaxH = b.evalMaxH;
	this.evalMeta = b.evalMeta;
	
	//Stored spatial data
	this.x = b.x;
	this.y = b.y;
	this.h = b.h;
	this.w = b.w;
	this.initialW = b.initialW;
	this.initialH = b.initialH;
	this.maxResH = b.maxResH;
	this.maxResW = b.maxResW;
	this.minW = b.minW;
	this.minH = b.minH;
	this.maxH = b.maxH;
	
	this.metaH = b.metaH;
	
	this.aspect = b.aspect;

	//Store text CSS values
	this.cssW = b.cssW;
	this.cssH = b.cssH;
	this.cssMinW = b.cssMinW;
	this.cssMinH = b.cssMinH;
	this.cssMaxW = b.cssMaxW;
	this.cssMaxH = b.cssMaxH;
	
	//Store data derived from CSS values
	this.hasH = b.hasH;
	this.hasMinW = b.hasMinW;
	this.hasMinH = b.hasMinH;
	this.hasMaxW = b.hasMaxW;
	this.hasMaxH = b.hasMaxH;

	this.scalable = b.scalable;
	this.scalableMinW = b.scalableMinW;
	this.scalableMaxW = b.scalableMaxW;
	
	//Store numerical CSS derived measurements
	this.cssValH = b.cssValH;
	this.cssValMinW = b.cssValMinW;
	this.cssValMinH = b.cssValMinH;	
	this.cssValMaxW = b.cssValMaxW;
	this.cssValMaxH = b.cssValMaxH;
}

CactusBrick.prototype.getCSS = function() {
	//Get raw CSS data
	this.cssW = this.DOM.style.width;
	this.cssH = this.DOM.style.height;
	this.cssMinW = this.DOM.style.minWidth;
	this.cssMinH = this.DOM.style.minHeight;
	this.cssMaxW = this.DOM.style.maxWidth;
	this.cssMaxH = this.DOM.style.maxHeight;
	
	this.scalable = (this.cssW.indexOf('%') === -1);
	
	this.hasH = (this.cssH != "0px" && this.cssH.indexOf('px') !== -1);
	
	//Determine what data should be processed and applied
	this.hasMinW = (this.cssMinW != "");
	this.hasMinH = (this.cssMinH != "0px" && this.cssMinH.indexOf('px') !== -1);
	this.hasMaxW = (this.cssMaxW != "");
	this.hasMaxH = (this.cssMaxH != "0px" && this.cssMaxH.indexOf('px') !== -1);

	this.scalableMinW = (this.hasMinW && this.cssMinW.indexOf('%') !== -1);
	this.scalableMaxW = (this.hasMaxW && this.cssMaxW.indexOf('%') !== -1);
}

//Extract numerical values from stored CSS data
CactusBrick.prototype.updateSizing = function(parentW) {
	function parseCssFloat(v) {
		var o = parseFloat(v);
		if(jQuery.isNumeric(o)) return o;
		return 0;
	}
	this.rendered = false;
	
	//Prepare minimum width
	if(this.scalableMinW) this.cssValMinW = parentW / 100 * parseCssFloat(this.cssMinW);
	else if(this.hasMinW) this.cssValMinW = Math.min(parseCssFloat(this.cssMinW), parentW);
	else this.cssValMinW = 0;
	
	//Prepare minimum height
	if(this.hasH) this.cssValH = parseCssFloat(this.cssH);
	if(this.hasMinH) this.cssValMinH = parseCssFloat(this.cssMinH);
	else this.cssValMinH = 0;

	//Prepare maximum width
	if(this.scalableMaxW) this.cssValMaxW = parentW / 100 * parseCssFloat(this.cssMaxW);
	else if(this.hasMaxW) this.cssValMaxW = parseCssFloat(this.cssMaxW);
	else this.cssValMaxW = 0;

	//Prepare maximum height
	if(this.hasMaxH) this.cssValMaxH = parseCssFloat(this.cssMaxH);
	else this.cssValMaxH = 0;
	
	//Process values into useable sizing data
	if(this.scalable) {//If this has a non-percentage width
	
		this.w = this.initialW;
		if(this.hasMaxW) this.maxW = this.cssValMaxW;
		else if(this.maxResW == 0) this.maxW = this.initialW;
		else this.maxW = this.maxResW;
		
		//Process minimum widths
		if(this.hasMinW) this.minW = Math.max(this.w * this.tolerance, this.cssValMinW);
		else this.minW = this.w * this.tolerance;	
		
		//Apply width limits
		if(this.w > this.maxW) this.w = this.maxW;
		if(this.w < this.minW) this.w = this.minW;
				
		//Process maximum heights
		if(this.hasH && this.hasMaxH) this.maxH = Math.min(this.cssValH, this.cssValMaxH, this.maxW * this.aspect);
		else if(this.hasMaxH) this.maxH = Math.min(this.initialH, this.cssValMaxH, this.maxW * this.aspect);
		else if(this.hasH) this.maxH = this.cssValH;
		else this.maxH = this.maxW * this.aspect;
		
		//Process minimum heights
		if(this.hasMinH) this.minH = Math.max(this.minW * this.aspect * this.tolerance, this.cssValMinH);
		else this.minH = this.minW * this.tolerance;
		if(this.minH > this.maxH) this.maxH = this.minH;
		
		//Store initial widths and heights for a running total during iterative processes
		this.evalMaxW = this.w;
		this.evalMaxH = this.initialH;
		
		//Apply height limits
		this.h = this.w * this.aspect;
		if(this.h > this.maxH) this.h = this.maxH;
		if(this.h < this.minH) this.h = this.minH;		
		
	} else {//If this has a percentage width
		//Process width
		this.w = parentW * parseCssFloat(this.cssW) / 100;
		
		//Process maximum widths
		if(this.hasMaxW) this.maxW = this.cssValMaxW;
		else this.maxW = this.w;
		
		//Process minimum widths
		if(this.hasMinW) this.minW = this.cssValMinW;
		else this.minW = this.w;

		//Apply width limits
		if(this.w > this.maxW) this.w = this.maxW;
		if(this.w < this.minW) this.w = this.minW;
		
		//Process maximum heights
		if(this.hasH && this.hasMaxH) this.maxH = Math.min(this.cssValH, this.cssValMaxH);
		else if(this.hasMaxH) this.maxH = Math.min(this.maxResH, this.cssValMaxH);
		else if(this.hasH) this.maxH = this.cssValH;
		else this.maxH = this.maxResH;
		
		//Process minimum heights
		if(this.hasMinH) this.minH = Math.min(this.initialH, this.cssValMinH);
		else this.minH = this.w * this.aspect;
		if(this.minH > this.maxH) this.maxH = this.minH;
		
		//Apply height limits
		this.h = this.w * this.aspect;
		if(this.h > this.maxH) this.h = this.maxH;
		if(this.h < this.minH) this.h = this.minH;
	}
	
	if(this.evalMeta) this.metaH = jQuery(this.meta).outerHeight();
	else this.metaH = 0;

	this.h = Math.ceil(this.h);
	this.w = Math.floor(this.w);
	this.maxW = Math.floor(this.maxW);
	this.minW = Math.floor(this.minW);
	this.maxH = Math.ceil(this.maxH);
	this.minH = Math.ceil(this.minH);
	
	this.DOM.setAttribute('maxH', this.maxH);
	this.DOM.setAttribute('minH', this.minH);
	this.DOM.setAttribute('maxW', this.maxW);
	this.DOM.setAttribute('minW', this.minW);
	this.DOM.setAttribute('w', this.w);
	this.DOM.setAttribute('h', this.h);
	this.DOM.setAttribute('aspect', this.aspect);
	this.DOM.setAttribute('initH', this.initialH);
	this.DOM.setAttribute('initW', this.initialW);
	
	this.DOM.setAttribute('metaH', this.metaH);
}

CactusBrick.prototype.updateWidth = function(parentW) {
	this.updateSizing(parentW);
}

CactusBrick.prototype.intersects = function(b) {
	if(b.scalable) return this.scalableIntersect(b);
	return this.nonScalableIntersect(b);
}

CactusBrick.prototype.scalableIntersect = function(b) {
	//Get left, right, top, and bottom of each rectangle
	var top1 = this.y;
	var top2 = b.y;
	var left1 = this.x;
	var left2 = b.x;
	var right1 = left1 + this.w;
	var right2 = left2 + Math.max(b.initialW, b.minW);
	var bottom1 = top1 + this.h + this.metaH;
	var bottom2 = top2 + b.maxH + b.metaH;
	if(left1 >= right2) return false;
	
	if(left1 >= left2 + b.minW) {
		if(left1 > left2) {
			if((top1 < top2 && bottom1 > top2) || (top1 < bottom2 && bottom1 > bottom2)) {
				b.w = Math.min(Math.max(left1 - left2, b.minW), b.evalMaxW);
				b.evalMaxW = b.w;
				return false;
			}
		}
	}
	if(left2 >= right1)	return false;
	if(top1 >= bottom2) return false;
	if(top1 >= top2 + b.minH) {
		if(top1 > top2) {
			if((left1 < left2 && right1 > left2) || (left1 < right2 && right1 > right2)) {
				b.h = Math.min(Math.max(top1 - top2, b.minH), b.evalMaxH, b.h);
				b.evalMaxH = b.h;
				return false;
			}
		}
	}
	if(top2 >= bottom1) return false;
	var t = Math.max(b.initialW, b.minW);
	b.w = t;
	b.evalMaxW = t;
	t = Math.ceil(b.w * b.aspect);
	if(t > b.maxH) t = b.maxH;
	if(t < b.minH) t = b.minH;
	b.h = t;
	b.evalMaxH = t;
	b.x = right1;
	return true;
}

CactusBrick.prototype.nonScalableIntersect = function(b) {
	//Get left, right, top, and bottom of each rectangle
	var top1 = this.y;
	var top2 = b.y;
	var left1 = this.x;
	var left2 = b.x;
	var right1 = left1 + this.w;
	var right2 = left2 + b.w;
	var bottom1 = top1 + this.h + this.metaH;
	var bottom2 = top2 + b.h + b.metaH;
	if(left1 >= right2 || left2 >= right1) return false;
	if(top1 >= bottom2 || top2 >= bottom1) return false;
	b.x = right1;
	return true;
}

CactusBrick.prototype.update = function() {
	if(this.scalable) jQuery(this.DOM).css({	top:		this.y + "px",
												left:		this.x + "px",
												height:		this.h + "px",
												width:		this.w + "px",
												minWidth:	this.minW + "px",
												maxWidth:	this.maxW + "px",
												minHeight:	this.minH + "px",
												maxHeight:	this.maxH + "px",
												visibility:	"visible"});
	else jQuery(this.DOM).css({					top:		this.y + "px",
												left:		this.x + "px",
												height:		this.h + "px",
												width:		this.w + "px",
												minWidth:	this.minW + "px",
												maxWidth:	this.maxW + "px",
												minHeight:	this.minH + "px",
												maxHeight:	this.maxH + "px",
												visibility:	"visible"});
	this.rendered = true;
}
CactusBrick.prototype.removeFromFlow = function() {
	this.rendered = false;
}