/*global sargasRecaptcha, grecaptcha  */

var recaptchaFieldController = Marionette.Object.extend( {
	fieldType: 'sargas_recaptcha',
	recaptchaCallback: window[sargasRecaptcha.recaptchaCallback],
	
	initialize: function() {
		this.listenTo( nfRadio.channel( this.fieldType ), 'init:model',   this.initActions  );
		this.listenTo( nfRadio.channel( 'form' ), 'render:view', this.renderCaptcha );
		this.listenTo( nfRadio.channel( 'submit' ), 'validate:field', this.validate );
		this.listenTo( nfRadio.channel( 'forms' ), 'submit:response', this.actionSubmit );
		
		nfRadio.channel( this.fieldType ).reply( 'get:submitData', this.getSubmitData );
	},
	
	validate: function( model ) {
		if( this.fieldType !== model.get( 'type' ) ) {
			return;
		}
		
		const recaptcha = jQuery( '#nf-field-' + model.get('id') + '-container' );
		const token = recaptcha.find( '.g-recaptcha-response' ).val();
		model.set( 'value', token );

		if ( model.get( 'invalid' ) ) {
			nfRadio.channel( 'fields' ).request( 'remove:error', model.get('id') , 'required-error' );
		}
	},
	
	actionSubmit: function( form ) {
		const recaptcha = jQuery( '#nf-form-'  + form.data.form_id +  '-cont' ).find( '.sargas-recaptcha-wrapper' );
		
		//Reset reCAPTCHA, if the form has server errors
		if ( 0 !== form.errors.length ) {
			this.resetRecaptcha( recaptcha );
		}
	},
	
	resetRecaptcha: function ( recaptcha ) {
		if ( 'v2' === sargasRecaptcha.type ) {
			grecaptcha.reset( recaptcha );
		} else {
			onLoadCallbackV3();
		}
	},
	
	getSubmitData: function( fieldData ) {
		const recaptcha = jQuery( '#nf-field-' + fieldData.id + '-container' );
		const token = recaptcha.find( '.g-recaptcha-response' ).val();

		fieldData.value = token;

		return fieldData;
	},
	
	initActions: function ( model ) {
		nfRadio.channel( this.fieldType  ).reply( 'update:field', this.updateField, this, model );
	},
	
	updateField: function( fieldID ) {
		const model = nfRadio.channel( 'fields' ).request( 'get:field', fieldID );
		const recaptcha = jQuery( '#nf-field-' + fieldID + '-container' );
		const token = recaptcha.find( '.g-recaptcha-response' ).val();
		
		if ( model.get( 'invalid' ) && !! token.length ) {
			model.set( 'value', token );
			nfRadio.channel( 'fields' ).request( 'remove:error', model.get('id') , 'required-error' );
		}
	},
	
	renderCaptcha: function() {
		if ( 'function' === typeof this.recaptchaCallback ) {
				const that = this;
				
				grecaptcha.ready( function() {
					that.recaptchaCallback();
				} );
		}
	}
	
});

( function ( $ ) {
	$( document ).ready( function () {
		const sargasRecaptchaController = new recaptchaFieldController();

		$( window ).on( 'load', function () {
			$( '.nf-form-content' ).find( '.sargas-recaptcha-wrapper' ).on( 'focusin', function() {
				const id = $( this ).parent().data( 'id' );
				
				nfRadio.channel( sargasRecaptchaController.fieldType ).request( 'update:field', id );
			} );
		} );
	} );
} )( jQuery );
