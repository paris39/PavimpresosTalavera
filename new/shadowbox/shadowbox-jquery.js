if (typeof jQuery=="undefined") {
	throw "Unable to load Shadowbox, jQuery library not found."
}
var Shadowbox = {};
Shadowbox.lib = {
	getStyle : function(B, A) {
		return jQuery(B).css(A)
	},
	setStyle : function (C,B,D) {
		if (typeof B != "object") {
			var A = {};
			A[B] = D;
			B = A
		}
		jQuery(C).css(B)
	},
	get : function (A) {
		return (typeof A == "string")?document.getElementById(A):A
	},
	remove : function (A) {
		jQuery(A).remove()
	},
	getTarget : function (A) {
		return A.target
	},
	preventDefault : function (A) {
		A = A.browserEvent || A;
		if (A.preventDefault) {
			A.preventDefault()
		} else {
			A.returnValue = false
		}
	},
	addEvent : function (C, A, B) {
		jQuery(C).bind(A, B)
	},
	removeEvent : function (C, A, B) {
		jQuery(C).unbind(A, B)
	},
	animate : function (A, D, C, F) {
		C = Math.round(C * 1000);
		var E = {};
		for (var B in D) {
			for (var B in D) {
				E[B] = String(D[B].to);
				if (B != "opacity") {
					E[B] += "px"
				}
			}
		}
		jQuery(A).animate(E, C, null, F)
	}
};
(function (A) {
	A.fn.shadowbox = function (B) {
		return this.each(function() {
			var E = A(this);
			var D = A.extend({}, B||{}, A.metadata?E.metadata():A.meta?E.data():{});
			var C = this.className||"";
			D.width = parseInt((C.match(/w:(\d+)/)||[])[1])||D.width;
			D.height = parseInt((C.match(/h:(\d+)/)||[])[1])||D.height;
			Shadowbox.setup(E, D)
		})
	}
})(jQuery)