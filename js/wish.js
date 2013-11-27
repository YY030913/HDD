/*
* tiyo wish
* teo.leung@gmail.com
*/

(function($){
	$.fn.wish = function() {
		var _this = this;
		var _wish = _this.find('div');
		var _wishs = _wish.length;
		
		var wish = {
			area:{
				left:0,
				top:0,
				right: _this.width(),
				bottom: _this.height()
			},
            skin:{
                width: 225,
                height: 206
            }
		};
		$.extend(wish);
	
		var _left = wish.area.left;
		var _right = wish.area.right;
		var _top = wish.area.top;
		var _bottom = wish.area.bottom;
		
		_right = _right - _left > wish.skin.width ? _right : _left + wish.skin.width;
		_bottom = _bottom - _top > wish.skin.height ? _bottom : _top + wish.skin.height;
		
		_right = _right - wish.skin.width;
		_bottom = _bottom - wish.skin.height;
			
		var methods = {
			rans : function(v1,v2){
				var ran = parseInt(Math.random() * (v2 - v1) + v1);
				return ran;
			},
			pos : function(){
				return {left:methods.rans(_left, _right), top:methods.rans(_top, _bottom)}
			},
			css : function(){
				return methods.rans(1,10);
			}
		}

		_wish.each(function(i){
			var _p = methods.pos();
			var _s = methods.css();
			var _self = $(this);
			_self.prepend('<a class="close"></a>');
			_self.addClass('wish').addClass('s'+_s);
			_self.hover(
				function(){
					_self.css({'z-index':'997'}).children('.close').show().bind('click',function(){_self.css('opacity','0')});
				},
				function(){
					_self.css({'z-index':'','border':'none'}).children('.close').hide();
			});
		});

	};

})( jQuery );