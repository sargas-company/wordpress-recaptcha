/*global sargasRecaptcha  */
( function ( $ ) {
	const recaptchaCallback = window[sargasRecaptcha.recaptchaCallback];

	if ( 'function' === typeof recaptchaCallback ) {
		$( document ).on( 'gform_page_loaded', function( event, form_id, current_page ) {
			//reload reCAPTCHA after AJAX form submission
			recaptchaCallback();
			
		} );
	}
} )( jQuery );