/*global sargasFeatureRequestData  */

(function ($ ) {
	$( document ).ready( function () {
		$( window ).on( 'load', function () {
			
			const wrapper = $( '.sargas-feature-request' );
			const form = $( '.sargas-feature-request-form' );
			const loader = form.find( '.sargas-recaptcha-loader' );
			const successMessage = wrapper.find( '.sargas-recaptcha-success-message' );
			const apiErrorMessage = wrapper.find( '.api-error' );
			const validationErrorMessage = wrapper.find( '.sargas-recaptcha-validation-error' );
			const submitButton = form.find( '.submit' );
			
			$( '#sargas-feature-request-textarea' ).keyup( function () {
				if ( '' !== validationErrorMessage.text() ) {
					$( this ).removeClass('focus');
					validationErrorMessage.text( '' );
				}
			} );
			
			submitButton.click( function ( event ) {
				event.preventDefault();
				
				const isAnonymously = $( '#sargas-recaptcha-is-anonymously' ).prop('checked');
				const textarea = $( '#sargas-feature-request-textarea' );
				const message = textarea.val();
				
				if ( '' === message || undefined === message ) {
					textarea.addClass( 'focus' );
					validationErrorMessage.text( sargasFeatureRequestData.validation.empty_field.error );
					validationErrorMessage.show();
					
					return
				}
				
				if ( message.length > sargasFeatureRequestData.validation.max_length.value ) {
					textarea.addClass( 'focus' );
					validationErrorMessage.text( sargasFeatureRequestData.validation.max_length.error );
					validationErrorMessage.show();
					
					return
				}
				
				function clearErrors () {
					loader.show();
					textarea.removeClass( 'focus' );
					validationErrorMessage.hide();
					apiErrorMessage.hide();
					successMessage.hide();
				}
				
				$.ajax({
					type: 'POST',
					url: sargasFeatureRequestData.ajax_url,
					dataType: 'json',
					data: {
						_sargas_nonce: sargasFeatureRequestData.ajax_nonce,
						action: 'sargas_feature_request',
						isAnonymously,
						message,
					},
					beforeSend: function () {
						clearErrors();
					},
					success: function () {
						successMessage.show();
						textarea.val( '' );
					},
					error: function ( xhr ) {
						const response = JSON.parse( xhr.responseText );
						apiErrorMessage.text( response.data.message );
						apiErrorMessage.show();
						successMessage.hide();
					},
					complete: function () {
						loader.hide();
					}
				})
			})
		})
	})
	
})( jQuery )