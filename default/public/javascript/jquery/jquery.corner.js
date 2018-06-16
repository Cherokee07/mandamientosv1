From: "Guardado por Windows Internet Explorer 8"
Subject: 
Date: Fri, 31 Dec 2010 14:58:30 -0600
MIME-Version: 1.0
Content-Type: text/html;
	charset="utf-8"
Content-Transfer-Encoding: quoted-printable
Content-Location: https://github.com/malsup/corner/raw/master/jquery.corner.js?v2.09
X-MimeOLE: Produced By Microsoft MimeOLE V6.0.6001.18049

=EF=BB=BF<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META content=3D"text/html; charset=3Dutf-8" http-equiv=3DContent-Type>
<META name=3DGENERATOR content=3D"MSHTML 8.00.6001.18882"></HEAD>
<BODY><PRE>/*!
 * jQuery corner plugin: simple corner rounding
 * Examples and documentation at: http://jquery.malsup.com/corner/
 * version 2.11 (15-JUN-2010)
 * Requires jQuery v1.3.2 or later
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 * Authors: Dave Methvin and Mike Alsup
 */

/**
 *  corner() takes a single string argument:  $('#myDiv').corner("effect =
corners width")
 *
 *  effect:  name of the effect to apply, such as round, bevel, notch, =
bite, etc (default is round).=20
 *  corners: one or more of: top, bottom, tr, tl, br, or bl.  (default =
is all corners)
 *  width:   width of the effect; in the case of rounded corners this is =
the radius.=20
 *           specify this value using the px suffix such as 10px (yes, =
it must be pixels).
 */
;(function($) {=20

var style =3D document.createElement('div').style,
    moz =3D style['MozBorderRadius'] !=3D=3D undefined,
    webkit =3D style['WebkitBorderRadius'] !=3D=3D undefined,
    radius =3D style['borderRadius'] !=3D=3D undefined || =
style['BorderRadius'] !=3D=3D undefined,
    mode =3D document.documentMode || 0,
    noBottomFold =3D $.browser.msie &amp;&amp; (($.browser.version &lt; =
8 &amp;&amp; !mode) || mode &lt; 8),

    expr =3D $.browser.msie &amp;&amp; (function() {
        var div =3D document.createElement('div');
        try { div.style.setExpression('width','0+0'); =
div.style.removeExpression('width'); }
        catch(e) { return false; }
        return true;
    })();

$.support =3D $.support || {};
$.support.borderRadius =3D moz || webkit || radius; // so you can do:  =
if (!$.support.borderRadius) $('#myDiv').corner();

function sz(el, p) {=20
    return parseInt($.css(el,p))||0;=20
};
function hex2(s) {
    var s =3D parseInt(s).toString(16);
    return ( s.length &lt; 2 ) ? '0'+s : s;
};
function gpc(node) {
    while(node) {
        var v =3D $.css(node,'backgroundColor'), rgb;
        if (v &amp;&amp; v !=3D 'transparent' &amp;&amp; v !=3D 'rgba(0, =
0, 0, 0)') {
            if (v.indexOf('rgb') &gt;=3D 0) {=20
                rgb =3D v.match(/\d+/g);=20
                return '#'+ hex2(rgb[0]) + hex2(rgb[1]) + hex2(rgb[2]);
            }
            return v;
        }
        if (node.nodeName.toLowerCase() =3D=3D 'html')
            break;
        node =3D node.parentNode; // keep walking if transparent
    }
    return '#ffffff';
};

function getWidth(fx, i, width) {
    switch(fx) {
    case 'round':  return =
Math.round(width*(1-Math.cos(Math.asin(i/width))));
    case 'cool':   return =
Math.round(width*(1+Math.cos(Math.asin(i/width))));
    case 'sharp':  return =
Math.round(width*(1-Math.cos(Math.acos(i/width))));
    case 'bite':   return =
Math.round(width*(Math.cos(Math.asin((width-i-1)/width))));
    case 'slide':  return Math.round(width*(Math.atan2(i,width/i)));
    case 'jut':    return =
Math.round(width*(Math.atan2(width,(width-i-1))));
    case 'curl':   return Math.round(width*(Math.atan(i)));
    case 'tear':   return Math.round(width*(Math.cos(i)));
    case 'wicked': return Math.round(width*(Math.tan(i)));
    case 'long':   return Math.round(width*(Math.sqrt(i)));
    case 'sculpt': return =
Math.round(width*(Math.log((width-i-1),width)));
    case 'dogfold':
    case 'dog':    return (i&amp;1) ? (i+1) : width;
    case 'dog2':   return (i&amp;2) ? (i+1) : width;
    case 'dog3':   return (i&amp;3) ? (i+1) : width;
    case 'fray':   return (i%2)*width;
    case 'notch':  return width;=20
    case 'bevelfold':
    case 'bevel':  return i+1;
    }
};

$.fn.corner =3D function(options) {
    // in 1.3+ we can fix mistakes with the ready state
    if (this.length =3D=3D 0) {
        if (!$.isReady &amp;&amp; this.selector) {
            var s =3D this.selector, c =3D this.context;
            $(function() {
                $(s,c).corner(options);
            });
        }
        return this;
    }

    return this.each(function(index){
        var $this =3D $(this),
            // meta values override options
            o =3D [$this.attr($.fn.corner.defaults.metaAttr) || '', =
options || ''].join(' ').toLowerCase(),
            keep =3D /keep/.test(o),                       // keep =
borders?
            cc =3D ((o.match(/cc:(#[0-9a-f]+)/)||[])[1]),  // corner =
color
            sc =3D ((o.match(/sc:(#[0-9a-f]+)/)||[])[1]),  // strip =
color
            width =3D parseInt((o.match(/(\d+)px/)||[])[1]) || 10, // =
corner width
            re =3D =
/round|bevelfold|bevel|notch|bite|cool|sharp|slide|jut|curl|tear|fray|wic=
ked|sculpt|long|dog3|dog2|dogfold|dog/,
            fx =3D ((o.match(re)||['round'])[0]),
            fold =3D /dogfold|bevelfold/.test(o),
            edges =3D { T:0, B:1 },
            opts =3D {
                TL:  /top|tl|left/.test(o),       TR:  =
/top|tr|right/.test(o),
                BL:  /bottom|bl|left/.test(o),    BR:  =
/bottom|br|right/.test(o)
            },
            // vars used in func later
            strip, pad, cssHeight, j, bot, d, ds, bw, i, w, e, c, =
common, $horz;
       =20
        if ( !opts.TL &amp;&amp; !opts.TR &amp;&amp; !opts.BL &amp;&amp; =
!opts.BR )
            opts =3D { TL:1, TR:1, BL:1, BR:1 };
           =20
        // support native rounding
        if ($.fn.corner.defaults.useNative &amp;&amp; fx =3D=3D 'round' =
&amp;&amp; (radius || moz || webkit) &amp;&amp; !cc &amp;&amp; !sc) {
            if (opts.TL)
                $this.css(radius ? 'border-top-left-radius' : moz ? =
'-moz-border-radius-topleft' : '-webkit-border-top-left-radius', width + =
'px');
            if (opts.TR)
                $this.css(radius ? 'border-top-right-radius' : moz ? =
'-moz-border-radius-topright' : '-webkit-border-top-right-radius', width =
+ 'px');
            if (opts.BL)
                $this.css(radius ? 'border-bottom-left-radius' : moz ? =
'-moz-border-radius-bottomleft' : '-webkit-border-bottom-left-radius', =
width + 'px');
            if (opts.BR)
                $this.css(radius ? 'border-bottom-right-radius' : moz ? =
'-moz-border-radius-bottomright' : '-webkit-border-bottom-right-radius', =
width + 'px');
            return;
        }
           =20
        strip =3D document.createElement('div');
        $(strip).css({
            overflow: 'hidden',
            height: '1px',
            minHeight: '1px',
            fontSize: '1px',
            backgroundColor: sc || 'transparent',
            borderStyle: 'solid'
        });
   =20
        pad =3D {
            T: parseInt($.css(this,'paddingTop'))||0,     R: =
parseInt($.css(this,'paddingRight'))||0,
            B: parseInt($.css(this,'paddingBottom'))||0,  L: =
parseInt($.css(this,'paddingLeft'))||0
        };

        if (typeof this.style.zoom !=3D undefined) this.style.zoom =3D =
1; // force 'hasLayout' in IE
        if (!keep) this.style.border =3D 'none';
        strip.style.borderColor =3D cc || gpc(this.parentNode);
        cssHeight =3D $(this).outerHeight();

        for (j in edges) {
            bot =3D edges[j];
            // only add stips if needed
            if ((bot &amp;&amp; (opts.BL || opts.BR)) || (!bot =
&amp;&amp; (opts.TL || opts.TR))) {
                strip.style.borderStyle =3D 'none =
'+(opts[j+'R']?'solid':'none')+' none '+(opts[j+'L']?'solid':'none');
                d =3D document.createElement('div');
                $(d).addClass('jquery-corner');
                ds =3D d.style;

                bot ? this.appendChild(d) : this.insertBefore(d, =
this.firstChild);

                if (bot &amp;&amp; cssHeight !=3D 'auto') {
                    if ($.css(this,'position') =3D=3D 'static')
                        this.style.position =3D 'relative';
                    ds.position =3D 'absolute';
                    ds.bottom =3D ds.left =3D ds.padding =3D ds.margin =
=3D '0';
                    if (expr)
                        ds.setExpression('width', =
'this.parentNode.offsetWidth');
                    else
                        ds.width =3D '100%';
                }
                else if (!bot &amp;&amp; $.browser.msie) {
                    if ($.css(this,'position') =3D=3D 'static')
                        this.style.position =3D 'relative';
                    ds.position =3D 'absolute';
                    ds.top =3D ds.left =3D ds.right =3D ds.padding =3D =
ds.margin =3D '0';
                   =20
                    // fix ie6 problem when blocked element has a border =
width
                    if (expr) {
                        bw =3D sz(this,'borderLeftWidth') + =
sz(this,'borderRightWidth');
                        ds.setExpression('width', =
'this.parentNode.offsetWidth - '+bw+'+ "px"');
                    }
                    else
                        ds.width =3D '100%';
                }
                else {
                    ds.position =3D 'relative';
                    ds.margin =3D !bot ? '-'+pad.T+'px -'+pad.R+'px =
'+(pad.T-width)+'px -'+pad.L+'px' :=20
                                        (pad.B-width)+'px -'+pad.R+'px =
-'+pad.B+'px -'+pad.L+'px';               =20
                }

                for (i=3D0; i &lt; width; i++) {
                    w =3D Math.max(0,getWidth(fx,i, width));
                    e =3D strip.cloneNode(false);
                    e.style.borderWidth =3D '0 '+(opts[j+'R']?w:0)+'px 0 =
'+(opts[j+'L']?w:0)+'px';
                    bot ? d.appendChild(e) : d.insertBefore(e, =
d.firstChild);
                }
               =20
                if (fold &amp;&amp; $.support.boxModel) {
                    if (bot &amp;&amp; noBottomFold) continue;
                    for (c in opts) {
                        if (!opts[c]) continue;
                        if (bot &amp;&amp; (c =3D=3D 'TL' || c =3D=3D =
'TR')) continue;
                        if (!bot &amp;&amp; (c =3D=3D 'BL' || c =3D=3D =
'BR')) continue;
                       =20
                        common =3D { position: 'absolute', border: =
'none', margin: 0, padding: 0, overflow: 'hidden', backgroundColor: =
strip.style.borderColor };
                        $horz =3D $('&lt;div/&gt;').css(common).css({ =
width: width + 'px', height: '1px' });
                        switch(c) {
                        case 'TL': $horz.css({ bottom: 0, left: 0 }); =
break;
                        case 'TR': $horz.css({ bottom: 0, right: 0 }); =
break;
                        case 'BL': $horz.css({ top: 0, left: 0 }); =
break;
                        case 'BR': $horz.css({ top: 0, right: 0 }); =
break;
                        }
                        d.appendChild($horz[0]);
                       =20
                        var $vert =3D =
$('&lt;div/&gt;').css(common).css({ top: 0, bottom: 0, width: '1px', =
height: width + 'px' });
                        switch(c) {
                        case 'TL': $vert.css({ left: width }); break;
                        case 'TR': $vert.css({ right: width }); break;
                        case 'BL': $vert.css({ left: width }); break;
                        case 'BR': $vert.css({ right: width }); break;
                        }
                        d.appendChild($vert[0]);
                    }
                }
            }
        }
    });
};

$.fn.uncorner =3D function() {=20
    if (radius || moz || webkit)
        this.css(radius ? 'border-radius' : moz ? '-moz-border-radius' : =
'-webkit-border-radius', 0);
    $('div.jquery-corner', this).remove();
    return this;
};

// expose options
$.fn.corner.defaults =3D {
    useNative: true, // true if plugin should attempt to use native =
browser support for border radius rounding
    metaAttr:  'data-corner' // name of meta attribute to use for =
options
};
   =20
})(jQuery);
</PRE></BODY></HTML>
