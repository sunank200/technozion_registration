/* Set the defaults for DataTables initialisation */
$.extend( true, $.fn.dataTable.defaults, {
	"sDom":
		"<'panel panel-default'<'panel-heading hidden-print'<'row'<'col-xs-6'l><'col-xs-6'Cf>r>>"+
		"t"+
		"<'panel-heading hidden-print'<'row'<'col-xs-6 text-danger'i><'col-xs-6'p>>>>",
	"oLanguage": {
		"sLengthMenu": "_MENU_ records per page"
	}
} );


/* Default class modification */
$.extend( $.fn.dataTableExt.oStdClasses, {
	"sWrapper": "dataTables_wrapper form-inline",
	"sFilterInput": "form-control input-sm",
	"sLengthSelect": "form-control input-sm"
} );

// In 1.10 we use the pagination renderers to draw the Bootstrap paging,
// rather than  custom plug-in
if ( $.fn.dataTable.Api ) {
	$.fn.dataTable.defaults.renderer = 'bootstrap';
	$.fn.dataTable.ext.renderer.pageButton.bootstrap = function ( settings, host, idx, buttons, page, pages ) {
		var api = new $.fn.dataTable.Api( settings );
		var classes = settings.oClasses;
		var lang = settings.oLanguage.oPaginate;
		var btnDisplay, btnClass;

		var attach = function( container, buttons ) {
			var i, ien, node, button;
			var clickHandler = function ( e ) {
				e.preventDefault();
				if ( e.data.action !== 'ellipsis' ) {
					api.page( e.data.action ).draw( false );
				}
			};

			for ( i=0, ien=buttons.length ; i<ien ; i++ ) {
				button = buttons[i];

				if ( $.isArray( button ) ) {
					attach( container, button );
				}
				else {
					btnDisplay = '';
					btnClass = '';

					switch ( button ) {
						case 'ellipsis':
							btnDisplay = '&hellip;';
							btnClass = 'disabled';
							break;

						case 'first':
							btnDisplay = lang.sFirst;
							btnClass = button + (page > 0 ?
								'' : ' disabled');
							break;

						case 'previous':
							btnDisplay = lang.sPrevious;
							btnClass = button + (page > 0 ?
								'' : ' disabled');
							break;

						case 'next':
							btnDisplay = lang.sNext;
							btnClass = button + (page < pages-1 ?
								'' : ' disabled');
							break;

						case 'last':
							btnDisplay = lang.sLast;
							btnClass = button + (page < pages-1 ?
								'' : ' disabled');
							break;

						default:
							btnDisplay = button + 1;
							btnClass = page === button ?
								'active' : '';
							break;
					}

					if ( btnDisplay ) {
						node = $('<li>', {
								'class': classes.sPageButton+' '+btnClass,
								'aria-controls': settings.sTableId,
								'tabindex': settings.iTabIndex,
								'id': idx === 0 && typeof button === 'string' ?
									settings.sTableId +'_'+ button :
									null
							} )
							.append( $('<a>', {
									'href': '#'
								} )
								.html( btnDisplay )
							)
							.appendTo( container );

						settings.oApi._fnBindAction(
							node, {action: button}, clickHandler
						);
					}
				}
			}
		};

		attach(
			$(host).empty().html('<ul class="pagination"/>').children('ul'),
			buttons
		);
	}
}
else {
	// Integration for 1.9-
	$.fn.dataTable.defaults.sPaginationType = 'bootstrap';

	/* API method to get paging information */
	$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
	{
		return {
			"iStart":         oSettings._iDisplayStart,
			"iEnd":           oSettings.fnDisplayEnd(),
			"iLength":        oSettings._iDisplayLength,
			"iTotal":         oSettings.fnRecordsTotal(),
			"iFilteredTotal": oSettings.fnRecordsDisplay(),
			"iPage":          oSettings._iDisplayLength === -1 ?
				0 : Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
			"iTotalPages":    oSettings._iDisplayLength === -1 ?
				0 : Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
		};
	};

	/* Bootstrap style pagination control */
	$.extend( $.fn.dataTableExt.oPagination, {
		"bootstrap": {
			"fnInit": function( oSettings, nPaging, fnDraw ) {
				var oLang = oSettings.oLanguage.oPaginate;
				var fnClickHandler = function ( e ) {
					e.preventDefault();
					if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
						fnDraw( oSettings );
					}
				};

				$(nPaging).append(
					'<ul class="pagination">'+
						'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
						'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
					'</ul>'
				);
				var els = $('a', nPaging);
				$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
				$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
			},

			"fnUpdate": function ( oSettings, fnDraw ) {
				var iListLength = 5;
				var oPaging = oSettings.oInstance.fnPagingInfo();
				var an = oSettings.aanFeatures.p;
				var i, ien, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

				if ( oPaging.iTotalPages < iListLength) {
					iStart = 1;
					iEnd = oPaging.iTotalPages;
				}
				else if ( oPaging.iPage <= iHalf ) {
					iStart = 1;
					iEnd = iListLength;
				} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
					iStart = oPaging.iTotalPages - iListLength + 1;
					iEnd = oPaging.iTotalPages;
				} else {
					iStart = oPaging.iPage - iHalf + 1;
					iEnd = iStart + iListLength - 1;
				}

				for ( i=0, ien=an.length ; i<ien ; i++ ) {
					// Remove the middle elements
					$('li:gt(0)', an[i]).filter(':not(:last)').remove();

					// Add the new list items and their event handlers
					for ( j=iStart ; j<=iEnd ; j++ ) {
						sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
						$('<li '+sClass+'><a href="#">'+j+'</a></li>')
							.insertBefore( $('li:last', an[i])[0] )
							.bind('click', function (e) {
								e.preventDefault();
								oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
								fnDraw( oSettings );
							} );
					}

					// Add / remove disabled classes from the static elements
					if ( oPaging.iPage === 0 ) {
						$('li:first', an[i]).addClass('disabled');
					} else {
						$('li:first', an[i]).removeClass('disabled');
					}

					if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
						$('li:last', an[i]).addClass('disabled');
					} else {
						$('li:last', an[i]).removeClass('disabled');
					}
				}
			}
		}
	} );
}


/*
 * TableTools Bootstrap compatibility
 * Required TableTools 2.1+
 */
if ( $.fn.DataTable.TableTools ) {
	// Set the classes that TableTools uses to something suitable for Bootstrap
	$.extend( true, $.fn.DataTable.TableTools.classes, {
		"container": "DTTT btn-group",
		"buttons": {
			"normal": "btn btn-default",
			"disabled": "disabled"
		},
		"collection": {
			"container": "DTTT_dropdown dropdown-menu",
			"buttons": {
				"normal": "",
				"disabled": "disabled"
			}
		},
		"print": {
			"info": "DTTT_print_info modal"
		},
		"select": {
			"row": "active"
		}
	} );

	// Have the collection use a bootstrap compatible dropdown
	$.extend( true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
		"collection": {
			"container": "ul",
			"button": "li",
			"liner": "a"
		}
	} );
}

/*!
 FixedHeader 2.1.1
 Â©2010-2014 SpryMedia Ltd - datatables.net/license
*/
var FixedHeader;
(function(j,k,h){var l=function(e){FixedHeader=function(a,b){if(!this instanceof FixedHeader)alert("FixedHeader warning: FixedHeader must be initialised with the 'new' keyword.");else{var c={aoCache:[],oSides:{top:!0,bottom:!1,left:0,right:0},oZIndexes:{top:104,bottom:103,left:102,right:101},oCloneOnDraw:{top:!1,bottom:!1,left:!0,right:!0},oMes:{iTableWidth:0,iTableHeight:0,iTableLeft:0,iTableRight:0,iTableTop:0,iTableBottom:0},oOffset:{top:0},nTable:null,bFooter:!1,bInitComplete:!1};this.fnGetSettings=
function(){return c};this.fnUpdate=function(){this._fnUpdateClones();this._fnUpdatePositions()};this.fnPosition=function(){this._fnUpdatePositions()};var d=e.fn.dataTable.Api?(new e.fn.dataTable.Api(a)).settings()[0]:a.fnSettings();d._oPluginFixedHeader=this;this.fnInit(d,b)}};FixedHeader.prototype={fnInit:function(a,b){var c=this.fnGetSettings(),d=this;this.fnInitSettings(c,b);""!==a.oScroll.sX||""!==a.oScroll.sY?alert("FixedHeader 2 is not supported with DataTables' scrolling mode at this time"):
(c.nTable=a.nTable,a.aoDrawCallback.unshift({fn:function(){FixedHeader.fnMeasure();d._fnUpdateClones.call(d);d._fnUpdatePositions.call(d)},sName:"FixedHeader"}),c.bFooter=0<e(">tfoot",c.nTable).length?!0:!1,c.oSides.top&&c.aoCache.push(d._fnCloneTable("fixedHeader","FixedHeader_Header",d._fnCloneThead)),c.oSides.bottom&&c.aoCache.push(d._fnCloneTable("fixedFooter","FixedHeader_Footer",d._fnCloneTfoot)),c.oSides.left&&c.aoCache.push(d._fnCloneTable("fixedLeft","FixedHeader_Left",d._fnCloneTLeft,c.oSides.left)),
c.oSides.right&&c.aoCache.push(d._fnCloneTable("fixedRight","FixedHeader_Right",d._fnCloneTRight,c.oSides.right)),FixedHeader.afnScroll.push(function(){d._fnUpdatePositions.call(d)}),e(j).resize(function(){FixedHeader.fnMeasure();d._fnUpdateClones.call(d);d._fnUpdatePositions.call(d)}),e(c.nTable).on("column-reorder.dt",function(){FixedHeader.fnMeasure();d._fnUpdateClones(!0);d._fnUpdatePositions()}).on("column-visibility.dt",function(){FixedHeader.fnMeasure();d._fnUpdateClones(!0);d._fnUpdatePositions()}),
FixedHeader.fnMeasure(),d._fnUpdateClones(),d._fnUpdatePositions(),c.bInitComplete=!0)},fnInitSettings:function(a,b){if(b!==h&&(b.top!==h&&(a.oSides.top=b.top),b.bottom!==h&&(a.oSides.bottom=b.bottom),"boolean"==typeof b.left?a.oSides.left=b.left?1:0:b.left!==h&&(a.oSides.left=b.left),"boolean"==typeof b.right?a.oSides.right=b.right?1:0:b.right!==h&&(a.oSides.right=b.right),b.zTop!==h&&(a.oZIndexes.top=b.zTop),b.zBottom!==h&&(a.oZIndexes.bottom=b.zBottom),b.zLeft!==h&&(a.oZIndexes.left=b.zLeft),b.zRight!==
h&&(a.oZIndexes.right=b.zRight),b.offsetTop!==h&&(a.oOffset.top=b.offsetTop),b.alwaysCloneTop!==h&&(a.oCloneOnDraw.top=b.alwaysCloneTop),b.alwaysCloneBottom!==h&&(a.oCloneOnDraw.bottom=b.alwaysCloneBottom),b.alwaysCloneLeft!==h&&(a.oCloneOnDraw.left=b.alwaysCloneLeft),b.alwaysCloneRight!==h))a.oCloneOnDraw.right=b.alwaysCloneRight},_fnCloneTable:function(a,b,c,d){var f=this.fnGetSettings(),g;"absolute"!=e(f.nTable.parentNode).css("position")&&(f.nTable.parentNode.style.position="relative");g=f.nTable.cloneNode(!1);
g.removeAttribute("id");var i=k.createElement("div");i.style.position="absolute";i.style.top="0px";i.style.left="0px";i.className+=" FixedHeader_Cloned "+a+" "+b;"fixedHeader"==a&&(i.style.zIndex=f.oZIndexes.top);"fixedFooter"==a&&(i.style.zIndex=f.oZIndexes.bottom);"fixedLeft"==a?i.style.zIndex=f.oZIndexes.left:"fixedRight"==a&&(i.style.zIndex=f.oZIndexes.right);g.style.margin="0";i.appendChild(g);k.body.appendChild(i);return{nNode:g,nWrapper:i,sType:a,sPosition:"",sTop:"",sLeft:"",fnClone:c,iCells:d}},
_fnMeasure:function(){var a=this.fnGetSettings(),b=a.oMes,c=e(a.nTable),d=c.offset(),f=this._fnSumScroll(a.nTable.parentNode,"scrollTop");this._fnSumScroll(a.nTable.parentNode,"scrollLeft");b.iTableWidth=c.outerWidth();b.iTableHeight=c.outerHeight();b.iTableLeft=d.left+a.nTable.parentNode.scrollLeft;b.iTableTop=d.top+f;b.iTableRight=b.iTableLeft+b.iTableWidth;b.iTableRight=FixedHeader.oDoc.iWidth-b.iTableLeft-b.iTableWidth;b.iTableBottom=FixedHeader.oDoc.iHeight-b.iTableTop-b.iTableHeight},_fnSumScroll:function(a,
b){for(var c=a[b];(a=a.parentNode)&&!("HTML"==a.nodeName||"BODY"==a.nodeName);)c=a[b];return c},_fnUpdatePositions:function(){var a=this.fnGetSettings();this._fnMeasure();for(var b=0,c=a.aoCache.length;b<c;b++)"fixedHeader"==a.aoCache[b].sType?this._fnScrollFixedHeader(a.aoCache[b]):"fixedFooter"==a.aoCache[b].sType?this._fnScrollFixedFooter(a.aoCache[b]):"fixedLeft"==a.aoCache[b].sType?this._fnScrollHorizontalLeft(a.aoCache[b]):this._fnScrollHorizontalRight(a.aoCache[b])},_fnUpdateClones:function(a){var b=
this.fnGetSettings();a&&(b.bInitComplete=!1);for(var c=0,d=b.aoCache.length;c<d;c++)b.aoCache[c].fnClone.call(this,b.aoCache[c]);a&&(b.bInitComplete=!0)},_fnScrollHorizontalRight:function(a){var b=this.fnGetSettings().oMes,c=FixedHeader.oWin,d=FixedHeader.oDoc,f=a.nWrapper,g=e(f).outerWidth();c.iScrollRight<b.iTableRight?(this._fnUpdateCache(a,"sPosition","absolute","position",f.style),this._fnUpdateCache(a,"sTop",b.iTableTop+"px","top",f.style),this._fnUpdateCache(a,"sLeft",b.iTableLeft+b.iTableWidth-
g+"px","left",f.style)):b.iTableLeft<d.iWidth-c.iScrollRight-g?(this._fnUpdateCache(a,"sPosition","fixed","position",f.style),this._fnUpdateCache(a,"sTop",b.iTableTop-c.iScrollTop+"px","top",f.style),this._fnUpdateCache(a,"sLeft",c.iWidth-g+"px","left",f.style)):(this._fnUpdateCache(a,"sPosition","absolute","position",f.style),this._fnUpdateCache(a,"sTop",b.iTableTop+"px","top",f.style),this._fnUpdateCache(a,"sLeft",b.iTableLeft+"px","left",f.style))},_fnScrollHorizontalLeft:function(a){var b=this.fnGetSettings().oMes,
c=FixedHeader.oWin,d=a.nWrapper,f=e(d).outerWidth();c.iScrollLeft<b.iTableLeft?(this._fnUpdateCache(a,"sPosition","absolute","position",d.style),this._fnUpdateCache(a,"sTop",b.iTableTop+"px","top",d.style),this._fnUpdateCache(a,"sLeft",b.iTableLeft+"px","left",d.style)):c.iScrollLeft<b.iTableLeft+b.iTableWidth-f?(this._fnUpdateCache(a,"sPosition","fixed","position",d.style),this._fnUpdateCache(a,"sTop",b.iTableTop-c.iScrollTop+"px","top",d.style),this._fnUpdateCache(a,"sLeft","0px","left",d.style)):
(this._fnUpdateCache(a,"sPosition","absolute","position",d.style),this._fnUpdateCache(a,"sTop",b.iTableTop+"px","top",d.style),this._fnUpdateCache(a,"sLeft",b.iTableLeft+b.iTableWidth-f+"px","left",d.style))},_fnScrollFixedFooter:function(a){var b=this.fnGetSettings(),c=b.oMes,d=FixedHeader.oWin,f=a.nWrapper,b=e("thead",b.nTable).outerHeight(),g=e(f).outerHeight();d.iScrollBottom<c.iTableBottom?(this._fnUpdateCache(a,"sPosition","absolute","position",f.style),this._fnUpdateCache(a,"sTop",c.iTableTop+
c.iTableHeight-g+"px","top",f.style),this._fnUpdateCache(a,"sLeft",c.iTableLeft+"px","left",f.style)):d.iScrollBottom<c.iTableBottom+c.iTableHeight-g-b?(this._fnUpdateCache(a,"sPosition","fixed","position",f.style),this._fnUpdateCache(a,"sTop",d.iHeight-g+"px","top",f.style),this._fnUpdateCache(a,"sLeft",c.iTableLeft-d.iScrollLeft+"px","left",f.style)):(this._fnUpdateCache(a,"sPosition","absolute","position",f.style),this._fnUpdateCache(a,"sTop",c.iTableTop+g+"px","top",f.style),this._fnUpdateCache(a,
"sLeft",c.iTableLeft+"px","left",f.style))},_fnScrollFixedHeader:function(a){for(var b=this.fnGetSettings(),c=b.oMes,d=FixedHeader.oWin,e=a.nWrapper,g=0,i=b.nTable.getElementsByTagName("tbody"),h=0;h<i.length;++h)g+=i[h].offsetHeight;c.iTableTop>d.iScrollTop+b.oOffset.top?(this._fnUpdateCache(a,"sPosition","absolute","position",e.style),this._fnUpdateCache(a,"sTop",c.iTableTop+"px","top",e.style),this._fnUpdateCache(a,"sLeft",c.iTableLeft+"px","left",e.style)):d.iScrollTop+b.oOffset.top>c.iTableTop+
g?(this._fnUpdateCache(a,"sPosition","absolute","position",e.style),this._fnUpdateCache(a,"sTop",c.iTableTop+g+"px","top",e.style),this._fnUpdateCache(a,"sLeft",c.iTableLeft+"px","left",e.style)):(this._fnUpdateCache(a,"sPosition","fixed","position",e.style),this._fnUpdateCache(a,"sTop",b.oOffset.top+"px","top",e.style),this._fnUpdateCache(a,"sLeft",c.iTableLeft-d.iScrollLeft+"px","left",e.style))},_fnUpdateCache:function(a,b,c,d,e){a[b]!=c&&(e[d]=c,a[b]=c)},_fnClassUpdate:function(a,b){var c=this;
if("TR"===a.nodeName.toUpperCase()||"TH"===a.nodeName.toUpperCase()||"TD"===a.nodeName.toUpperCase()||"SPAN"===a.nodeName.toUpperCase())b.className=a.className;e(a).children().each(function(d){c._fnClassUpdate(e(a).children()[d],e(b).children()[d])})},_fnCloneThead:function(a){var b=this.fnGetSettings(),c=a.nNode;if(b.bInitComplete&&!b.oCloneOnDraw.top)this._fnClassUpdate(e("thead",b.nTable)[0],e("thead",c)[0]);else{var d=e(b.nTable).outerWidth();a.nWrapper.style.width=d+"px";for(c.style.width=d+
"px";0<c.childNodes.length;)e("thead th",c).unbind("click"),c.removeChild(c.childNodes[0]);a=e("thead",b.nTable).clone(!0)[0];c.appendChild(a);var f=[],g=[];e("thead>tr th",b.nTable).each(function(){f.push(e(this).width())});e("thead>tr td",b.nTable).each(function(){g.push(e(this).width())});e("thead>tr th",b.nTable).each(function(a){e("thead>tr th:eq("+a+")",c).width(f[a]);e(this).width(f[a])});e("thead>tr td",b.nTable).each(function(a){e("thead>tr td:eq("+a+")",c).width(g[a]);e(this).width(g[a])});
e("th.sorting, th.sorting_desc, th.sorting_asc",c).bind("click",function(){this.blur()})}},_fnCloneTfoot:function(a){var b=this.fnGetSettings(),c=a.nNode;for(a.nWrapper.style.width=e(b.nTable).outerWidth()+"px";0<c.childNodes.length;)c.removeChild(c.childNodes[0]);a=e("tfoot",b.nTable).clone(!0)[0];c.appendChild(a);e("tfoot:eq(0)>tr th",b.nTable).each(function(a){e("tfoot:eq(0)>tr th:eq("+a+")",c).width(e(this).width())});e("tfoot:eq(0)>tr td",b.nTable).each(function(a){e("tfoot:eq(0)>tr td:eq("+
a+")",c).width(e(this).width())})},_fnCloneTLeft:function(a){for(var b=this.fnGetSettings(),c=a.nNode,d=e("tbody",b.nTable)[0];0<c.childNodes.length;)c.removeChild(c.childNodes[0]);c.appendChild(e("thead",b.nTable).clone(!0)[0]);c.appendChild(e("tbody",b.nTable).clone(!0)[0]);b.bFooter&&c.appendChild(e("tfoot",b.nTable).clone(!0)[0]);var f="gt("+(a.iCells-1)+")";e("thead tr",c).each(function(){e("th:"+f,this).remove()});e("tfoot tr",c).each(function(){e("th:"+f,this).remove()});e("tbody tr",c).each(function(){e("td:"+
f,this).remove()});this.fnEqualiseHeights("thead",d.parentNode,c);this.fnEqualiseHeights("tbody",d.parentNode,c);this.fnEqualiseHeights("tfoot",d.parentNode,c);for(var g=d=0;g<a.iCells;g++)d+=e("thead tr th:eq("+g+")",b.nTable).outerWidth();c.style.width=d+"px";a.nWrapper.style.width=d+"px"},_fnCloneTRight:function(a){for(var b=this.fnGetSettings(),c=e("tbody",b.nTable)[0],d=a.nNode,f=e("tbody tr:eq(0) td",b.nTable).length;0<d.childNodes.length;)d.removeChild(d.childNodes[0]);d.appendChild(e("thead",
b.nTable).clone(!0)[0]);d.appendChild(e("tbody",b.nTable).clone(!0)[0]);b.bFooter&&d.appendChild(e("tfoot",b.nTable).clone(!0)[0]);e("thead tr th:lt("+(f-a.iCells)+")",d).remove();e("tfoot tr th:lt("+(f-a.iCells)+")",d).remove();e("tbody tr",d).each(function(){e("td:lt("+(f-a.iCells)+")",this).remove()});this.fnEqualiseHeights("thead",c.parentNode,d);this.fnEqualiseHeights("tbody",c.parentNode,d);this.fnEqualiseHeights("tfoot",c.parentNode,d);for(var g=c=0;g<a.iCells;g++)c+=e("thead tr th:eq("+(f-
1-g)+")",b.nTable).outerWidth();d.style.width=c+"px";a.nWrapper.style.width=c+"px"},fnEqualiseHeights:function(a,b,c){var d=e(a+" tr",b),f;e(a+" tr",c).each(function(a){f=d.eq(a).css("height");"Microsoft Internet Explorer"==navigator.appName&&(f=parseInt(f,10)+1);e(this).css("height",f);d.eq(a).css("height",f)})}};FixedHeader.oWin={iScrollTop:0,iScrollRight:0,iScrollBottom:0,iScrollLeft:0,iHeight:0,iWidth:0};FixedHeader.oDoc={iHeight:0,iWidth:0};FixedHeader.afnScroll=[];FixedHeader.fnMeasure=function(){var a=
e(j),b=e(k),c=FixedHeader.oWin,d=FixedHeader.oDoc;d.iHeight=b.height();d.iWidth=b.width();c.iHeight=a.height();c.iWidth=a.width();c.iScrollTop=a.scrollTop();c.iScrollLeft=a.scrollLeft();c.iScrollRight=d.iWidth-c.iScrollLeft-c.iWidth;c.iScrollBottom=d.iHeight-c.iScrollTop-c.iHeight};FixedHeader.version="2.1.1";e(j).scroll(function(){FixedHeader.fnMeasure();for(var a=0,b=FixedHeader.afnScroll.length;a<b;a++)FixedHeader.afnScroll[a]()});e.fn.dataTable.FixedHeader=FixedHeader;return e.fn.DataTable.FixedHeader=
FixedHeader};"function"===typeof define&&define.amd?define("datatables-fixedheader",["jquery","datatables"],l):jQuery&&!jQuery.fn.dataTable.FixedHeader&&l(jQuery,jQuery.fn.dataTable)})(window,document);

/*!
 TableTools 2.2.1
 2009-2014 SpryMedia Ltd - datatables.net/license

 ZeroClipboard 1.0.4
 Author: Joseph Huckaby - MIT licensed
*/
var TableTools;
(function(m,k,p){var r=function(n){var g={version:"1.0.4-TableTools2",clients:{},moviePath:"",nextId:1,$:function(a){"string"==typeof a&&(a=k.getElementById(a));a.addClass||(a.hide=function(){this.style.display="none"},a.show=function(){this.style.display=""},a.addClass=function(a){this.removeClass(a);this.className+=" "+a},a.removeClass=function(a){this.className=this.className.replace(RegExp("\\s*"+a+"\\s*")," ").replace(/^\s+/,"").replace(/\s+$/,"")},a.hasClass=function(a){return!!this.className.match(RegExp("\\s*"+a+
"\\s*"))});return a},setMoviePath:function(a){this.moviePath=a},dispatch:function(a,b,c){(a=this.clients[a])&&a.receiveEvent(b,c)},register:function(a,b){this.clients[a]=b},getDOMObjectPosition:function(a){var b={left:0,top:0,width:a.width?a.width:a.offsetWidth,height:a.height?a.height:a.offsetHeight};""!==a.style.width&&(b.width=a.style.width.replace("px",""));""!==a.style.height&&(b.height=a.style.height.replace("px",""));for(;a;)b.left+=a.offsetLeft,b.top+=a.offsetTop,a=a.offsetParent;return b},
Client:function(a){this.handlers={};this.id=g.nextId++;this.movieId="ZeroClipboard_TableToolsMovie_"+this.id;g.register(this.id,this);a&&this.glue(a)}};g.Client.prototype={id:0,ready:!1,movie:null,clipText:"",fileName:"",action:"copy",handCursorEnabled:!0,cssEffects:!0,handlers:null,sized:!1,glue:function(a,b){this.domElement=g.$(a);var c=99;this.domElement.style.zIndex&&(c=parseInt(this.domElement.style.zIndex,10)+1);var d=g.getDOMObjectPosition(this.domElement);this.div=k.createElement("div");var f=
this.div.style;f.position="absolute";f.left="0px";f.top="0px";f.width=d.width+"px";f.height=d.height+"px";f.zIndex=c;"undefined"!=typeof b&&""!==b&&(this.div.title=b);0!==d.width&&0!==d.height&&(this.sized=!0);this.domElement&&(this.domElement.appendChild(this.div),this.div.innerHTML=this.getHTML(d.width,d.height).replace(/&/g,"&amp;"))},positionElement:function(){var a=g.getDOMObjectPosition(this.domElement),b=this.div.style;b.position="absolute";b.width=a.width+"px";b.height=a.height+"px";0!==a.width&&
0!==a.height&&(this.sized=!0,b=this.div.childNodes[0],b.width=a.width,b.height=a.height)},getHTML:function(a,b){var c="",d="id="+this.id+"&width="+a+"&height="+b;if(navigator.userAgent.match(/MSIE/))var f=location.href.match(/^https/i)?"https://":"http://",c=c+('<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="'+f+'download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="'+a+'" height="'+b+'" id="'+this.movieId+'" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="'+
g.moviePath+'" /><param name="loop" value="false" /><param name="menu" value="false" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" /><param name="flashvars" value="'+d+'"/><param name="wmode" value="transparent"/></object>');else c+='<embed id="'+this.movieId+'" src="'+g.moviePath+'" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="'+a+'" height="'+b+'" name="'+this.movieId+'" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="'+
d+'" wmode="transparent" />';return c},hide:function(){this.div&&(this.div.style.left="-2000px")},show:function(){this.reposition()},destroy:function(){if(this.domElement&&this.div){this.hide();this.div.innerHTML="";var a=k.getElementsByTagName("body")[0];try{a.removeChild(this.div)}catch(b){}this.div=this.domElement=null}},reposition:function(a){a&&((this.domElement=g.$(a))||this.hide());if(this.domElement&&this.div){var a=g.getDOMObjectPosition(this.domElement),b=this.div.style;b.left=""+a.left+
"px";b.top=""+a.top+"px"}},clearText:function(){this.clipText="";this.ready&&this.movie.clearText()},appendText:function(a){this.clipText+=a;this.ready&&this.movie.appendText(a)},setText:function(a){this.clipText=a;this.ready&&this.movie.setText(a)},setCharSet:function(a){this.charSet=a;this.ready&&this.movie.setCharSet(a)},setBomInc:function(a){this.incBom=a;this.ready&&this.movie.setBomInc(a)},setFileName:function(a){this.fileName=a;this.ready&&this.movie.setFileName(a)},setAction:function(a){this.action=
a;this.ready&&this.movie.setAction(a)},addEventListener:function(a,b){a=a.toString().toLowerCase().replace(/^on/,"");this.handlers[a]||(this.handlers[a]=[]);this.handlers[a].push(b)},setHandCursor:function(a){this.handCursorEnabled=a;this.ready&&this.movie.setHandCursor(a)},setCSSEffects:function(a){this.cssEffects=!!a},receiveEvent:function(a,b){var c,a=a.toString().toLowerCase().replace(/^on/,"");switch(a){case "load":this.movie=k.getElementById(this.movieId);if(!this.movie){c=this;setTimeout(function(){c.receiveEvent("load",
null)},1);return}if(!this.ready&&navigator.userAgent.match(/Firefox/)&&navigator.userAgent.match(/Windows/)){c=this;setTimeout(function(){c.receiveEvent("load",null)},100);this.ready=!0;return}this.ready=!0;this.movie.clearText();this.movie.appendText(this.clipText);this.movie.setFileName(this.fileName);this.movie.setAction(this.action);this.movie.setCharSet(this.charSet);this.movie.setBomInc(this.incBom);this.movie.setHandCursor(this.handCursorEnabled);break;case "mouseover":this.domElement&&this.cssEffects&&
this.recoverActive&&this.domElement.addClass("active");break;case "mouseout":this.domElement&&this.cssEffects&&(this.recoverActive=!1,this.domElement.hasClass("active")&&(this.domElement.removeClass("active"),this.recoverActive=!0));break;case "mousedown":this.domElement&&this.cssEffects&&this.domElement.addClass("active");break;case "mouseup":this.domElement&&this.cssEffects&&(this.domElement.removeClass("active"),this.recoverActive=!1)}if(this.handlers[a])for(var d=0,f=this.handlers[a].length;d<
f;d++){var e=this.handlers[a][d];if("function"==typeof e)e(this,b);else if("object"==typeof e&&2==e.length)e[0][e[1]](this,b);else if("string"==typeof e)m[e](this,b)}}};m.ZeroClipboard_TableTools=g;var e=jQuery;TableTools=function(a,b){!this instanceof TableTools&&alert("Warning: TableTools must be initialised with the keyword 'new'");this.s={that:this,dt:e.fn.dataTable.Api?(new e.fn.dataTable.Api(a)).settings()[0]:a.fnSettings(),print:{saveStart:-1,saveLength:-1,saveScroll:-1,funcEnd:function(){}},
buttonCounter:0,select:{type:"",selected:[],preRowSelect:null,postSelected:null,postDeselected:null,all:!1,selectedClass:""},custom:{},swfPath:"",buttonSet:[],master:!1,tags:{}};this.dom={container:null,table:null,print:{hidden:[],message:null},collection:{collection:null,background:null}};this.classes=e.extend(!0,{},TableTools.classes);this.s.dt.bJUI&&e.extend(!0,this.classes,TableTools.classes_themeroller);this.fnSettings=function(){return this.s};"undefined"==typeof b&&(b={});this._fnConstruct(b);
return this};TableTools.prototype={fnGetSelected:function(a){var b=[],c=this.s.dt.aoData,d=this.s.dt.aiDisplay,f;if(a){a=0;for(f=d.length;a<f;a++)c[d[a]]._DTTT_selected&&b.push(c[d[a]].nTr)}else{a=0;for(f=c.length;a<f;a++)c[a]._DTTT_selected&&b.push(c[a].nTr)}return b},fnGetSelectedData:function(){var a=[],b=this.s.dt.aoData,c,d;c=0;for(d=b.length;c<d;c++)b[c]._DTTT_selected&&a.push(this.s.dt.oInstance.fnGetData(c));return a},fnIsSelected:function(a){a=this.s.dt.oInstance.fnGetPosition(a);return!0===
this.s.dt.aoData[a]._DTTT_selected?!0:!1},fnSelectAll:function(a){var b=this._fnGetMasterSettings();this._fnRowSelect(!0===a?b.dt.aiDisplay:b.dt.aoData)},fnSelectNone:function(a){this._fnGetMasterSettings();this._fnRowDeselect(this.fnGetSelected(a))},fnSelect:function(a){"single"==this.s.select.type&&this.fnSelectNone();this._fnRowSelect(a)},fnDeselect:function(a){this._fnRowDeselect(a)},fnGetTitle:function(a){var b="";"undefined"!=typeof a.sTitle&&""!==a.sTitle?b=a.sTitle:(a=k.getElementsByTagName("title"),
0<a.length&&(b=a[0].innerHTML));return 4>"Â¡".toString().length?b.replace(/[^a-zA-Z0-9_\u00A1-\uFFFF\.,\-_ !\(\)]/g,""):b.replace(/[^a-zA-Z0-9_\.,\-_ !\(\)]/g,"")},fnCalcColRatios:function(a){var b=this.s.dt.aoColumns,a=this._fnColumnTargets(a.mColumns),c=[],d=0,f=0,e,j;e=0;for(j=a.length;e<j;e++)a[e]&&(d=b[e].nTh.offsetWidth,f+=d,c.push(d));e=0;for(j=c.length;e<j;e++)c[e]/=f;return c.join("\t")},fnGetTableData:function(a){if(this.s.dt)return this._fnGetDataTablesData(a)},fnSetText:function(a,b){this._fnFlashSetText(a,
b)},fnResizeButtons:function(){for(var a in g.clients)if(a){var b=g.clients[a];"undefined"!=typeof b.domElement&&b.domElement.parentNode&&b.positionElement()}},fnResizeRequired:function(){for(var a in g.clients)if(a){var b=g.clients[a];if("undefined"!=typeof b.domElement&&b.domElement.parentNode==this.dom.container&&!1===b.sized)return!0}return!1},fnPrint:function(a,b){b===p&&(b={});a===p||a?this._fnPrintStart(b):this._fnPrintEnd()},fnInfo:function(a,b){var c=e("<div/>").addClass(this.classes.print.info).html(a).appendTo("body");
setTimeout(function(){c.fadeOut("normal",function(){c.remove()})},b)},fnContainer:function(){return this.dom.container},_fnConstruct:function(a){var b=this;this._fnCustomiseSettings(a);this.dom.container=k.createElement(this.s.tags.container);this.dom.container.className=this.classes.container;"none"!=this.s.select.type&&this._fnRowSelectConfig();this._fnButtonDefinations(this.s.buttonSet,this.dom.container);this.s.dt.aoDestroyCallback.push({sName:"TableTools",fn:function(){e(b.s.dt.nTBody).off("click.DTTT_Select",
"tr");e(b.dom.container).empty();var a=e.inArray(b,TableTools._aInstances);-1!==a&&TableTools._aInstances.splice(a,1)}})},_fnCustomiseSettings:function(a){"undefined"==typeof this.s.dt._TableToolsInit&&(this.s.master=!0,this.s.dt._TableToolsInit=!0);this.dom.table=this.s.dt.nTable;this.s.custom=e.extend({},TableTools.DEFAULTS,a);this.s.swfPath=this.s.custom.sSwfPath;"undefined"!=typeof g&&(g.moviePath=this.s.swfPath);this.s.select.type=this.s.custom.sRowSelect;this.s.select.preRowSelect=this.s.custom.fnPreRowSelect;
this.s.select.postSelected=this.s.custom.fnRowSelected;this.s.select.postDeselected=this.s.custom.fnRowDeselected;this.s.custom.sSelectedClass&&(this.classes.select.row=this.s.custom.sSelectedClass);this.s.tags=this.s.custom.oTags;this.s.buttonSet=this.s.custom.aButtons},_fnButtonDefinations:function(a,b){for(var c,d=0,f=a.length;d<f;d++){if("string"==typeof a[d]){if("undefined"==typeof TableTools.BUTTONS[a[d]]){alert("TableTools: Warning - unknown button type: "+a[d]);continue}c=e.extend({},TableTools.BUTTONS[a[d]],
!0)}else{if("undefined"==typeof TableTools.BUTTONS[a[d].sExtends]){alert("TableTools: Warning - unknown button type: "+a[d].sExtends);continue}c=e.extend({},TableTools.BUTTONS[a[d].sExtends],!0);c=e.extend(c,a[d],!0)}b.appendChild(this._fnCreateButton(c,e(b).hasClass(this.classes.collection.container)))}},_fnCreateButton:function(a,b){var c=this._fnButtonBase(a,b);a.sAction.match(/flash/)?this._fnFlashConfig(c,a):"text"==a.sAction?this._fnTextConfig(c,a):"div"==a.sAction?this._fnTextConfig(c,a):"collection"==
a.sAction&&(this._fnTextConfig(c,a),this._fnCollectionConfig(c,a));return c},_fnButtonBase:function(a,b){var c,d,f;b?(c=a.sTag&&"default"!==a.sTag?a.sTag:this.s.tags.collection.button,d=a.sLinerTag&&"default"!==a.sLinerTag?a.sLiner:this.s.tags.collection.liner,f=this.classes.collection.buttons.normal):(c=a.sTag&&"default"!==a.sTag?a.sTag:this.s.tags.button,d=a.sLinerTag&&"default"!==a.sLinerTag?a.sLiner:this.s.tags.liner,f=this.classes.buttons.normal);c=k.createElement(c);d=k.createElement(d);var e=
this._fnGetMasterSettings();c.className=f+" "+a.sButtonClass;c.setAttribute("id","ToolTables_"+this.s.dt.sInstance+"_"+e.buttonCounter);c.appendChild(d);d.innerHTML=a.sButtonText;e.buttonCounter++;return c},_fnGetMasterSettings:function(){if(this.s.master)return this.s;for(var a=TableTools._aInstances,b=0,c=a.length;b<c;b++)if(this.dom.table==a[b].s.dt.nTable)return a[b].s},_fnCollectionConfig:function(a,b){var c=k.createElement(this.s.tags.collection.container);c.style.display="none";c.className=
this.classes.collection.container;b._collection=c;k.body.appendChild(c);this._fnButtonDefinations(b.aButtons,c)},_fnCollectionShow:function(a,b){var c=this,d=e(a).offset(),f=b._collection,i=d.left,d=d.top+e(a).outerHeight(),j=e(m).height(),h=e(k).height(),o=e(m).width(),g=e(k).width();f.style.position="absolute";f.style.left=i+"px";f.style.top=d+"px";f.style.display="block";e(f).css("opacity",0);var l=k.createElement("div");l.style.position="absolute";l.style.left="0px";l.style.top="0px";l.style.height=
(j>h?j:h)+"px";l.style.width=(o>g?o:g)+"px";l.className=this.classes.collection.background;e(l).css("opacity",0);k.body.appendChild(l);k.body.appendChild(f);j=e(f).outerWidth();o=e(f).outerHeight();i+j>g&&(f.style.left=g-j+"px");d+o>h&&(f.style.top=d-o-e(a).outerHeight()+"px");this.dom.collection.collection=f;this.dom.collection.background=l;setTimeout(function(){e(f).animate({opacity:1},500);e(l).animate({opacity:0.25},500)},10);this.fnResizeButtons();e(l).click(function(){c._fnCollectionHide.call(c,
null,null)})},_fnCollectionHide:function(a,b){!(null!==b&&"collection"==b.sExtends)&&null!==this.dom.collection.collection&&(e(this.dom.collection.collection).animate({opacity:0},500,function(){this.style.display="none"}),e(this.dom.collection.background).animate({opacity:0},500,function(){this.parentNode.removeChild(this)}),this.dom.collection.collection=null,this.dom.collection.background=null)},_fnRowSelectConfig:function(){if(this.s.master){var a=this,b=this.s.dt;e(b.nTable).addClass(this.classes.select.table);
"os"===this.s.select.type&&(e(b.nTBody).on("mousedown.DTTT_Select","tr",function(a){if(a.shiftKey)e(b.nTBody).css("-moz-user-select","none").one("selectstart.DTTT_Select","tr",function(){return!1})}),e(b.nTBody).on("mouseup.DTTT_Select","tr",function(){e(b.nTBody).css("-moz-user-select","")}));e(b.nTBody).on("click.DTTT_Select",this.s.custom.sRowSelector,function(c){var d=this.nodeName.toLowerCase()==="tr"?this:e(this).parents("tr")[0],f=a.s.select,i=a.s.dt.oInstance.fnGetPosition(d);if(d.parentNode==
b.nTBody&&b.oInstance.fnGetData(d)!==null){if(f.type=="os")if(c.ctrlKey||c.metaKey)a.fnIsSelected(d)?a._fnRowDeselect(d,c):a._fnRowSelect(d,c);else if(c.shiftKey){var j=a.s.dt.aiDisplay.slice(),h=e.inArray(f.lastRow,j),o=e.inArray(i,j);if(a.fnGetSelected().length===0||h===-1)j.splice(e.inArray(i,j)+1,j.length);else{if(h>o)var g=o,o=h,h=g;j.splice(o+1,j.length);j.splice(0,h)}if(a.fnIsSelected(d)){j.splice(e.inArray(i,j),1);a._fnRowDeselect(j,c)}else a._fnRowSelect(j,c)}else if(a.fnIsSelected(d)&&a.fnGetSelected().length===
1)a._fnRowDeselect(d,c);else{a.fnSelectNone();a._fnRowSelect(d,c)}else if(a.fnIsSelected(d))a._fnRowDeselect(d,c);else if(f.type=="single"){a.fnSelectNone();a._fnRowSelect(d,c)}else f.type=="multi"&&a._fnRowSelect(d,c);f.lastRow=i}});b.oApi._fnCallbackReg(b,"aoRowCreatedCallback",function(c,d,f){b.aoData[f]._DTTT_selected&&e(c).addClass(a.classes.select.row)},"TableTools-SelectAll")}},_fnRowSelect:function(a,b){var c=this._fnSelectData(a),d=[],f,i;f=0;for(i=c.length;f<i;f++)c[f].nTr&&d.push(c[f].nTr);
if(null===this.s.select.preRowSelect||this.s.select.preRowSelect.call(this,b,d,!0)){f=0;for(i=c.length;f<i;f++)c[f]._DTTT_selected=!0,c[f].nTr&&e(c[f].nTr).addClass(this.classes.select.row);null!==this.s.select.postSelected&&this.s.select.postSelected.call(this,d);TableTools._fnEventDispatch(this,"select",d,!0)}},_fnRowDeselect:function(a,b){var c=this._fnSelectData(a),d=[],f,i;f=0;for(i=c.length;f<i;f++)c[f].nTr&&d.push(c[f].nTr);if(null===this.s.select.preRowSelect||this.s.select.preRowSelect.call(this,
b,d,!1)){f=0;for(i=c.length;f<i;f++)c[f]._DTTT_selected=!1,c[f].nTr&&e(c[f].nTr).removeClass(this.classes.select.row);null!==this.s.select.postDeselected&&this.s.select.postDeselected.call(this,d);TableTools._fnEventDispatch(this,"select",d,!1)}},_fnSelectData:function(a){var b=[],c,d,f;if(a.nodeName)c=this.s.dt.oInstance.fnGetPosition(a),b.push(this.s.dt.aoData[c]);else if("undefined"!==typeof a.length){d=0;for(f=a.length;d<f;d++)a[d].nodeName?(c=this.s.dt.oInstance.fnGetPosition(a[d]),b.push(this.s.dt.aoData[c])):
"number"===typeof a[d]?b.push(this.s.dt.aoData[a[d]]):b.push(a[d])}else b.push(a);return b},_fnTextConfig:function(a,b){var c=this;null!==b.fnInit&&b.fnInit.call(this,a,b);""!==b.sToolTip&&(a.title=b.sToolTip);e(a).hover(function(){b.fnMouseover!==null&&b.fnMouseover.call(this,a,b,null)},function(){b.fnMouseout!==null&&b.fnMouseout.call(this,a,b,null)});null!==b.fnSelect&&TableTools._fnEventListen(this,"select",function(d){b.fnSelect.call(c,a,b,d)});e(a).click(function(d){b.fnClick!==null&&b.fnClick.call(c,
a,b,null,d);b.fnComplete!==null&&b.fnComplete.call(c,a,b,null,null);c._fnCollectionHide(a,b)})},_fnFlashConfig:function(a,b){var c=this,d=new g.Client;null!==b.fnInit&&b.fnInit.call(this,a,b);d.setHandCursor(!0);"flash_save"==b.sAction?(d.setAction("save"),d.setCharSet("utf16le"==b.sCharSet?"UTF16LE":"UTF8"),d.setBomInc(b.bBomInc),d.setFileName(b.sFileName.replace("*",this.fnGetTitle(b)))):"flash_pdf"==b.sAction?(d.setAction("pdf"),d.setFileName(b.sFileName.replace("*",this.fnGetTitle(b)))):d.setAction("copy");
d.addEventListener("mouseOver",function(){b.fnMouseover!==null&&b.fnMouseover.call(c,a,b,d)});d.addEventListener("mouseOut",function(){b.fnMouseout!==null&&b.fnMouseout.call(c,a,b,d)});d.addEventListener("mouseDown",function(){b.fnClick!==null&&b.fnClick.call(c,a,b,d)});d.addEventListener("complete",function(f,e){b.fnComplete!==null&&b.fnComplete.call(c,a,b,d,e);c._fnCollectionHide(a,b)});this._fnFlashGlue(d,a,b.sToolTip)},_fnFlashGlue:function(a,b,c){var d=this,f=b.getAttribute("id");k.getElementById(f)?
a.glue(b,c):setTimeout(function(){d._fnFlashGlue(a,b,c)},100)},_fnFlashSetText:function(a,b){var c=this._fnChunkData(b,8192);a.clearText();for(var d=0,f=c.length;d<f;d++)a.appendText(c[d])},_fnColumnTargets:function(a){var b=[],c=this.s.dt,d,f;if("object"==typeof a){d=0;for(f=c.aoColumns.length;d<f;d++)b.push(!1);d=0;for(f=a.length;d<f;d++)b[a[d]]=!0}else if("visible"==a){d=0;for(f=c.aoColumns.length;d<f;d++)b.push(c.aoColumns[d].bVisible?!0:!1)}else if("hidden"==a){d=0;for(f=c.aoColumns.length;d<
f;d++)b.push(c.aoColumns[d].bVisible?!1:!0)}else if("sortable"==a){d=0;for(f=c.aoColumns.length;d<f;d++)b.push(c.aoColumns[d].bSortable?!0:!1)}else{d=0;for(f=c.aoColumns.length;d<f;d++)b.push(!0)}return b},_fnNewline:function(a){return"auto"==a.sNewLine?navigator.userAgent.match(/Windows/)?"\r\n":"\n":a.sNewLine},_fnGetDataTablesData:function(a){var b,c,d,f,i,j=[],h="",g=this.s.dt,k,l=RegExp(a.sFieldBoundary,"g"),m=this._fnColumnTargets(a.mColumns),n="undefined"!=typeof a.bSelectedOnly?a.bSelectedOnly:
!1;if(a.bHeader){i=[];b=0;for(c=g.aoColumns.length;b<c;b++)m[b]&&(h=g.aoColumns[b].sTitle.replace(/\n/g," ").replace(/<.*?>/g,"").replace(/^\s+|\s+$/g,""),h=this._fnHtmlDecode(h),i.push(this._fnBoundData(h,a.sFieldBoundary,l)));j.push(i.join(a.sFieldSeperator))}var p=this.fnGetSelected(),n="none"!==this.s.select.type&&n&&0!==p.length,q=g.oInstance.$("tr",a.oSelectorOpts).map(function(a,b){return n&&-1===e.inArray(b,p)?null:g.oInstance.fnGetPosition(b)}).get();d=0;for(f=q.length;d<f;d++){k=g.aoData[q[d]].nTr;
i=[];b=0;for(c=g.aoColumns.length;b<c;b++)m[b]&&(h=g.oApi._fnGetCellData(g,q[d],b,"display"),a.fnCellRender?h=a.fnCellRender(h,b,k,q[d])+"":"string"==typeof h?(h=h.replace(/\n/g," "),h=h.replace(/<img.*?\s+alt\s*=\s*(?:"([^"]+)"|'([^']+)'|([^\s>]+)).*?>/gi,"$1$2$3"),h=h.replace(/<.*?>/g,"")):h+="",h=h.replace(/^\s+/,"").replace(/\s+$/,""),h=this._fnHtmlDecode(h),i.push(this._fnBoundData(h,a.sFieldBoundary,l)));j.push(i.join(a.sFieldSeperator));a.bOpenRows&&(b=e.grep(g.aoOpenRows,function(a){return a.nParent===
k}),1===b.length&&(h=this._fnBoundData(e("td",b[0].nTr).html(),a.sFieldBoundary,l),j.push(h)))}if(a.bFooter&&null!==g.nTFoot){i=[];b=0;for(c=g.aoColumns.length;b<c;b++)m[b]&&null!==g.aoColumns[b].nTf&&(h=g.aoColumns[b].nTf.innerHTML.replace(/\n/g," ").replace(/<.*?>/g,""),h=this._fnHtmlDecode(h),i.push(this._fnBoundData(h,a.sFieldBoundary,l)));j.push(i.join(a.sFieldSeperator))}return j.join(this._fnNewline(a))},_fnBoundData:function(a,b,c){return""===b?a:b+a.replace(c,b+b)+b},_fnChunkData:function(a,
b){for(var c=[],d=a.length,f=0;f<d;f+=b)f+b<d?c.push(a.substring(f,f+b)):c.push(a.substring(f,d));return c},_fnHtmlDecode:function(a){if(-1===a.indexOf("&"))return a;var b=k.createElement("div");return a.replace(/&([^\s]*);/g,function(a,d){if("#"===a.substr(1,1))return String.fromCharCode(Number(d.substr(1)));b.innerHTML=a;return b.childNodes[0].nodeValue})},_fnPrintStart:function(a){var b=this,c=this.s.dt;this._fnPrintHideNodes(c.nTable);this.s.print.saveStart=c._iDisplayStart;this.s.print.saveLength=
c._iDisplayLength;a.bShowAll&&(c._iDisplayStart=0,c._iDisplayLength=-1,c.oApi._fnCalculateEnd&&c.oApi._fnCalculateEnd(c),c.oApi._fnDraw(c));if(""!==c.oScroll.sX||""!==c.oScroll.sY)this._fnPrintScrollStart(c),e(this.s.dt.nTable).bind("draw.DTTT_Print",function(){b._fnPrintScrollStart(c)});var d=c.aanFeatures,f;for(f in d)if("i"!=f&&"t"!=f&&1==f.length)for(var i=0,g=d[f].length;i<g;i++)this.dom.print.hidden.push({node:d[f][i],display:"block"}),d[f][i].style.display="none";e(k.body).addClass(this.classes.print.body);
""!==a.sInfo&&this.fnInfo(a.sInfo,3E3);a.sMessage&&e("<div/>").addClass(this.classes.print.message).html(a.sMessage).prependTo("body");this.s.print.saveScroll=e(m).scrollTop();m.scrollTo(0,0);e(k).bind("keydown.DTTT",function(a){if(a.keyCode==27){a.preventDefault();b._fnPrintEnd.call(b,a)}})},_fnPrintEnd:function(){var a=this.s.dt,b=this.s.print;this._fnPrintShowNodes();if(""!==a.oScroll.sX||""!==a.oScroll.sY)e(this.s.dt.nTable).unbind("draw.DTTT_Print"),this._fnPrintScrollEnd();m.scrollTo(0,b.saveScroll);
e("div."+this.classes.print.message).remove();e(k.body).removeClass("DTTT_Print");a._iDisplayStart=b.saveStart;a._iDisplayLength=b.saveLength;a.oApi._fnCalculateEnd&&a.oApi._fnCalculateEnd(a);a.oApi._fnDraw(a);e(k).unbind("keydown.DTTT")},_fnPrintScrollStart:function(){var a=this.s.dt;a.nScrollHead.getElementsByTagName("div")[0].getElementsByTagName("table");var b=a.nTable.parentNode,c;c=a.nTable.getElementsByTagName("thead");0<c.length&&a.nTable.removeChild(c[0]);null!==a.nTFoot&&(c=a.nTable.getElementsByTagName("tfoot"),
0<c.length&&a.nTable.removeChild(c[0]));c=a.nTHead.cloneNode(!0);a.nTable.insertBefore(c,a.nTable.childNodes[0]);null!==a.nTFoot&&(c=a.nTFoot.cloneNode(!0),a.nTable.insertBefore(c,a.nTable.childNodes[1]));""!==a.oScroll.sX&&(a.nTable.style.width=e(a.nTable).outerWidth()+"px",b.style.width=e(a.nTable).outerWidth()+"px",b.style.overflow="visible");""!==a.oScroll.sY&&(b.style.height=e(a.nTable).outerHeight()+"px",b.style.overflow="visible")},_fnPrintScrollEnd:function(){var a=this.s.dt,b=a.nTable.parentNode;
""!==a.oScroll.sX&&(b.style.width=a.oApi._fnStringToCss(a.oScroll.sX),b.style.overflow="auto");""!==a.oScroll.sY&&(b.style.height=a.oApi._fnStringToCss(a.oScroll.sY),b.style.overflow="auto")},_fnPrintShowNodes:function(){for(var a=this.dom.print.hidden,b=0,c=a.length;b<c;b++)a[b].node.style.display=a[b].display;a.splice(0,a.length)},_fnPrintHideNodes:function(a){for(var b=this.dom.print.hidden,c=a.parentNode,d=c.childNodes,f=0,g=d.length;f<g;f++)if(d[f]!=a&&1==d[f].nodeType){var j=e(d[f]).css("display");
"none"!=j&&(b.push({node:d[f],display:j}),d[f].style.display="none")}"BODY"!=c.nodeName.toUpperCase()&&this._fnPrintHideNodes(c)}};TableTools._aInstances=[];TableTools._aListeners=[];TableTools.fnGetMasters=function(){for(var a=[],b=0,c=TableTools._aInstances.length;b<c;b++)TableTools._aInstances[b].s.master&&a.push(TableTools._aInstances[b]);return a};TableTools.fnGetInstance=function(a){"object"!=typeof a&&(a=k.getElementById(a));for(var b=0,c=TableTools._aInstances.length;b<c;b++)if(TableTools._aInstances[b].s.master&&
TableTools._aInstances[b].dom.table==a)return TableTools._aInstances[b];return null};TableTools._fnEventListen=function(a,b,c){TableTools._aListeners.push({that:a,type:b,fn:c})};TableTools._fnEventDispatch=function(a,b,c,d){for(var f=TableTools._aListeners,e=0,g=f.length;e<g;e++)a.dom.table==f[e].that.dom.table&&f[e].type==b&&f[e].fn(c,d)};TableTools.buttonBase={sAction:"text",sTag:"default",sLinerTag:"default",sButtonClass:"DTTT_button_text",sButtonText:"Button text",sTitle:"",sToolTip:"",sCharSet:"utf8",
bBomInc:!1,sFileName:"*.csv",sFieldBoundary:"",sFieldSeperator:"\t",sNewLine:"auto",mColumns:"all",bHeader:!0,bFooter:!0,bOpenRows:!1,bSelectedOnly:!1,oSelectorOpts:p,fnMouseover:null,fnMouseout:null,fnClick:null,fnSelect:null,fnComplete:null,fnInit:null,fnCellRender:null};TableTools.BUTTONS={csv:e.extend({},TableTools.buttonBase,{sAction:"flash_save",sButtonClass:"DTTT_button_csv",sButtonText:"CSV",sFieldBoundary:'"',sFieldSeperator:",",fnClick:function(a,b,c){this.fnSetText(c,this.fnGetTableData(b))}}),
xls:e.extend({},TableTools.buttonBase,{sAction:"flash_save",sCharSet:"utf16le",bBomInc:!0,sButtonClass:"DTTT_button_xls",sButtonText:"Excel",fnClick:function(a,b,c){this.fnSetText(c,this.fnGetTableData(b))}}),copy:e.extend({},TableTools.buttonBase,{sAction:"flash_copy",sButtonClass:"DTTT_button_copy",sButtonText:"Copy",fnClick:function(a,b,c){this.fnSetText(c,this.fnGetTableData(b))},fnComplete:function(a,b,c,d){a=d.split("\n").length;a=null===this.s.dt.nTFoot?a-1:a-2;this.fnInfo("<h6>Table copied</h6><p>Copied "+
a+" row"+(1==a?"":"s")+" to the clipboard.</p>",1500)}}),pdf:e.extend({},TableTools.buttonBase,{sAction:"flash_pdf",sNewLine:"\n",sFileName:"*.pdf",sButtonClass:"DTTT_button_pdf",sButtonText:"PDF",sPdfOrientation:"portrait",sPdfSize:"A4",sPdfMessage:"",fnClick:function(a,b,c){this.fnSetText(c,"title:"+this.fnGetTitle(b)+"\nmessage:"+b.sPdfMessage+"\ncolWidth:"+this.fnCalcColRatios(b)+"\norientation:"+b.sPdfOrientation+"\nsize:"+b.sPdfSize+"\n--/TableToolsOpts--\n"+this.fnGetTableData(b))}}),print:e.extend({},
TableTools.buttonBase,{sInfo:"<h6>Print view</h6><p>Please use your browser's print function to print this table. Press escape when finished.</p>",sMessage:null,bShowAll:!0,sToolTip:"View print view",sButtonClass:"DTTT_button_print",sButtonText:"Print",fnClick:function(a,b){this.fnPrint(!0,b)}}),text:e.extend({},TableTools.buttonBase),select:e.extend({},TableTools.buttonBase,{sButtonText:"Select button",fnSelect:function(a){0!==this.fnGetSelected().length?e(a).removeClass(this.classes.buttons.disabled):
e(a).addClass(this.classes.buttons.disabled)},fnInit:function(a){e(a).addClass(this.classes.buttons.disabled)}}),select_single:e.extend({},TableTools.buttonBase,{sButtonText:"Select button",fnSelect:function(a){1==this.fnGetSelected().length?e(a).removeClass(this.classes.buttons.disabled):e(a).addClass(this.classes.buttons.disabled)},fnInit:function(a){e(a).addClass(this.classes.buttons.disabled)}}),select_all:e.extend({},TableTools.buttonBase,{sButtonText:"Select all",fnClick:function(){this.fnSelectAll()},
fnSelect:function(a){this.fnGetSelected().length==this.s.dt.fnRecordsDisplay()?e(a).addClass(this.classes.buttons.disabled):e(a).removeClass(this.classes.buttons.disabled)}}),select_none:e.extend({},TableTools.buttonBase,{sButtonText:"Deselect all",fnClick:function(){this.fnSelectNone()},fnSelect:function(a){0!==this.fnGetSelected().length?e(a).removeClass(this.classes.buttons.disabled):e(a).addClass(this.classes.buttons.disabled)},fnInit:function(a){e(a).addClass(this.classes.buttons.disabled)}}),
ajax:e.extend({},TableTools.buttonBase,{sAjaxUrl:"/xhr.php",sButtonText:"Ajax button",fnClick:function(a,b){var c=this.fnGetTableData(b);e.ajax({url:b.sAjaxUrl,data:[{name:"tableData",value:c}],success:b.fnAjaxComplete,dataType:"json",type:"POST",cache:!1,error:function(){alert("Error detected when sending table data to server")}})},fnAjaxComplete:function(){alert("Ajax complete")}}),div:e.extend({},TableTools.buttonBase,{sAction:"div",sTag:"div",sButtonClass:"DTTT_nonbutton",sButtonText:"Text button"}),
collection:e.extend({},TableTools.buttonBase,{sAction:"collection",sButtonClass:"DTTT_button_collection",sButtonText:"Collection",fnClick:function(a,b){this._fnCollectionShow(a,b)}})};TableTools.buttons=TableTools.BUTTONS;TableTools.classes={container:"DTTT_container",buttons:{normal:"DTTT_button",disabled:"DTTT_disabled"},collection:{container:"DTTT_collection",background:"DTTT_collection_background",buttons:{normal:"DTTT_button",disabled:"DTTT_disabled"}},select:{table:"DTTT_selectable",row:"DTTT_selected selected"},
print:{body:"DTTT_Print",info:"DTTT_print_info",message:"DTTT_PrintMessage"}};TableTools.classes_themeroller={container:"DTTT_container ui-buttonset ui-buttonset-multi",buttons:{normal:"DTTT_button ui-button ui-state-default"},collection:{container:"DTTT_collection ui-buttonset ui-buttonset-multi"}};TableTools.DEFAULTS={sSwfPath:"../swf/copy_csv_xls_pdf.swf",sRowSelect:"none",sRowSelector:"tr",sSelectedClass:null,fnPreRowSelect:null,fnRowSelected:null,fnRowDeselected:null,aButtons:["copy","csv","xls",
"pdf","print"],oTags:{container:"div",button:"a",liner:"span",collection:{container:"div",button:"a",liner:"span"}}};TableTools.defaults=TableTools.DEFAULTS;TableTools.prototype.CLASS="TableTools";TableTools.version="2.2.1";e.fn.dataTable.Api&&e.fn.dataTable.Api.register("tabletools()",function(){var a=null;0<this.context.length&&(a=TableTools.fnGetInstance(this.context[0].nTable));return a});"function"==typeof e.fn.dataTable&&"function"==typeof e.fn.dataTableExt.fnVersionCheck&&e.fn.dataTableExt.fnVersionCheck("1.9.0")?
e.fn.dataTableExt.aoFeatures.push({fnInit:function(a){var b=a.oInit,a=new TableTools(a.oInstance,b?b.tableTools||b.oTableTools||{}:{});TableTools._aInstances.push(a);return a.dom.container},cFeature:"T",sFeature:"TableTools"}):alert("Warning: TableTools requires DataTables 1.9.0 or newer - www.datatables.net/download");e.fn.DataTable.TableTools=TableTools;"function"==typeof n.fn.dataTable&&"function"==typeof n.fn.dataTableExt.fnVersionCheck&&n.fn.dataTableExt.fnVersionCheck("1.9.0")?n.fn.dataTableExt.aoFeatures.push({fnInit:function(a){a=
new TableTools(a.oInstance,"undefined"!=typeof a.oInit.oTableTools?a.oInit.oTableTools:{});TableTools._aInstances.push(a);return a.dom.container},cFeature:"T",sFeature:"TableTools"}):alert("Warning: TableTools 2 requires DataTables 1.9.0 or newer - www.datatables.net/download");n.fn.dataTable.TableTools=TableTools;return n.fn.DataTable.TableTools=TableTools};"function"===typeof define&&define.amd?define("datatables-tabletools",["jquery","datatables"],r):jQuery&&!jQuery.fn.dataTable.TableTools&&r(jQuery,
jQuery.fn.dataTable)})(window,document);

/*!
 ColVis 1.1.0
 Â©2010-2014 SpryMedia Ltd - datatables.net/license
*/
(function(j,i,k){j=function(d){var e=function(a,b){(!this.CLASS||"ColVis"!=this.CLASS)&&alert("Warning: ColVis must be initialised with the keyword 'new'");"undefined"==typeof b&&(b={});d.fn.dataTable.camelToHungarian&&d.fn.dataTable.camelToHungarian(e.defaults,b);this.s={dt:null,oInit:b,hidden:!0,abOriginal:[]};this.dom={wrapper:null,button:null,collection:null,background:null,catcher:null,buttons:[],groupButtons:[],restore:null};e.aInstances.push(this);this.s.dt=d.fn.dataTable.Api?(new d.fn.dataTable.Api(a)).settings()[0]:
a;this._fnConstruct(b);return this};e.prototype={button:function(){return this.dom.wrapper},fnRebuild:function(){this.rebuild()},rebuild:function(){for(var a=this.dom.buttons.length-1;0<=a;a--)this.dom.collection.removeChild(this.dom.buttons[a]);this.dom.buttons.splice(0,this.dom.buttons.length);this.dom.restore&&this.dom.restore.parentNode(this.dom.restore);this._fnAddGroups();this._fnAddButtons();this._fnDrawCallback()},_fnConstruct:function(a){this._fnApplyCustomisation(a);var b=this,c,f;this.dom.wrapper=
i.createElement("div");this.dom.wrapper.className="ColVis";this.dom.button=d("<button />",{"class":!this.s.dt.bJUI?"ColVis_Button ColVis_MasterButton":"ColVis_Button ColVis_MasterButton ui-button ui-state-default"}).append("<span>"+this.s.buttonText+"</span>").bind("mouseover"==this.s.activate?"mouseover":"click",function(a){a.preventDefault();b._fnCollectionShow()}).appendTo(this.dom.wrapper)[0];this.dom.catcher=this._fnDomCatcher();this.dom.collection=this._fnDomCollection();this.dom.background=
this._fnDomBackground();this._fnAddGroups();this._fnAddButtons();c=0;for(f=this.s.dt.aoColumns.length;c<f;c++)this.s.abOriginal.push(this.s.dt.aoColumns[c].bVisible);this.s.dt.aoDrawCallback.push({fn:function(){b._fnDrawCallback.call(b)},sName:"ColVis"});d(this.s.dt.oInstance).bind("column-reorder",function(a,d,e){c=0;for(f=b.s.aiExclude.length;c<f;c++)b.s.aiExclude[c]=e.aiInvertMapping[b.s.aiExclude[c]];a=b.s.abOriginal.splice(e.iFrom,1)[0];b.s.abOriginal.splice(e.iTo,0,a);b.fnRebuild()});this._fnDrawCallback()},
_fnApplyCustomisation:function(a){d.extend(!0,this.s,e.defaults,a);!this.s.showAll&&this.s.bShowAll&&(this.s.showAll=this.s.sShowAll);!this.s.restore&&this.s.bRestore&&(this.s.restore=this.s.sRestore);var a=this.s.groups,b=this.s.aoGroups;if(a)for(var c=0,f=a.length;c<f;c++)if(a[c].title&&(b[c].sTitle=a[c].title),a[c].columns)b[c].aiColumns=a[c].columns},_fnDrawCallback:function(){for(var a=this.s.dt.aoColumns,b=this.dom.buttons,c=this.s.aoGroups,f,g=0,h=b.length;g<h;g++)f=b[g],f.__columnIdx!==k&&
d("input",f).prop("checked",a[f.__columnIdx].bVisible);b=0;for(f=c.length;b<f;b++){a:{for(var g=c[b].aiColumns,h=0,e=g.length;h<e;h++)if(!1===a[g[h]].bVisible){g=!1;break a}g=!0}if(g)d("input",this.dom.groupButtons[b]).prop("checked",!0),d("input",this.dom.groupButtons[b]).prop("indeterminate",!1);else{a:{g=c[b].aiColumns;h=0;for(e=g.length;h<e;h++)if(!0===a[g[h]].bVisible){g=!1;break a}g=!0}g?(d("input",this.dom.groupButtons[b]).prop("checked",!1),d("input",this.dom.groupButtons[b]).prop("indeterminate",
!1)):d("input",this.dom.groupButtons[b]).prop("indeterminate",!0)}}},_fnAddGroups:function(){var a;if("undefined"!=typeof this.s.aoGroups)for(var b=0,c=this.s.aoGroups.length;b<c;b++)a=this._fnDomGroupButton(b),this.dom.groupButtons.push(a),this.dom.buttons.push(a),this.dom.collection.appendChild(a)},_fnAddButtons:function(){var a,b=this.s.dt.aoColumns;if(-1===d.inArray("all",this.s.aiExclude))for(var c=0,f=b.length;c<f;c++)-1===d.inArray(c,this.s.aiExclude)&&(a=this._fnDomColumnButton(c),a.__columnIdx=
c,this.dom.buttons.push(a));"alpha"===this.s.order&&this.dom.buttons.sort(function(a,c){var d=b[a.__columnIdx].sTitle,f=b[c.__columnIdx].sTitle;return d===f?0:d<f?-1:1});this.s.restore&&(a=this._fnDomRestoreButton(),a.className+=" ColVis_Restore",this.dom.buttons.push(a));this.s.showAll&&(a=this._fnDomShowAllButton(),a.className+=" ColVis_ShowAll",this.dom.buttons.push(a));d(this.dom.collection).append(this.dom.buttons)},_fnDomRestoreButton:function(){var a=this;return d('<li class="ColVis_Special '+
(this.s.dt.bJUI?"ui-button ui-state-default":"")+'">'+this.s.restore+"</li>").click(function(){for(var b=0,c=a.s.abOriginal.length;b<c;b++)a.s.dt.oInstance.fnSetColumnVis(b,a.s.abOriginal[b],!1);a._fnAdjustOpenRows();a.s.dt.oInstance.fnAdjustColumnSizing(!1);a.s.dt.oInstance.fnDraw(!1)})[0]},_fnDomShowAllButton:function(){var a=this;return d('<li class="ColVis_Special '+(this.s.dt.bJUI?"ui-button ui-state-default":"")+'">'+this.s.showAll+"</li>").click(function(){for(var b=0,c=a.s.abOriginal.length;b<
c;b++)-1===a.s.aiExclude.indexOf(b)&&a.s.dt.oInstance.fnSetColumnVis(b,!0,!1);a._fnAdjustOpenRows();a.s.dt.oInstance.fnAdjustColumnSizing(!1);a.s.dt.oInstance.fnDraw(!1)})[0]},_fnDomGroupButton:function(a){var b=this,c=this.s.aoGroups[a];return d('<li class="ColVis_Special '+(this.s.dt.bJUI?"ui-button ui-state-default":"")+'"><label><input type="checkbox" /><span>'+c.sTitle+"</span></label></li>").click(function(a){var g=!d("input",this).is(":checked");"li"!==a.target.nodeName.toLowerCase()&&(g=!g);
for(a=0;a<c.aiColumns.length;a++)b.s.dt.oInstance.fnSetColumnVis(c.aiColumns[a],g)})[0]},_fnDomColumnButton:function(a){var b=this,c=this.s.dt.aoColumns[a],f=this.s.dt,c=null===this.s.fnLabel?c.sTitle:this.s.fnLabel(a,c.sTitle,c.nTh);return d("<li "+(f.bJUI?'class="ui-button ui-state-default"':"")+'><label><input type="checkbox" /><span>'+c+"</span></label></li>").click(function(c){var e=!d("input",this).is(":checked");"li"!==c.target.nodeName.toLowerCase()&&(e=!e);c=d.fn.dataTableExt.iApiIndex;d.fn.dataTableExt.iApiIndex=
b._fnDataTablesApiIndex.call(b);f.oFeatures.bServerSide?(b.s.dt.oInstance.fnSetColumnVis(a,e,!1),b.s.dt.oInstance.fnAdjustColumnSizing(!1),(""!==f.oScroll.sX||""!==f.oScroll.sY)&&b.s.dt.oInstance.oApi._fnScrollDraw(b.s.dt),b._fnDrawCallback()):b.s.dt.oInstance.fnSetColumnVis(a,e);d.fn.dataTableExt.iApiIndex=c;null!==b.s.fnStateChange&&b.s.fnStateChange.call(b,a,e)})[0]},_fnDataTablesApiIndex:function(){for(var a=0,b=this.s.dt.oInstance.length;a<b;a++)if(this.s.dt.oInstance[a]==this.s.dt.nTable)return a;
return 0},_fnDomCollection:function(){return d("<ul />",{"class":!this.s.dt.bJUI?"ColVis_collection":"ColVis_collection ui-buttonset ui-buttonset-multi"}).css({display:"none",opacity:0,position:!this.s.bCssPosition?"absolute":""})[0]},_fnDomCatcher:function(){var a=this,b=i.createElement("div");b.className="ColVis_catcher";d(b).click(function(){a._fnCollectionHide.call(a,null,null)});return b},_fnDomBackground:function(){var a=this,b=d("<div></div>").addClass("ColVis_collectionBackground").css("opacity",
0).click(function(){a._fnCollectionHide.call(a,null,null)});"mouseover"==this.s.activate&&b.mouseover(function(){a.s.overcollection=!1;a._fnCollectionHide.call(a,null,null)});return b[0]},_fnCollectionShow:function(){var a=this,b;b=d(this.dom.button).offset();var c=this.dom.collection,f=this.dom.background,e=parseInt(b.left,10),h=parseInt(b.top+d(this.dom.button).outerHeight(),10);this.s.bCssPosition||(c.style.top=h+"px",c.style.left=e+"px");d(c).css({display:"block",opacity:0});f.style.bottom="0px";
f.style.right="0px";h=this.dom.catcher.style;h.height=d(this.dom.button).outerHeight()+"px";h.width=d(this.dom.button).outerWidth()+"px";h.top=b.top+"px";h.left=e+"px";i.body.appendChild(f);i.body.appendChild(c);i.body.appendChild(this.dom.catcher);d(c).animate({opacity:1},a.s.iOverlayFade);d(f).animate({opacity:0.1},a.s.iOverlayFade,"linear",function(){d.browser&&(d.browser.msie&&d.browser.version=="6.0")&&a._fnDrawCallback()});this.s.bCssPosition||(b="left"==this.s.sAlign?e:e-d(c).outerWidth()+
d(this.dom.button).outerWidth(),c.style.left=b+"px",f=d(c).outerWidth(),d(c).outerHeight(),e=d(i).width(),b+f>e&&(c.style.left=e-f+"px"));this.s.hidden=!1},_fnCollectionHide:function(){var a=this;!this.s.hidden&&null!==this.dom.collection&&(this.s.hidden=!0,d(this.dom.collection).animate({opacity:0},a.s.iOverlayFade,function(){this.style.display="none"}),d(this.dom.background).animate({opacity:0},a.s.iOverlayFade,function(){i.body.removeChild(a.dom.background);i.body.removeChild(a.dom.catcher)}))},
_fnAdjustOpenRows:function(){for(var a=this.s.dt.aoOpenRows,b=this.s.dt.oApi._fnVisbleColumns(this.s.dt),c=0,d=a.length;c<d;c++)a[c].nTr.getElementsByTagName("td")[0].colSpan=b}};e.fnRebuild=function(a){var b=null;"undefined"!=typeof a&&(b=a.fnSettings().nTable);for(var c=0,d=e.aInstances.length;c<d;c++)("undefined"==typeof a||b==e.aInstances[c].s.dt.nTable)&&e.aInstances[c].fnRebuild()};e.defaults={active:"click",buttonText:"Show / hide columns",aiExclude:[],bRestore:!1,sRestore:"Restore original",
bShowAll:!1,sShowAll:"Show All",sAlign:"left",fnStateChange:null,iOverlayFade:500,fnLabel:null,bCssPosition:!1,aoGroups:[],order:"column"};e.aInstances=[];e.prototype.CLASS="ColVis";e.VERSION="1.1.0";e.prototype.VERSION=e.VERSION;"function"==typeof d.fn.dataTable&&"function"==typeof d.fn.dataTableExt.fnVersionCheck&&d.fn.dataTableExt.fnVersionCheck("1.7.0")?d.fn.dataTableExt.aoFeatures.push({fnInit:function(a){var b=a.oInit;return(new e(a,b.colVis||b.oColVis||{})).button()},cFeature:"C",sFeature:"ColVis"}):
alert("Warning: ColVis requires DataTables 1.7 or greater - www.datatables.net/download");d.fn.dataTable.ColVis=e;return d.fn.DataTable.ColVis=e};"function"===typeof define&&define.amd?define("datatables-colvis",["jquery","datatables"],j):jQuery&&!jQuery.fn.dataTable.ColVis&&j(jQuery,jQuery.fn.dataTable)})(window,document);


//////////////Initialization/////////////////

$(document).ready(function() {
    var table = $('.table').DataTable({
    	"aLengthMenu": [[15, 25, 50, -1], [10, 25, 50, "ALL"]],
		"iDisplayLength": 15,
    });
     // new $.fn.dataTable.FixedHeader(table, {
     // 	"offsetTop" : 50
     // });
 	// var tt = new $.fn.dataTable.TableTools(table);
  //   $( tt.fnContainer() ).insertBefore('div.dataTables');
} );
