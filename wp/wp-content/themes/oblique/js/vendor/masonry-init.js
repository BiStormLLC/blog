
//Masonry init
jQuery(function($) {

    var $container;

    function nsc_trigger_masonry() {
        // don't proceed if $grid has not been selected
        if ( !$container ) {
            return;
        }
        masonryInit = false;
        $container.show();
        
        twttr.ready(function (twttr) {
            twttr.events.bind('loaded', function (event) {
               $('.grid-layout').masonry('reloadItems');
               nsc_trigger_masonry();
            });
        });

        // init Masonry
        $container.imagesLoaded( function() {
            $container.masonry({
                itemSelector: '.hentry',
                isAnimated: true,
                animationOptions: {
                    duration: 300,
                    easing: 'linear'
                }
            });
        });
    }

    $(window).load(function(){
        $container = $('.grid-layout'); // this is the grid container
        masonryInit = true;
        nsc_trigger_masonry();

        $.fn.almComplete = function(alm){ // Ajax Load More callback function
            var $container = $('.grid-layout'); // our container
            if(masonryInit){
              // initialize Masonry only once
              nsc_trigger_masonry();
            }else{
              $container.masonry('reloadItems');
              nsc_trigger_masonry();
            }
        };
    });

});

Masonry.prototype._getItemLayoutPosition = function(item) {
	item.getSize();
	// how many columns does this brick span
	var remainder = item.size.outerWidth % this.columnWidth;
	var mathMethod = remainder && remainder < 1 ? 'round' : 'ceil';
	// round if off by 1 pixel, otherwise use ceil
	var colSpan = Math[mathMethod](item.size.outerWidth / this.columnWidth);
	colSpan = Math.min(colSpan, this.cols);

	var colGroup = this._getColGroup(colSpan);
	// get the minimum Y value from the columns
	//var minimumY = Math.min.apply( Math, colGroup );
	//var shortColIndex = colGroup.indexOf( minimumY );
	var shortColIndex = this.items.indexOf(item) % this.cols;
	var minimumY = colGroup[shortColIndex];

	// position the brick
	var position = {
		x: this.columnWidth * shortColIndex,
		y: minimumY
	};

	// apply setHeight to necessary columns
	var setHeight = minimumY + item.size.outerHeight;
	var setSpan = this.cols + 1 - colGroup.length;
	for (var i = 0; i < setSpan; i++) {
		this.colYs[shortColIndex + i] = setHeight;
	}

	return position;
};