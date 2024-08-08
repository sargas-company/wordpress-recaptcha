/*global sargasTestKeysData, grecaptcha  */

const errorMessage = jQuery( '#sargas-recaptcha-keys-verification-error' );
const successMessage = jQuery( '#sargas-recaptcha-keys-verification-success' );
const recaptchaWrapper = jQuery( '.sargas-recaptcha-wrapper' );

( function ( $ ) {
  $( document ).ready( function () {
    $( window ).on( 'load', function () {
      const form = $( '.sargas-recaptcha-test-keys-form' );
      const submitButton = $( form.find(':submit') );
      const loader = $( form.find( '.sargas-recaptcha-loader' ) );

      if ( 'undefined' === typeof grecaptcha ) {
        errorMessage.text( sargasTestKeysData.translations.keys_type_error );
        submitButton.hide();
        return;
      }
      
      submitButton.click( function ( event ) {
        event.preventDefault();
        
        const token = $( form.find('.g-recaptcha-response') ).val();
        
        $.ajax( {
          type: 'POST',
          url: sargasTestKeysData.ajax_url,
          dataType: 'json',
          data: {
            _sargas_nonce: sargasTestKeysData.ajax_nonce,
            action: 'sargas_recaptcha_test',
            'g-recaptcha-response': token
          },
          beforeSend: function () {
            loader.show();
          },
          success: function ( response ) {
            successMessage.show();
            successMessage.text( response );
            errorMessage.hide();
            submitButton.hide();
          },
          error: function ( xhr ) {
            errorMessage.show();
            errorMessage.text( xhr.responseJSON.data.message )
            successMessage.hide();
            loader.hide();
          },
          complete: function () {
            loader.hide();
          }
        } );
      } );
    } );
  } );
})( jQuery );

function onLoadCallbackV3() {
  grecaptcha.ready(
    function () {
      try {
        grecaptcha
          .execute( sargasTestKeysData.siteKey, { action: 'sargas_recaptcha_test_keys' })
          .then( function( token ) {
            document
              .querySelectorAll('.g-recaptcha-response')
              .forEach(function ( element ) {
                element.value = token
              } );
  
            errorMessage.hide();
            successMessage.text( sargasTestKeysData.translations.successfully_displayed );
          } );
      } catch ( error ) {
        successMessage.hide();
        errorMessage.text( sargasTestKeysData.translations.verification_failed + ' : ' + error.message );
      }
    }
  )
}

function onLoadCallbackV2() {
  grecaptcha.ready(
    function () {
      try {
        grecaptcha.render( recaptchaWrapper[0], {
          'sitekey': sargasTestKeysData.siteKey,
        } );
      } catch ( error ) {
        successMessage.hide();
        errorMessage.text( sargasTestKeysData.translations.verification_failed + ' : ' + error.message );
      }
  } );
}
