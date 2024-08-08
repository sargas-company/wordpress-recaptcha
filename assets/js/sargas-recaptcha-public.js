function onLoadCallbackV2() {
  const recaptchas = jQuery( '.sargas-recaptcha-wrapper:empty' );

  for ( let i = 0; i < recaptchas.length; i++ ) {
    grecaptcha.render( recaptchas[i], {
      'sitekey': sargasRecaptcha.siteKey,
    } );
  }
}
function onLoadCallbackV3() {
  try {
    grecaptcha
      .execute(sargasRecaptcha.siteKey, { action: 'submit' })
      .then( function(token) {
        document
          .querySelectorAll('.g-recaptcha-response')
          .forEach(function (element) {
            element.value = token;
          });
      });
  } catch (e) {
    console.log(e.message)
  }
}