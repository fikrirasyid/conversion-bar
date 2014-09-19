(function( $ ) {
	$( document ).ready(function(){

		/**
		 * Load more content
		 */
		$('body').on( 'click', '#conversion-bar-load-more-content', function(e){
			e.preventDefault();

			var button 				= $(this);
			var loading				= $('#conversion-bar-loading-image');
			var href 				= button.attr( 'href' );
			var paged 				= button.attr( 'data-paged' );
			var conversion_bar_id 	= button.attr( 'data-conversion-bar-id' );
			var _wpnonce 			= button.attr( 'data-nonce' );

			/**
			 * Display loading state
			 */
			button.hide();
			loading.show().css( 'display', 'block' );

			$.ajax({
				url	: href,
				type: "POST",
				data: {
					paged : paged,
					conversion_bar_id : conversion_bar_id,
					_wpnonce : _wpnonce
				}
			}).done(function( response ){
				if( '<li>No Post Found</li>' != response ){
					/**
					 * Append data to list
					 */
					$(response).appendTo('#conversion-bar-targets');

					/**
					 * Update paged data
					 */
					var new_paged = parseInt( paged ) + 1;
					button.attr( 'data-paged', new_paged );

					/**
					 * End loading state
					 */
					button.show();
					loading.hide();					
				} else {
					$('#conversion-bar-targets').append('<li style="text-align: center; padding: 10px 0;">All content has been displayed!</li>');					
				}
			});
		});
	});
})( jQuery );
