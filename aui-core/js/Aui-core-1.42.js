﻿( function (  window, undefined ) {
	
	var
		// ??ʼ??ȫ?ֳ???
		// ===========>
		
		document = window.document,
		location = window.location,
		navigator = window.navigator,
		
		// ???????鷽??
		// =========>
		
		Aui_core_push = Array.prototype.push,
		Aui_core_slice = Array.prototype.slice,
		Aui_core_indexOf = Array.prototype.indexOf,
		Aui_core_concat = Array.prototype.concat,
		Aui_core_toString = Object.prototype.toString,
		Aui_core_hasOwn = Object.prototype.hasOwnProperty,
		
		Aui = function( elements, context )
		{
			return new Aui.fn.init( elements, context );
		};
		
		// ˽?з???API
		// ==========>
		
		Aui.fn = {
			
			prevObject : null,
			
			Aui_RegExp : {
				ID: /#((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
				CLASS: /\.((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
				TAG: /^((?:[\w\u00c0-\uFFFF\*\-]|\\.)+)/,
				POS: /:(not|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^\-]|$)$/
			},

			// ɸѡDOM????????????
			// =================================================>
			// @mothed : Aui.fn.selector( ?ַ??? )
			// @return : array
			
			selector : function( selector, context )
			{
				var context = typeof context === "string" ? [ document ] : context || [ document ];

				if( Aui.isString( selector ) )
				{
					var _self = this,
						
						REG = this.Aui_RegExp,
					
						group = selector.split(","),
						
						execStr = function( reg, s )
						{
							return reg.test( s ) ? reg.exec( s )[0]  : "";
						},
						
						fnSelect = function( str, parents, REG )
						{
							
							var result = [],
								mark = /[#\.]{1}/g.exec( str ),
								tag = execStr( REG.TAG, str );

							switch( mark && mark[0] )
							{
								case "#":
									result = tag ? 
										this.getElement( execStr( REG.ID, str ).substring( 1 ), parents, tag, "id" ) : 
										[ document.getElementById( str.substring( 1 ) ) ];
								break;
								
								case ".":
									result = this.getByClass( parents, execStr( REG.CLASS, str ).substring( 1 ), tag );
								break;
								
								default:
									result =  this.getElement( null, parents, tag, "tagName" );
							};
							return result;
						},
						
						selectAttr = function( selector, str )
						{
							var strAttr = /\[(.+?)\]/g.test( str ) ? str.match( /\[(.+?)\]/g ) : "",
								result = [];
								
							if( strAttr )
							{
								Aui.each( selector, function()
								{
									var _this = this,
										_len = strAttr.length - 1,
										_bool = true;
			
									while( _len >= 0 )
									{
										var arrAttr =  strAttr[ _len ] ? strAttr[ _len ].match( /[^\[\]=\'\"\s]+/g ) : "",
											AttrLen = arrAttr.length;
										if( AttrLen === 1 )
										{
											if( !( _this[ arrAttr[0] ] || _this.getAttribute( arrAttr[0] ) ) ) _bool = false;
										}
										else
										{
											if( !( ( _this[ arrAttr[0] ] || _this.getAttribute( arrAttr[0] ) ) === arrAttr[1] ) ) _bool = false;
										};
			
										_len -= 1;
									};
									
									_bool && result.push( _this );
								});
							};
							
							return result.length ? result : selector ;
							
							
							var arrAttr =  strAttr ? strAttr.match( /[^\[\]=\'\"\s]+/g ) : "",
								sLen = arrAttr.length;
							
							Aui.each( selector, function()
							{
								var attr =  this[ arrAttr[0] ] || this.getAttribute( arrAttr[0] );
								
								if( sLen )
								{
									if( sLen === 1 )
									{
										attr && result.push( this );
									}
									else
									{
										attr === arrAttr[1] && result.push( this );
									};
								};
							});
			
						},
						selectFilter = function( selector, str, REGPOS )
						{
							var strAttr = execStr( REGPOS, str );
							
							if( !strAttr ) return selector;
							
							var Str = strAttr.substring(1),
								selector = this.makeArray( selector ),
								num = /\d+/.test( Str ) ? parseInt( /\d+/.exec( Str )[0] , 10 ) : 0;
								result = [];
							
							switch( /\w+/gi.exec( Str )[0] )
							{
								case "odd"	:
									Aui.each( selector, function( i )
									{
										( i%2 === 1 ) && result.push( this );
									});
								break;
								case "even"	:
									Aui.each( selector, function( i )
									{
										( i%2 === 0 ) && result.push( this );
									});
								break;
								case "first" :
									result.push( selector[ 0 ] );
								break;
								case "last" :
									result.push( selector[ selector.length - 1 ] );
								break;
								case "gt" :
									result = selector.slice( num );
								break;
								case "lt" :
									result = selector.slice( 0, num );
								break;
								case "eq" :
									result.push( selector[ num ] );
								break;
								case "not" :
									selector.splice( num, 1 );
									result = selector;
								break;
								default : 
									return selector;
							};
							return result.length ? result : selector ;
						},
						handleStr = function( str )
						{
							var strArr = str.match( /\S+(\[.+?\](\[.+?\])*)|\S+/g ),
								len = strArr.length - 1,
								newArr = [];
								
							while( len >= 0 )
							{
								strArr[ len ] !== "" && newArr.unshift( strArr[ len ].replace(/\s+/g, "") );
								len -= 1;
							};
							
							return  newArr.join(" ").replace( /(\s+\:)/g, ":" );
						};
						
					var _resultElement = [];
					
					Aui.each( group,function( i, v )
					{
						var v = /\[.+?\]/g.test( v ) ? handleStr( v ) : v,
							_elements = _elements || context;
							
						Aui.each(Aui.trim( v.replace( /\s{2,}/g," ") ).split(" "), function( i, str )
						{
							_elements = fnSelect.call( _self, Aui.trim( str ) , _elements, REG );
							_elements = selectAttr.call( _self, _elements, str );
							_elements = selectFilter.call( _self, _elements, str, REG.POS );
						});
						
						_resultElement = _resultElement.concat( _elements );
					});
					
				}
				else if( typeof selector === "object" )
				{
					return selector instanceof Array ? 
						  selector : 
						  Aui.typeOf( selector ) === "dom" && selector.length ? 
						  this.makeArray( selector ) :
						  selector.constructor === "Aui" ?
						  this.toArray( selector ) :
						  [ selector ];
				};
				
				return _resultElement;
			},
			
			color10 : function ( str )
			{
				var regHex6 = /^#{1}[0-9|a-f]{6}$/ig,
					regHex3 = /^#{1}[0-9|a-f]{3}$/ig,
					regRGB = /((GB|rgb)\()|(\))/g,
					hexArr = function( s, start, end )
					{
						return parseInt( s.toString().substring( start, end ) , 16 )
					},
					rgbArr = function( str )
					{
						return parseInt( str, 10 );
					};
				if( regHex3.test( str ) )
				{
					var str = str.substring( 1 ),
						R = str.slice( 0, 1 ),
						G = str.slice( 1, 2 ),
						B = str.slice( 2, 3 );
					return [ parseInt( ( R + R ) , 16 ), parseInt( ( G + G ), 16 ), parseInt( ( B + B ), 16 ) ];
				}
				else if( regHex6.test( str ) )
				{
					var str = str.substring( 1 );
					return [ hexArr( str, 0, 2 ), hexArr( str, 4, 2 ), hexArr( str, 6, 4 ) ];
				}
				else if( regRGB.test( str ) )
				{
					var arr = str.replace( regRGB, "" ).split(",");
					return [ rgbArr( arr[ 0 ] ), rgbArr( arr[ 1 ] ),rgbArr( arr[ 2 ] ) ];
				};
			},
			
			// NODE??
			// =================================================>
			// @mothed : Aui.fn.init( ?ַ?ѡ??, ָ??λ?? )
			// @return : Aui????
			
			init : function( selector, context )
			{
				if( !selector ) return this;
				
				this.length = 0;
				
				var elements = this._Aui.selector( selector, context ) || [];

				this._Aui.prevObject = elements;
				
				//console.log( this._Aui.makeArray( elements ) )
				
				Aui_core_push.apply( this, elements );
			},
			
			// ??ȡCSS??ʽ
			// =================================================>
			// @mothed : Aui.fn.getStyle( DOM????, CSS???? )
			// @return : String
			
			getStyle : function( obj, attr )
			{
				return obj.currentStyle ? obj.currentStyle[ attr ] || 1 : getComputedStyle( obj, false )[ attr ];
			},
			
            getSize : function( obj, pos, bool, array, bug )
			{
				var _self = obj[0];
				
				switch( _self )
				{
					case document :
					
						var nScroll = _self.documentElement[ "scroll" + pos ],
							nClient = _self.documentElement[ "client" + pos ];
							
						return ( nScroll > nClient ? nScroll : nClient ) + bug;
					break;
					
					case window :
						return document.documentElement[ "client" + pos ];  
					break;
					
					default :
						if( bool )
						{
							var result = 0,
								fnGetStyle = this.getStyle;
							
							Aui.each( array, function()
							{
								result += parseInt( fnGetStyle( _self, this ), 10 );
							});
							return result + _self[ "offset" + pos ];
						}
						else
						{
							return _self[ "offset" + pos ];
						};
				};
			},
			
			// ??ȡָ??classԪ??
			// =================================================>
			// @mothed : Aui.fn.getByClass( ????, class??, ??ǩ?? )
			// @return : Array
			
			getByClass : function( parents, className, tagName )
			{
				var result = [],
					className = className || "*",
					reg = RegExp( "\\b" + className + "\\b","i" );
					
				Aui.each( parents, function()
				{
					Aui.each( this.getElementsByTagName( tagName ), function()
					{
						reg.test( this.className ) && result.push( this );
					});
				});
				
				return result;
			},
			
			getElement : function( str, parent, tag, mark )
			{
				var _self = this,
					result = [],
					tag = tag || "*",
					parent = parent instanceof Array ? parent : parent.length ? this.makeArray( parent ) : [ parent ];
					
				Aui.each( parent, function()
				{
					if( mark === "id" )
					{
						Aui.each( this.getElementsByTagName( tag ), function()
						{
							this.id === str && result.push( this );
						});
					}
					else
					{
						result = result.concat( _self.makeArray( this.getElementsByTagName( tag ) ) );
					};
				});
				return result;
			},
			
			// DOM????ת?????飬?????µ?????
			// =================================================>
			// @mothed : Aui.fn.makeArray( DOM???? )
			// @return : Array
			
			makeArray : function( array )
			{
				try
				{
					return Aui_core_slice.apply( array );
				}
				catch( e )
				{
					var result = [];
					
					Aui.each( array, function( i, v )
					{
						i !== "length" && result.push( this );
					});
				}
				return result;
			},
			
			returnNodeList : function( arg )
			{
			???? var obj = document.createElement( "div" ); 
			
			???? obj.innerHTML = arg; 
			
			???? return obj.childNodes; 
			},
			
			IsIeVer : function( num )
			{
				return  parseInt( Aui.browser().match( /\d+/g ), 10 ) < num;	
			},
			
			insertNode : function( arg, object, curr, parent )
			{
				var _self = object[0];
				
				if( typeof arg === "string")
				{
					var reg = /<.+?>.{0,}?<\/.+?>/g;
					
					if( reg.test( arg ) )
					{
						var elements = this.makeArray( this.returnNodeList( arg ) )
						Aui.each( elements, function( i, elem )
						{
							parent.insertBefore( elem, curr );
						});
					}
					else
					{
						parent.insertBefore( document.createElement( arg.match( /\b[a-zA-Z]+\b/g )[0] ), curr );
					};
				}
				else
				{
					parent.insertBefore( arg, curr );
				};
				return object;
			},
			
			getOffset : function( curr, pos )
			{
				var value = curr[ pos ];
				
				while( curr !== document.documentElement )
				{
					curr = curr.parentNode;
					value += curr[ pos ];
				};
				
				return value;
			},
			
			changeStr : function( str )
			{
				return /\-\w?/ig.test( str ) ? str.replace( /\-\w?/ig, str.match( /\-\w?/ig )[0].charAt( 1 ).toUpperCase() ) : str;
			},
			changeStr2 : function( str )
			{
				return /[A-Z]{1}/g.test( str ) ? 
					   str.replace( /[A-Z]{1}/g, "-" +  str.substring( str.search( /[A-Z]{1}/g ),str.search( /[A-Z]{1}/g ) + 1 ).toLowerCase() ) :
					   str
			},
			
			// ??????ת?????飬?????µ?????
			// =================================================>
			// @mothed : Aui.fn.toArray( ???? )
			// @return : Array
			
			toArray : function( obj, args ){
				try
				{
					return Aui_core_slice.apply( obj, args );
				}
				catch( e )
				{
					var result = [];
					
					Aui.each( obj, function( i, v )
					{
						result.push( this );
					} );
				}
				return result;
			},
			
			// ????ת??Aui?????飬?????µĶ???
			// =================================================>
			// @mothed : Aui.fn.toAui( ???? )
			// @return : Aui Object
			
			toAui : function( array )
			{
			   var ret = Aui();
			   
			   if( Aui_core_push.apply( ret, array ) )
			   {
			       return ret;
			   }
			   else 
			   {
				   Aui.each( array, function( i, v )
				   {
				       ret[ i ] = this;
				   });
				   
				   ret.length = array.length;
				   
			       return ret;
			   }
			},
			
			animation : function( obj, json, duration, callback, easing )
			{
				var easing = Aui.easing[ ( typeof easing === "string" ? easing :  "easeDefault"  ) || "easeDefault" ],
					
					duration = duration*0.1 || 40, 
					
					_fn = this,
					
					_t = 0,
				
					_this = obj,
					
					_style = _this.style,
					
					_styleLen = _style.length > 0 || _style.length === undefined ,
					
					_regColor = /(^#{1})|[rgb|RGB]{3}/,
					
					_start = ( function( dom, obj, aui )
					{
						var tgt = {}, a;
						for( a in obj )
						{
							var _isColor = _regColor.test( obj[ a ] );
							tgt[ a ] = _isColor ? _fn.color10( aui.getStyle( dom, _fn.changeStr( a ) ) ) : aui.getStyle( dom, _fn.changeStr( a )  );
						};
						return tgt;
					})( _this, json, this ),
					
					_setColor = function( e, t, b, c, d )
					{
						var result = [];
						
						for( var i = 0; i < 3; i += 1 )
						{
							result.push( Math.ceil( e( t, b[i], ( c[i] - b[i] ), d ) ) );	
						};
						return "rgb( " + result.join(",") + ")";
					};
				
				_this.isFx = true;
				
				if( _this.timer ) return false;
				
				clearTimeout( _this.timer );
				
				( function()
				{
					var str = "";
					
					if( _t < duration )
					{
						_t++;
		
						for( var attr in json )
						{
							var _isColor = _regColor.test( json[ attr ] ),
								_isopacity = attr === "opacity",
								_b = _isopacity ? parseFloat( _start[ attr ]*100 )/100 : _isColor ? _start[ attr ] : parseInt( _start[ attr ], 10 ),
								_c = _isColor ? _fn.color10( json[ attr ] ) : _isopacity ? json[ attr ] : parseInt( json[ attr ], 10 ),
								_v = easing( _t, _b , ( _c - _b ), duration ),
								_v = _isopacity ? Math.ceil( _v*100 )/100 : _isColor ? _setColor( easing, _t, _b , _c, duration ) : Math.ceil( _v ) + "px";
							if( _styleLen )
							{
								if( _isopacity )
								{
									_style.opacity = _v;
									_style.filter = "alpha( opacity = " + _v*100 + ")";
								}
								else
								{
									_style[ attr ] = _v;
								};
							}
							else
							{
								if( _isopacity )
								{
									str += "opacity:" +_v + ";filter:alpha( opacity = " + _v*100 + ");";
								}
								else
								{
									str += _fn.changeStr2( attr ) + ":" + _v + ";";
								};
							};
							
						};
						if( !_styleLen ) _style.cssText = str ;
						
						_this.timer = setTimeout( arguments.callee, 10 );
					}
					else
					{
						_this.isFx = false;
						
						_this.timer = null;
						
						Aui.isFunction( callback ) && callback.call( _this );
					};
				})( )
	
			}
		};
		
		Aui.fn.init.prototype = {
			
			_Aui : Aui.fn,
			
			constructor : "Aui",
			
			splice : [].splice,
			
			concat: [].concat,
			
			slice : function()
			{
				return this._Aui.toAui( this._Aui.toArray( this, arguments ) );  
			},
	
			push : Aui_core_push,
			
			objToString : Aui_core_toString,
			
			objHasOwn : Aui_core_hasOwn,
			
			// AUI DOM - API?ӿ?
			// ================>

			eq : function( num )
			{
			  return num < 0 ? this : this.slice( num, num + 1 );
			},
			
			children : function( str )
			{
				var toArray = function( obj, str )
				{
					var result = [];
					
					Aui.each( obj, function()
					{
						var _self = this;
						
						Aui.each( this.children, function()
						{
							var _me = this;
							
							if( this.nodeType === 1 )
							{
								if( Aui.isString( str ) )
								{
									_me.tagName.toLowerCase() === str.toLowerCase() && result.push( _me );
								}
								else
								{
									result.push( _me );
								};
							};
						});
					});
					
					return result;
				};
				return this._Aui.toAui( toArray( this, str ) );
			},
			
			parents : function( str )
			{
				var _self = this,
					result = [],
					parent = null,
					count = 0;
					
				Aui.each( _self, function()
				{
					if( Aui.isString( str ) )
					{
						parent = this.parentNode;
						
						while( parent.tagName.toLowerCase() !== str.toLowerCase() )
						{
							parent = parent.parentNode;
						};
						
						result[ count ] !== parent && result.push( parent );
					}
					else
					{
						result.push( this.parentNode )
					};
				});
				
				return _self._Aui.toAui( result );
			},
			
			index : function( object )
			{
				var _self = this,
					toArray = _self._Aui.toArray,
					
					elem = object ? toArray( _self, 0 ) : ( function( nodes, tagName )
					{
						var result = [];
						
						Aui.each( nodes, function()
						{
							this.tagName === tagName && result.push( this );
						});
						
						return result;
						
					})( _self[0].parentNode.children, _self[0].tagName ),
					
					curr = object ? object[ 0 ] || object : _self[ 0 ];
				
				return ( function( arr, curr )
					{
						if( Aui_core_indexOf )
						{
							return Aui_core_indexOf.call( arr, curr );
						}
						else
						{
							var slen = arr.length, i;
							
							for( i = 0; i < slen; i += 1) 
							{
								if( arr[ i ] === curr ) return i;
							};
							
							return -1;
						};
						
					}( elem, curr ));
			},
			
			end : function()
			{
				return this._Aui.toAui ( this._Aui.prevObject );
			},
			
			html : function( str )
			{
				if( str !== undefined )
				{
					Aui.each( this, function()
					{
						this.innerHTML = str;
					});
					
					return this;
				}
				else
				{
					return this[0].innerHTML;
				};
			},
			
			text : function( str )
			{
				var reText = function( str )
					{
						return Aui.trim( str.toString().replace( /<.+?>/g, "" ) , "all");
					};
				
				if( str !== undefined )
				{
					Aui.each( this, function()
					{
						this.innerHTML = reText( str );
					});
					return this;
				}
				else
				{
					return reText( this[0].innerHTML );
				};
			},
			
			find : function( str )
			{
				if( str ) 
				{
					return this._Aui.toAui( this._Aui.selector( str, this ) );
				}
				else
				{
					return this;
				};
			},
			
			left : function( bool )
			{
				var fnOffset = this._Aui.getOffset,
					curr = this[ 0 ];
				
				return bool ? fnOffset( curr, "offsetLeft" ) : curr.offsetLeft;
			},
			top : function( bool )
			{
				var fnOffset = this._Aui.getOffset,
					curr = this[ 0 ];
				
				return bool ? fnOffset( curr, "offsetTop" ) : curr.offsetTop;
			},
			
			width : function( bool )
			{
				return this._Aui.getSize( this, "Width", bool || false, [ "marginLeft", "marginRight" ], 0 );
			},

			height : function( bool )
			{
				return this._Aui.getSize( this, "Height", bool || false, [ "marginTop", "marginBottom" ], this._Aui.IsIeVer( 8 ) ? 10 : 0 );
			},
			
			getScroll : function( elem, pos )
			{
				/*console.log( elem )
				if( elem === window || elem === document )
				{
					return document.documentElement[ "scroll" + pos ] || document.body[ "scroll" + pos ];
				}
				else
				{
					return elem[ "scroll" + pos ];
				}*/
				return elem.tagName ? elem[ "scroll" + pos ] : ( document.documentElement[ "scroll" + pos ] || document.body[ "scroll" + pos ] );
			},
			
			scrollTop : function( bool )
			{
				return this.getScroll( this[0] , "Top" );
			},
			
			scrollLeft : function( bool )
			{
				return this.getScroll( this[0], "Left" );
			},
			
			getStyle : function( str )
			{
				return Aui.isString( str ) ? this._Aui.getStyle( this[0], this._Aui.changeStr( str ) ) : undefined;
			},
			
			setStyle : function( str, value )
			{
				if( Aui.isString( str ) && value !== undefined )
				{
					var str = this._Aui.changeStr( str );
					
					Aui.each( this, function()
					{
						if ( str === "opacity")
						{
							this.style.filter = "alpha(opacity="+ value*100 +")";
							this.style.opacity = value;
						}
						else
						{
							this.style[ str ] = typeof value === "number" ? value + "px" : value;
						};
					});
				}
				else if( Aui.typeOf( str ) === "object" )
				{
					var fnStr = this._Aui.changeStr;
					
					Aui.each( this, function()
					{
						var _self = this;
						
						Aui.each( str, function( i, v )
						{
							var i = fnStr( i );
							
							if ( i === "opacity" )
							{
								_self.style.filter = "alpha(opacity="+ v*100 +")";
								_self.style.opacity = v;
							}
							else
							{
								_self.style[ i ] = typeof v === "number" ? v + "px" : v;
								
							};
						});
					});
				};
				return this;
			},
			
			removeStyle : function( str )
			{
				if( Aui.isString( str ) )
				{
					var str = this._Aui.changeStr( str );
					
					Aui.each( this, function()
					{
						str === "opacity" && ( this.style.filter = "" );
						this.style[ str ] = "";
					});
				};
				return this;
			},
			
			getAttr : function( attr )
			{

				return typeof attr === "string" && ( this[0].getAttribute( attr ) || this[0][ attr ] || this[0].className );
			},
			
			setAttr : function( attrs, value ){
				
				if( typeof attrs === "string" && value !== undefined )
				{
					Aui.each( this, function()
					{
						attrs === "class" ? this.className += " " + value : this.setAttribute( attrs , value );
					});
				}
				else if( Aui.typeOf( attrs ) === "object" )
				{
					Aui.each( this, function()
					{
						_self = this;
						
						Aui.each( attrs, function( i, v )
						{
							i === "class" ? _self.className += " " + v : _self.setAttribute( i , v );
						});
					});
				}
				return this;
			},
			
			removeAttr : function( attr )
			{
				if( typeof attr === "string" )
				{
					Aui.each( this, function()
					{
						this === "class" ? this.className = "" : this.removeAttribute( attr );
					});
				};
				return this;
			},
			
			addClass : function( str )
			{
				if( Aui.isString( str ) )
				{
					Aui.each( this, function()
					{
						var className = this.className,
							oReg = RegExp( str, "ig" );
							
						if( className )
						{
							if( !oReg.test( className ) ) this.className += " " + str ;
						}
						else
						{
							this.className = str;
						};
					});
				};
				return this;
			},
			
			removeClass : function( str )
			{
				if( Aui.isString( str ) )
				{
					var oReg = RegExp( "(\s{1}\b" + str + "\b)|(\b" + str + "\b\s{1})", "ig" ),
						className = this.className;
						
					Aui.each( this, function()
					{
						if( className )
						{
							this.className =  className.replace( oReg, "" );
						}
						else
						{
							this.className = "";
						};
					});
				};
				return this;
			},
			
			hasClass : function( str )
			{
				return ( Aui.isString( str ) ) ? RegExp( "\\b" + str + "\\b", "ig" ).test( this[0].className ) : false;
			},
			
			hover : function( fnOver, fnOut )
			{
				this.bind( "mouseover", fnOver );
				this.bind( "mouseout", fnOut );
				
				return this;
			},
			toggle : function()
			{
				var aArg = arguments,
					len = aArg.length - 1;
				
				for( ;len >=0; len -= 1 )
				{
					if( !Aui.isFunction( aArg[ len ] ) ) return this;
					
				};
				
				this.bind( "click", function()
				{
					this.count = this.count || 0;
					aArg[ this.count++ % aArg.length ].call( this );
				});
				
				return this;
			},
			
			// ?¼?????
			// =================================================> 
			// @mothed : .bind( ?¼???, ?ص????? )
			// @return : Aui object
			
			bind : function( sEvent, fn )
			{
			    Aui.each( this, function( i, v )
				{
					var _self = this;
					
					_self.queue = _self.queue || {};
					
					var box = _self.queue[ sEvent ] = _self.queue[ sEvent ] || [];
					
					box.unshift( fn );
					
					if( !box["_handler_"] )
					{
						box[ "_handler_"] = function( e )
						{
							var evt = e || window.event,
							
								eventType = evt.type,
							
								bindFn = function( func, e, _this )
								{
									for( var i = 0, fn; fn = func[ i ++ ]; )
									{
										if( false === fn.call( _this, e ) )
										{
											e.preventDefault ? e.preventDefault() : e.returnValue = false;
										};
									};
								};
								
							evt.stopPropagation ? evt.stopPropagation() : evt.cancelBubble = true;
							
							if( eventType === "mouseover" || eventType === "mouseout" )
							{
								var elem = eventType === "mouseover" ? evt.fromElement : evt.toElement,
									target = evt.currentTarget,
									related = evt.relatedTarget || elem;
								
								if( !Aui.contains(target, related) && target!==related )
								{
									bindFn( box, evt, _self )
								};
							}
							else
							{
								bindFn( box, evt, _self );
							};
						};
					};
					_self.addEventListener ?
						_self.addEventListener( sEvent, box[ "_handler_"] , false) :
						_self.attachEvent( "on" + sEvent,  box[ "_handler_"] );

				} );
				
				return this;
			},
			
			// ?????¼?????
			// =================================================>
			// @mothed : .unbind( ?¼???, ?ص????? )
			// @return : Aui object
			
			unbind : function(  sEvent, fn  )
			{
				var remove = function( sEv, b, _this )
					{
						_this.removeEventListener ?
							_this.removeEventListener( sEv, b[ "_handler_"] , false) :
							_this.detachEvent( "on" + sEv,  b[ "_handler_"] );
					};
			    Aui.each( this, function( i, v )
				{
					var _self = this;
					
					if( sEvent )
					{
						try
						{
							var box = _self.queue[ sEvent ];
							
							if( fn )
							{
								Aui.each( box, function()
								{
									box[ i ] === fn && box.splice( i, 1);
								});
							} 
							else
							{
								box.length = 0;
							};
							remove( sEvent, box, _self );
						}
						catch( e )
						{
							return this;
						};
					}
					else
					{
						Aui.each( _self.queue, function( i, v )
						{
							remove( i, _self.queue[ i ], _self );
						});
						
						try
						{
							delete _self.queue;
						}
						catch( e )
						{
							_self.queue = undefined;
						};
						
					};
						
				} );
				
				return this;
			},
			
			after : function( arg )
			{
				var _self = this,
					curr = _self[0],
					parent = curr.parentNode,
					nextElem = curr.nextSibling;
					
				while( nextElem.nodeType !== 1 )
				{
					nextElem = nextElem.nextSibling;
				};
				
				this._Aui.insertNode( arg, _self, nextElem, parent );
				
				return _self;
			},
			
			before : function( arg )
			{
				var _self = this,
					curr = _self[0],
					parent = curr.parentNode;
				
				this._Aui.insertNode( arg, _self, curr, parent );
				
				return _self;
			},
			
			append : function( arg )
			{
				var _self = this,
					list = _self[0].children,
					curr = list[ list.length - 1 ];
					
				this._Aui.insertNode( arg, _self, curr, _self[0] );
				
				return _self;
			},
			
			prepend : function( arg )
			{
				var _self = this,
					curr = _self[0].children[0];
					
				this._Aui.insertNode( arg, _self, curr, _self[0] );
				
				return _self;
			},
			
			next : function()
			{
				var _self = this[0],
					nextElem = _self.nextSibling;
				
				while( nextElem.nodeType !== 1 )
				{
					nextElem = nextElem.nextSibling;
				};
				
				return this._Aui.toAui( [ nextElem ] );
			},
			
			prev : function()
			{
				var _self = this[0],
					nextElem = _self.previousSibling;
				
				while( nextElem.nodeType !== 1 )
				{
					nextElem = nextElem.previousSibling;
				};
				
				return this._Aui.toAui( [ nextElem ] );
			},
			
			siblings : function( str )
			{
				var _self = this[0],
					nodes = _self.parentNode.children,
					result = [];
				
					Aui.each( nodes, function()
					{
						if( str )
						{
							this.nodeName.toLowerCase() === str.toLowerCase() && this !== _self && result.push( this );
						}
						else
						{
							this !== _self && result.push( this );
						};
					});
					
					return this._Aui.toAui( result );
			},
			
			remove : function()
			{ 
				Aui.each( this, function()
				{
					this.parentNode.removeChild( this );
				});
				return this;
			}, 
			
			/* on : function( tgt, sEvent, callback )
			{
				this.bind( sEvent, function( ev )
				{
					var elem = ev.target || ev.srcElement;
					
					elem.tagName.toLowerCase() === tgt && callback.call( elem, ev );
				});
				return this;
			},*/
			
			show : function()
			{
				if( this.length )
				{
					Aui.each( this, function()
					{
						this.style.display = "block";
					});
				};
				return this;
			},
			
			hide : function()
			{
				if( this.length )
				{
					Aui.each( this, function()
					{
						this.style.display = "none";
					});
				};
				return this;
			},
			
			// fx v 2.12
			fx : function( json , duration, easing, callback )
			{	
				var _self = this;
				
				Aui.each( _self, function()
				{
					var _this = this;
					
					setTimeout(function()
					{
						_self._Aui.animation.call( _self._Aui, _this, json, duration, callback, easing );
						
						_this.timeout = 0;
						
					}, ( this.timeout || 0 ) )
				});
				
				return _self;
			},
			stop : function()
			{
				var _self = this;
				
				Aui.each( _self, function()
				{
					if( this.isFx )
					{
						clearTimeout( this.timer );
						this.timer = null;
					};
				});
				
				return _self;
			},
			
			delay : function( num )
			{
				var _self = this;
				
				var num = num && typeof num === "number" ? num : 0;
				
				Aui.each( _self, function()
				{
					this.timeout = num;
				});
				
				return this;
			}
			
		};
		
		Aui.easing = {
			easeDefault : function( t, b, c, d )
			{
				return t*c/d+b;
			},
			easeInQuad: function ( t, b, c, d )
			{
				return c*(t/=d)*t + b;
			},
			easeOutQuad: function ( t, b, c, d )
			{
				return -c *(t/=d)*(t-2) + b;
			},
			easeInOutQuad: function ( t, b, c, d )
			{
				if ((t/=d/2) < 1) return c/2*t*t + b;
				return -c/2 * ((--t)*(t-2) - 1) + b;
			},
			easeInCubic: function ( t, b, c, d )
			{
				return c*(t/=d)*t*t + b;
			},
			easeOutCubic: function ( t, b, c, d )
			{
				return c*((t=t/d-1)*t*t + 1) + b;
			},
			easeInOutCubic: function ( t, b, c, d )
			{
				if ((t/=d/2) < 1) return c/2*t*t*t + b;
				return c/2*((t-=2)*t*t + 2) + b;
			},
			easeInQuart: function ( t, b, c, d )
			{
				return c*(t/=d)*t*t*t + b;
			},
			easeOutQuart: function ( t, b, c, d )
			{
				return -c * ((t=t/d-1)*t*t*t - 1) + b;
			},
			easeInOutQuart: function ( t, b, c, d )
			{
				if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
				return -c/2 * ((t-=2)*t*t*t - 2) + b;
			},
			easeInQuint: function ( t, b, c, d )
			{
				return c*(t/=d)*t*t*t*t + b;
			},
			easeOutQuint: function ( t, b, c, d )
			{
				return c*((t=t/d-1)*t*t*t*t + 1) + b;
			},
			easeInOutQuint: function ( t, b, c, d )
			{
				if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
				return c/2*((t-=2)*t*t*t*t + 2) + b;
			},
			easeInSine: function ( t, b, c, d )
			{
				return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
			},
			easeOutSine: function ( t, b, c, d )
			{
				return c * Math.sin(t/d * (Math.PI/2)) + b;
			},
			easeInOutSine: function ( t, b, c, d )
			{
				return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
			},
			easeInExpo: function ( t, b, c, d )
			{
				return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
			},
			easeOutExpo: function ( t, b, c, d )
			{
				return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
			},
			easeInOutExpo: function ( t, b, c, d )
			{
				if (t==0) return b;
				if (t==d) return b+c;
				if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
				return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
			},
			easeInCirc: function ( t, b, c, d )
			{
				return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
			},
			easeOutCirc: function ( t, b, c, d )
			{
				return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
			},
			easeInOutCirc: function ( t, b, c, d )
			{
				if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
				return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
			},
			easeInElastic: function ( t, b, c, d )
			{
				var s=1.70158;var p=0;var a=c;
				if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
				if (a < Math.abs(c)) { a=c; var s=p/4; }
				else var s = p/(2*Math.PI) * Math.asin (c/a);
				return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
			},
			easeOutElastic: function ( t, b, c, d )
			{
				var s=1.70158;var p=0;var a=c;
				if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
				if (a < Math.abs(c)) { a=c; var s=p/4; }
				else var s = p/(2*Math.PI) * Math.asin (c/a);
				return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
			},
			easeInOutElastic: function ( t, b, c, d )
			{
				var s=1.70158;var p=0;var a=c;
				if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
				if (a < Math.abs(c)) { a=c; var s=p/4; }
				else var s = p/(2*Math.PI) * Math.asin (c/a);
				if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
				return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
			},
			easeInBack: function ( t, b, c, d, s) {
				if (s == undefined) s = 1.70158;
				return c*(t/=d)*t*((s+1)*t - s) + b;
			},
			easeOutBack: function ( t, b, c, d, s) {
				if (s == undefined) s = 1.70158;
				return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
			},
			easeInOutBack: function ( t, b, c, d, s) {
				if (s == undefined) s = 1.70158; 
				if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
				return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
			},
			easeInBounce: function ( t, b, c, d )
			{
				return c - Aui.easing.easeOutBounce ( d-t, 0, c, d) + b;
			},
			easeOutBounce: function ( t, b, c, d )
			{
				if ((t/=d) < (1/2.75)) {
					return c*(7.5625*t*t) + b;
				} else if (t < (2/2.75)) {
					return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
				} else if (t < (2.5/2.75)) {
					return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
				} else {
					return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
				}
			},
			easeInOutBounce: function ( t, b, c, d )
			{
				if (t < d/2) return Aui.easing.easeInBounce ( t*2, 0, c, d) * .5 + b;
				return Aui.easing.easeOutBounce ( t*2-d, 0, c, d) * .5 + c*.5 + b;
			}
		};
		
		Aui.toString = function()
		{
			return "Aui v1.52"	
		};
		
		Aui.domain = null;
		
		Aui.contains = function ( parent, child )
		{
			return parent.contains ? parent != child && parent.contains( child ) : !!( parent.compareDocumentPosition( child ) && 16 );
		};
		
		// ҳ??ready
		// =================================================>
		// @mothed : Aui.domReady( ???? )
		// @return : false
			
		Aui.ready = function( fn )
		{
			var loadEvent = [];
			
			var fireContentLoadedEvent = function()
			{
				if ( arguments.callee.loaded ) return false;
				
				arguments.callee.loaded = true;
				
				var handlers = loadEvent, length = loadEvent.length;
				
				for (var i=0; i<length; i+=1 )
				{
				  handlers[ i ]();
				};
			};
			
			var pollDoScroll = function()
			{
				try
				{
					document.documentElement.doScroll("left");
				}
				catch( e )
				{
					setTimeout( arguments.callee, 1 );
					return;
				};
				
				fireContentLoadedEvent();
			};
			
			loadEvent.push( fn );
			
			if( document.addEventListener )
			{
				document.addEventListener( "DOMContentLoaded", fireContentLoadedEvent, false );
			}
			else
			{
				pollDoScroll();
			};
		};
		
		Aui.loadjs = function ( url, callback, charSet )
		{
			var head = document.getElementsByTagName( "head" )[0]
			
				script = document.createElement( "script" ),
				
				charSet = charSet || "utf-8";
			
			script.onload = script.onreadystatechange = script.onerror = function ()
			{
				if ( script && script.readyState && /^(?!(?:loaded|complete)$)/.test( script.readyState ) ) return false;
				
				script.onload = script.onreadystatechange = script.onerror = null;
				
				script.src = "";
				
				script.parentNode.removeChild( script );
				
				script = null;
				
				Aui.isFunction( callback ) && callback();
			};
			
			script.charset = charSet;
			
			script.src = url;
			
			try
			{
				head.appendChild( script );
			}
			catch( e )
			{}
		};

		Aui.loadmultiJS = function ( url, callback, charSet )
		{
			if( Object.prototype.toString.call(url )=== "[object Array]" )
			{
				this.suc = 0;
				
				this.len = url.length;
				
				var a = this;
				
				for( var i = 0; i < url.length; i+=1 )
				{
					Aui.loadjs( url[i], function()
					{ 
						a.suc++;
						
						if( a.suc == a.len )
						{
							try
							{
								Aui.isFunction( callback ) && callback();
							}
							catch( e )
							{ };
						};
					}, charSet );
				};
			}
			else if( typeof url === "string" )
			{
				Aui.loadjs( url, callback, charSet );
			};
			
			return Aui;
		};
		
		// ?????ַ?????????url?ַ???
		// =================================================>
		// @mothed : Aui.makeString( ???? ?? ?ַ??? )
		// @return : string
		
		Aui.makeString = function( data )
		{
			var str = "",
				make = function( d )
				{
					var array = [];
					
					Aui.each( d, function( i, v )
					{
						array.push( i + "=" + v );
					});
					
					return array.join("&");
				};
				
			switch( Aui.typeOf( data ) )
			{
				case "object" :
						str = data;
					break;
						
				case "string" :
				
					if( /^\{{1}[^\s]+\:[^\s]+\}{1}$/g.test( data ) )
					{
						str = eval( "(" + data + ")" );
					}
					else if( /^[\S\s]+\=[\S\s]+$/g.test( data ) )
					{
						return data.replace(/[\"\'\\]+/g,"");
					};
					
					break;
			}
			
			return make( str );
		};
		
		Aui.byID = function( str )
		{
			return [ document.getElementById(  str.substring( 1 ) ) ];
		};
		
		Aui.byTagName = function( str )
		{
			return Aui.fn.makeArray( document.getElementsByTagName( str ) );
		};
		
		Aui.byClass = function( str )
		{
			var _fn = Aui.fn,
				_tagReg = _fn.Aui_RegExp.TAG;
				
			return _fn.getByClass( 
				[ document ],
				_fn.Aui_RegExp.CLASS.exec( str )[0].substring( 1 ),
				_tagReg.test( str ) ? _tagReg.exec( str )[0] : "*"
			);
		};
		
		
		// jsonp ???? ????
		Aui.CrossDomain = function( url, data, callback, str )
		{
			var script = document.createElement("script"),
				target = document.getElementsByTagName("html")[0],
				obj = null;
				
			Aui.domain = function( json )
			{
				obj = json;
			};
			
			script.type = "text/javascript";
			
			script.language = "javascript";
			
			data = Aui.makeString( data );
			
			
			var call = ( str || "cb" ) + "=Aui.domain",
			
				data = data ? "&" + data : "",
				
				isOp = /\?{1}/.test( url ),
				
				domain = isOp ? url.slice( 0, url.search( /\?{1}/ ) ) : url,
				
				option = isOp ? "&" + url.slice( url.search( /\?{1}/ ) + 1 ) + data : data;
			
			script.src = domain + "?" + call + option;
			
			target.appendChild( script );
			
			script.onload = script.onreadystatechange = function()
			{ 
				if (!this.readyState || this.readyState === "loaded" || this.readyState === "complete" )
				{
					callback.call( null, obj );
					
					this.onload = this.onreadystatechange = null;
					
					this.parentNode.removeChild( this );
				};
			};
			
			return obj;
		};
		
		// AJAX????
		// =================================================>
		// @mothed : Aui.ajax( { ·??, ????????, ????, ????, ????ǰ, ????, ?ɹ? } )
		// @return : false
		
		Aui.ajax = function( obj )
		{
			 // escape() 
			 // encodeURIComponent() 
			 // encodeURI
			 
			var XHR = window.XMLHttpRequest ? 
					  new XMLHttpRequest() : 
					  new ActiveXObject("Microsoft.XMLHTTP") || null;
			
			if( !XHR ) return false;
			
			var type = ( obj.type || "get" ).toLowerCase(),
				url = obj.url || "",
				data = obj.data || null,
				code = obj.code || "utf-8",
				error = obj.error || undefined,
				beforeSend = obj.beforeSend || undefined,
				success = obj.success || undefined,
				newData = Aui.makeString( data ),
				newUrl = /\?{1}/.test( url ) ? data ? url.slice( 0, url.search( /\?{1}/ ) ) : url : url;
				
			if( type === "get")
			{
				newData && ( newUrl += "?" + newData );
				newData = null;
			};
				
			XHR.open( type, newUrl, true );
			
			XHR.readyState === 1 && beforeSend != undefined && beforeSend.call(  window, XHR, XHR.readyState, "beforeSend" );
			
			XHR.onreadystatechange = function()
			{
				if ( XHR.readyState === 4 )
				{
					if( XHR.status === 200 )
					{
						success != undefined && success.call( window, XHR.responseText, XHR.status, "success" );
						
						XHR.onreadystatechange = null;
						XHR = null;
					}
					else
					{
						error != undefined && error.call( window, XHR, XHR.status, "error" );
						
						XHR.onreadystatechange = null;
						XHR = null;
					};
					
				};
			};
			
			type === "post" && XHR.setRequestHeader( "Content-Type","application/x-www-form-urlencoded;charset="+ code +"" );
			
			XHR.send( newData );
			
		};
		
		Aui.isString = function( str )
		{
			return str && typeof str === "string";
		};
		
		Aui.isFunction = function( fn )
		{
			return fn && typeof fn === "function";
		};
		
		Aui.trim = function( str, o )
		{
			return str.replace( o ? o === "all" ? /\s+/g : o === "left" ? /^\s+/g : o === "right" ? /\s+$/g : undefined : /(^\s+)|(\s+$)/g , "" );
		};
		
		Aui.browser = function()
		{
		   var sAgent = navigator.userAgent.toLowerCase(),
			   result = "";
			   
		   Aui.each( [ "msie","firefox","chrome","opera","safari","camino","gecko"], function()
		   {
				if ( sAgent.match( RegExp( this,"g" ) ) )
				{
					if( /msie/g.test( this ) )
					{
						result = sAgent.match( /ie\s?\d{1}/ig )[0].replace(/\s/g,"");
					}
					else
					{
						result = this;
					};
					return false;
				};
		   });
		   return result;
		};
		// ??̬Ԫ?ر???
		// =================================================>
		// @mothed : Aui.each( ???? )
		// @return : Aui Object
			
		Aui.each = function( object, callback )
		{
			var sType = Aui.typeOf( object ),
				fnType = Aui.isFunction( callback ), k;
			
			if( sType === "array" || sType === "Aui" || sType === "dom" )
			{
				var len = object.length;
				
				!len && fnType && callback.call( object, 0, object );
				
				for( k = 0; k<len; k+=1 )
				{
					if( fnType && callback.call( object[ k ], k, object[ k ] ) === false ) return false;
				};
			}
			else if( sType === "object" )
			{
				for( k in object )
				{
					if( fnType && callback.call( object[ k ], k, object[ k ] ) === false ) return false;
				};
			};
			return object;
		};
		
		// ?ж?????????,????һ???ַ??? => .typeOf( ???????? )
		// ===================================================>
		// ????ָ??????????
		// @mothed : Aui.typeOf( obj ) 
		// @return : string => "string"
		
		Aui.typeOf = function ( obj )
		{
			var typeObj = {}, i,
				types = [ "Boolean", "Number", "String", "Function", "Array", "Date", "RegExp", "Object" ],
				sLength = types.length;
				
			for(i = 0; i< sLength; i+=1 )
			{
				typeObj[ "[object " + types[ i ] + "]" ] = types[ i ].toLowerCase();
			};
			var str = obj == null ? 
					  String( obj ) : 
					  typeObj[ Aui_core_toString.call( obj ) ] || "dom";
			
			return str === "object" ?
				   Aui_core_toString.call( obj ) === "[object Object]" ?
				   obj.constructor === "Aui" ?
				   "Aui" :
				   "object" :
				   "dom" :
				   str;
		};
		
		var sEvent = ("blur|focus|load|resize|scroll|unload|click|dblclick|mousedown|mouseup|mousemove|mouseover|mouseout|change|reset|select|submit|keydown|keypress|keyup|error" ).split("|"); 
				
		Aui.each( sEvent, function()
		{
			var evt = this;
			
			Aui.fn.init.prototype[ evt ] = function( func )
			{
				func && Aui.isFunction( func ) && Aui.each( this, function()
				{
					this[ "on" + evt ] = func;
				});
			};
		});
		
		Aui.extend = function( target, curr )
		{
			if( typeof target === "object" && Aui.typeOf( curr ) === "object" )
			{
				Aui.each( curr, function( i, v )
				{
					target[ i ] = v;
				});
			};
			return target;
		};
		
		Aui.fn.extend = function ( object )
		{
			return Aui.extend.call( Aui, Aui.fn.init.prototype, object );
		};
		
	window.$ = window.Aui = Aui;
	
})( window )