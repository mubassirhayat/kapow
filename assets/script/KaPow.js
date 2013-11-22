!function( $ )
{
    "use strict";

    var KaPow = {
        hasBeenGoogleMapsLoaded : false,
        version                 : 0.5
    };
    
    var KaPowVideo = function( element, options )
    {
        this.options   = $.extend( {}, $.fn.KaPowVideo.defaults, options );
        this.element   = element;
        this.$element  = $( element );
        this._isMobile = null;
        this.player    = null;

        if( this.isMobile() )
        {
            this._setupHTML5();
        }
        else
        {
            this._setupFlash();
        }
    };

    KaPowVideo.prototype = {

        constructor : KaPowVideo
        
        // private: try to apply availables callbacks
        , _callback : function( reason, context )
        {
            context = context || this.$element;
            
            if( this.options[ reason ] instanceof Function )
            {
                this.options[ reason ].apply( context );
            }
        }

        , _javascriptFlashBridge : function( id, eventName, updatedProperties )
        {
            var player = document.getElementById( id );

            if( player.getState() == 'ready' )
            {
                if( !player.completeEventFired )
                {
                    player.completeEventFired = true;
                    player.instance._callback( 'onEnded', player.instance );
                }
            }
        }

        , _onFlashCreated : function()
        {
            var player = document.getElementById( this.element.id );
            
            if( player )
            {
                player.instance           = this;
                player.completeEventFired = false;
                player.className          = this.element.className;
            }
        }

        , _setupFlash : function()
        {
            if( window.swfobject && swfobject.hasFlashPlayerVersion( this.options.minFlashVersion ) )
            {
                var flashvars = {
                    src                        : this.options.video.f4v + '&autoHideControlBar=' + this.options.autoHideFlashControlBar + '&loop=' + this.options.flashPlayerLoop + '&autoPlay=' + this.options.flashPlayerAutoPlay,
                    controlBarMode             : this.options.showFlashControlBar ? '' : 'none',
                    javascriptCallbackFunction : this._javascriptFlashBridge
                };

                var params = {
                    name              : this.element.id
                  , menu              : 'false'
                  , allowfullscreen   : 'true'
                  , wmode             : 'transparent'
                  , bgcolor           : '#000000'
                  , allowScriptAccess : 'always'
                };

                swfobject.embedSWF( this.options.flashPlayer, this.element.id, this.options.width, this.options.height, this.options.minFlashVersion, '', flashvars, params, '', $.proxy( this._onFlashCreated, this ) );
            }
        }

        , _setupHTML5 : function()
        {
            var $video = $( '<video />', { 
                id       : this.element.id,
                src      : this.options.video.mp4,
                width    : this.options.width,
                height   : this.options.height,
                autoplay : true,
                controls : this.isMobile() ? 'controls' : false
            } );

            this.$element.replaceWith( $video );
            this.player = $video[ 0 ];

            this.player.addEventListener( 'ended', $.proxy( this._onVideoEnded, this ), false );
        }

        , isMobile : function()
        {
            if( null == this._isMobile )
            {
                var userAgent = navigator.userAgent
                  , iPad      = userAgent.match( /iPad/i ) != null
                  , iPhone    = userAgent.match( /iPhone/i ) != null
                  , iPod      = userAgent.match( /iPod/i ) != null
                  , android   = userAgent.match( /Android/i ) != null;

                this._isMobile = iPad || iPhone || iPod || android;
            }

            return this._isMobile;
        }

        , _onVideoEnded : function()
        {
            this._callback( 'onEnded', this );
        }

        , play : function()
        {

        }

        , stop : function()
        {
        }
    };

    $.fn.KaPowVideo = function ( option )
    {
        return this.each( function()
        {
            var $this   = $( this )
              , data    = $this.data( 'KaPowVideo' )
              , options = typeof option == 'object' && option;
              
            if( !data ) $this.data( 'KaPowVideo', ( data = new KaPowVideo( this, options ) ) );
            if( typeof option == 'string' && option.indexOf( '_' ) < 0 ) data[ option ]();
        } );
    };

    $.fn.KaPowVideo.defaults = {
        video                   : '',
        width                   : 560,
        height                  : 315,
        minFlashVersion         : '10.1.52',
        showFlashControlBar     : true,
        autoHideFlashControlBar : true,
        flashPlayerLoop         : false,
        flashPlayerAutoPlay     : true,
        flashPlayer             : 'StrobeMediaPlayback.swf'
    };

    $.fn.KaPowVideo.Constructor = KaPowVideo;

    /*
     * KaPowGoogleMap
     *
     * ------
     * usage: $( element ).KaPowGoogleMap();
     * v 1.0
     **/
     /*
    var KaPowGoogleMap = function( element, options )
    {
        this.options  = $.extend( {}, $.fn.KaPowGoogleMap.defaults, options );
        this.element  = element;
        this.$element = $( element );
        this.map      = null;

        this._setup();

        if( window.google )
        {
            this._create();
        }
    };

    KaPowGoogleMap.prototype = {

        constructor : KaPowGoogleMap
        
        // private: try to apply availables callbacks
        , _callback : function( reason, context )
        {
            context = context || this.$element;
            
            if( this.options[ reason ] instanceof Function )
            {
                this.options[ reason ].apply( context );
            }
        }

        , _setup : function()
        {
            if( !KaPow.hasBeenGoogleMapsLoaded )
            {
                var script  = document.createElement( 'script' );
                script.type = 'text/javascript';
                script.src  = 'http://maps.google.com/maps/api/js?sensor=false&#038;ver=3.5.1';
                document.body.appendChild( script );

                KaPow.hasBeenGoogleMapsLoaded = true;
            }
        }

        , _create : function()
        {
            this.map = new google.maps.Map( this.element, mapOptions );
        }
    };

    $.fn.KaPowGoogleMap = function ( option )
    {
        return this.each( function()
        {
            var $this   = $( this )
              , data    = $this.data( 'KaPowGoogleMap' )
              , options = typeof option == 'object' && option;
              
            if( !data ) $this.data( 'KaPowGoogleMap', ( data = new KaPowGoogleMap( this, options ) ) );
            if( typeof option == 'string' && option.indexOf( '_' ) < 0 ) data[ option ]();
        } );
    };

    $.fn.KaPowGoogleMap.defaults    = {};
    $.fn.KaPowGoogleMap.Constructor = KaPowGoogleMap;
    */
    $.fn.googlemap = function( options )
    {

        var opt = $.extend( {
            markers         : [],
            type            : 'roadmap',
            zoom            : 10,
            center          : '',
            autoCenter      : true,
            controls        : {},
            controlsOptions : {},
            bubbleOptions   : {}
        }, options );

        var controls = $.extend( {
            disableDefaultUI    : false,
            scaleControl        : true,
            navigationControl   : true,
            panControl          : true,
            zoomControl         : true,
            mapTypeControl      : true,
            streetViewControl   : false,
            overviewMapControl  : true
        }, opt.controls );
        
        var controlsOptions = $.extend( 
        {
            panControlOptions : {
                position : google.maps.ControlPosition.TOP_RIGHT
            },
            mapTypeControlOptions: {
                style    : google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position : google.maps.ControlPosition.TOP_LEFT
            },
            zoomControlOptions: {
                style    : google.maps.ZoomControlStyle.LARGE,
                position : google.maps.ControlPosition.LEFT_CENTER
            },
            scaleControlOptions: {
                position : google.maps.ControlPosition.TOP_LEFT
            },
            streetViewControlOptions: {
                position : google.maps.ControlPosition.LEFT_TOP
            }
        }, opt.controlsOptions );


        var mapTypes = {
            hybrid      : 'HYBRID',
            roadmap     : 'ROADMAP',
            satellite   : 'SATELLITE',
            terrain     : 'TERRAIN'
        };
        
        return this.each(function()
        {
                
            var centers = opt.center 
                        ? opt.center.split( ',' ) 
                        : opt.markers[0].coord.split( ',' ); 
            
            var mapOptions = {
                zoom                        : opt.zoom,
                center                      : new google.maps.LatLng( centers[0], centers[1] ),
                mapTypeId                   : google.maps.MapTypeId[mapTypes[opt.type]],

                disableDefaultUI            : controls.disableDefaultUI,
                scaleControl                : controls.scaleControl,
                navigationControl           : controls.navigationControl,
                panControl                  : controls.panControl,
                zoomControl                 : controls.zoomControl,
                mapTypeControl              : controls.mapTypeControl,
                streetViewControl           : controls.streetViewControl,
                overviewMapControl          : controls.overviewMapControl,

                panControlOptions           : controlsOptions.panControlOptions,
                mapTypeControlOptions       : controlsOptions.mapTypeControlOptions,
                zoomControlOptions          : controlsOptions.zoomControlOptions,
                scaleControlOptions         : controlsOptions.scaleControlOptions,
                streetViewControlOptions    : controlsOptions.streetViewControlOptions
            };
    
            var map        = new google.maps.Map( this, mapOptions );
            var infowindow = null;
            var count      = opt.markers.length;
            var markers    = [];
            
            infowindow = new google.maps.InfoWindow( { content : 'holding...' } );

            for( var i = 0; i < count; i++ )
            {
                
                var mark = opt.markers[i];
                
                var coords          = mark.coord.split( ',' );
                var markerLatLng    = new google.maps.LatLng( coords[0], coords[1] );
                
                var marker = new google.maps.Marker(
                    { position: markerLatLng, map: map }
                );
    
                if( mark.image )
                    marker.icon = mark.image;
    
                if( mark.title )
                    marker.title = mark.title;
    
                if( mark.content )
                {
                    marker.html = mark.content;
                    
                    if( mark.maxWidth )
                    {
                        infowindow.maxWidth = mark.maxWidth;
                    }

                    google.maps.event.addListener( marker, 'click', function()
                    {
                        infowindow.setContent( this.html );
                        infowindow.open( map, this );
                    });
                }
    
                markers.push( marker );
            }
            
            if( count > 1 && !opt.center && opt.autoCenter )
            {
                var bounds = new google.maps.LatLngBounds();
                
                $.each( markers, function ( index, marker )
                {
                    bounds.extend( marker.position );
                } );
                
                map.fitBounds( bounds );
            }

        });
    };  

    /*
     * KaPowValidation
     *
     * simple form validation
     * usage: $( element ).KaPowValidation();
     * v 1.0
     **/
    var KaPowValidation = function( element, options )
    {
        this.options  = $.extend( {}, $.fn.KaPowValidation.defaults, options );
        this.$element = $( element );
        this.$fields  = this.$element.find( '.' + this.options.requiredClassName );
        this.result   = false;

        this.$element.on( 'submit', $.proxy( this._onSubmit, this ) );
    };

    KaPowValidation.prototype = {

        constructor : KaPowValidation
        
        // private: try to apply availables callbacks
        , _callback : function( reason, context )
        {
            context = context || this.$element;
            
            if( this.options[ reason ] instanceof Function )
            {
                return this.options[ reason ].apply( context );
            }
        }

        , _onSubmit : function( e )
        {
            var error = false
              , that  = this;

            this.$fields.each( function()
            {
                var $field  = $( this )
                  , isEmail = $field.attr( 'name' ).toLowerCase().indexOf( 'mail' ) > 0
                  , isEmpty = !$field.val() || ( isEmail && !that.options.filterMail.test( $field.val() ) ) || ( $field.is( 'input[type=checkbox]' ) && !$field.is( ':checked' ) );

                $field[ isEmpty ? 'addClass' : 'removeClass' ]( that.options.errorClassName );
                error = isEmpty ? true : error;
            } );

            this.result = !error;
            this._callback( 'onValidation', this );

            if( this.result )
            {
                if( this.options.onSuccess instanceof Function )
                {
                    return this._callback( 'onSuccess', this );
                }
            }
            else
            {
                if( this.options.onError instanceof Function )
                {
                    return this._callback( 'onError', this );
                }
            }

            return this.result;
        }
    };

    $.fn.KaPowValidation = function ( option )
    {
        return this.each( function()
        {
            var $this   = $( this )
              , data    = $this.data( 'KaPowValidation' )
              , options = typeof option == 'object' && option;
              
            if( !data ) $this.data( 'KaPowValidation', ( data = new KaPowValidation( this, options ) ) );
            if( typeof option == 'string' && option.indexOf( '_' ) < 0 ) data[ option ]();
        } );
    };

    $.fn.KaPowValidation.defaults = {
        errorClassName    : 'error',
        requiredClassName : 'required',
        onError           : null,
        onSuccess         : null,
        onValidation      : null,
        filterMail        : /^[\w](([_\.-]?[\w]+)*)@([\w]+)(([\.-]?[\w]+)*)\.([A-Za-z]{2,})$/
    };

    $.fn.KaPowValidation.Constructor = KaPowValidation;

    /*
     * KaPowOrganizer
     *
     * allow the user to create a context with autocalled methods when the page slug match the method name
     * usage: $.fn.KaPowOrganizer( { context : this|window|varname } );
     * v 1.0
     **/
    var KaPowOrganizer = function( element, options )
    {
        this.options = $.extend( {}, $.fn.KaPowOrganizer.defaults, options );
        this._extractPages();
        this._autocall( this.options.context );
    };

    KaPowOrganizer.prototype = {

        constructor : KaPowOrganizer
        
        // private: try to apply availables callbacks
        , _callback : function( reason, context )
        {
            context = context || this.$element;
            
            if( this.options[ reason ] instanceof Function )
            {
                this.options[ reason ].apply( context );
            }
        }

        , _extractPages : function( deleteValue )
        {
            this.options.pages = location.pathname.split( '/' );
        }

        , _autocall : function( obj )
        {
            if( this.options.pages instanceof Array && this.options.pages.length )
            {
                var count = this.options.pages.length;
                
                for( var i = 0; i < count; i++ )
                {
                    var page = this.options.pages[ i ].replace( /-/g, '_' )
                      , f    = obj[ page ];
                
                    if( f instanceof Function )
                    {
                        f.call( obj );
                    }
                }
                
            }
            
            if( this.options.pages.length <= 2 && this.options.pages[ 0 ] == '' )
            {
                var f = obj.frontpage;
            
                if( f instanceof Function )
                {
                    f.call( obj );
                }
            }
            
            if( obj.all_pages instanceof Function )
            {
                obj.all_pages.call( obj );
            }
        }
    };

    $.fn.KaPowOrganizer = function ( option )
    {
        var options = typeof option == 'object' && option;
          
        if( !this.organizer ) this.organizer = new KaPowOrganizer( this, options );
        if( typeof option == 'string' && option.indexOf( '_' ) < 0 ) this.organizer[ option ]();
    };

    $.fn.KaPowOrganizer.defaults = {
        context : window,
        pages   : []
    };

    $.fn.KaPowOrganizer.Constructor = KaPowOrganizer;

}( window.jQuery );