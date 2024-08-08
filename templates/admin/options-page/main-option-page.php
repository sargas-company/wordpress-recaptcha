<div class="wrap sargas-recaptcha">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<?php settings_errors(); ?>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2">
            <form action="<?php echo esc_html( admin_url( 'options.php' ) ); ?>" method="post">
                <div id="post-body-content">

                    <h2 class="nav-tab-wrapper">
                        <a href="<?php echo admin_url( 'admin.php?page=sargas-recaptcha&tab=settings' ) ?>"
                           class="nav-tab <?php echo ! isset( $_GET['tab'] ) || ( 'settings' === $_GET['tab'] ) ? esc_html( 'nav-tab-active' ) : ''; ?>"
                        >
							<?php esc_html_e( 'General', 'sargas-recaptcha' ); ?>
                        </a>
                        <a href="<?php echo admin_url( 'admin.php?page=sargas-recaptcha&tab=standard-forms' ) ?>"
                           class="nav-tab <?php echo ( isset( $_GET['tab'] ) && 'standard-forms' === $_GET['tab'] ) ? esc_html( 'nav-tab-active' ) : ''; ?>">
							<?php echo esc_html( 'WordPress' ); ?>
                        </a>
                        <a href="<?php echo admin_url( 'admin.php?page=sargas-recaptcha&tab=wc' ) ?>"
                           class="nav-tab <?php echo ( isset( $_GET['tab'] ) && 'wc' === $_GET['tab'] ) ? esc_html( 'nav-tab-active' ) : ''; ?>">
							<?php echo esc_html( 'WooCommerce' ); ?>
                        </a>

                        <a href="<?php echo admin_url( 'admin.php?page=sargas-recaptcha&tab=mc4wp' ) ?>"
                           class="nav-tab <?php echo ( isset( $_GET['tab'] ) && 'mc4wp' === $_GET['tab'] ) ? esc_html( 'nav-tab-active' ) : ''; ?>">
							<?php esc_html_e( 'Mailchimp for WordPress', 'sargas-recaptcha' ); ?>
                        </a>

                        <a href="<?php echo admin_url( 'admin.php?page=sargas-recaptcha&tab=nf' ) ?>"
                           class="nav-tab <?php echo ( isset( $_GET['tab'] ) && 'nf' === $_GET['tab'] ) ? esc_html( 'nav-tab-active' ) : ''; ?>">
							<?php esc_html_e( 'Ninja Forms', 'sargas-recaptcha' ); ?>
                        </a>

                        <a href="<?php echo admin_url( 'admin.php?page=sargas-recaptcha&tab=gf' ) ?>"
                           class="nav-tab <?php echo ( isset( $_GET['tab'] ) && 'gf' === $_GET['tab'] ) ? esc_html( 'nav-tab-active' ) : ''; ?>">
							<?php esc_html_e( 'Gravity Forms', 'sargas-recaptcha' ); ?>
                        </a>

                    </h2>

                    <div>
                        <div id="tab-settings"
                             style="display: <?php echo ! isset( $_GET['tab'] ) || ( $_GET['tab'] === 'settings' ) ? esc_html( 'block;' ) : esc_html( 'none;' ); ?>"
                             class="meta-box-sortables ui-sortable active">
                            <div class="postbox">
                                <div class="inside">
									<?php
									settings_fields( 'sargas_recaptcha_option_group' );
									do_settings_sections( 'sargas-recaptcha-menu-page-general' );
									submit_button( esc_html__( 'Save Changes', 'sargas-recaptcha' ) );
									?>
                                </div>
                            </div>
                        </div>

                        <div id="tab-standard-forms"
                             style="display: <?php echo ( isset( $_GET['tab'] ) && $_GET['tab'] === 'standard-forms' ) ? esc_html( 'block;' ) : esc_html( 'none;' ); ?>"
                             class=" meta-box-sortables ui-sortable">
                            <div class="postbox">
                                <div class="inside">
									<?php
									settings_fields( 'sargas_recaptcha_option_group' );
									do_settings_sections( 'sargas-recaptcha-menu-page-standard-forms' );
									submit_button( esc_html__( 'Save Changes', 'sargas-recaptcha' ) );
									?>
                                </div>
                            </div>
                        </div>

                        <div id="tab-wc"
                             style="display: <?php echo ( isset( $_GET['tab'] ) && $_GET['tab'] === 'wc' ) ? esc_html( 'block;' ) : esc_html( 'none;' ); ?>"
                             class="meta-box-sortables ui-sortable">
                            <div class="postbox">
                                <div class="inside">
									<?php
									settings_fields( 'sargas_recaptcha_option_group' );
									do_settings_sections( 'sargas-recaptcha-menu-page-wc-forms' );
									submit_button( esc_html__( 'Save Changes', 'sargas-recaptcha' ) );
									?>
                                </div>
                            </div>
                        </div>

                        <div id="tab-mc4wp"
                             style="display: <?php echo ( isset( $_GET['tab'] ) && $_GET['tab'] === 'mc4wp' ) ? esc_html( 'block;' ) : esc_html( 'none;' ); ?>"
                             class="meta-box-sortables ui-sortable">
                            <div class="postbox">
                                <div class="inside">
									<?php
									settings_fields( 'sargas_recaptcha_option_group' );
									do_settings_sections( 'sargas-recaptcha-menu-page-mc4wp-forms' );
									submit_button( esc_html__( 'Save Changes', 'sargas-recaptcha' ) );
									?>
                                </div>
                            </div>
                        </div>

                        <div id="tab-nf"
                             style="display: <?php echo ( isset( $_GET['tab'] ) && $_GET['tab'] === 'nf' ) ? esc_html( 'block;' ) : esc_html( 'none;' ); ?>"
                             class="meta-box-sortables ui-sortable">
                            <div class="postbox">
                                <div class="inside">
									<?php
									settings_fields( 'sargas_recaptcha_option_group' );
									do_settings_sections( 'sargas-recaptcha-menu-page-nf-forms' );
									submit_button( esc_html__( 'Save Changes', 'sargas-recaptcha' ) );
									?>
                                </div>
                            </div>
                        </div>

                        <div id="tab-gf"
                             style="display: <?php echo ( isset( $_GET['tab'] ) && $_GET['tab'] === 'gf' ) ? esc_html( 'block;' ) : esc_html( 'none;' ); ?>"
                             class="meta-box-sortables ui-sortable">
                            <div class="postbox">
                                <div class="inside">
									<?php
									settings_fields( 'sargas_recaptcha_option_group' );
									do_settings_sections( 'sargas-recaptcha-menu-page-gf-forms' );
									submit_button( esc_html__( 'Save Changes', 'sargas-recaptcha' ) );
									?>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </form>

            <div id="postbox-container-1" class="postbox-container">
                <div class="postbox">
                    <h3><?php esc_html_e( 'Info', 'sargas-recaptcha' ) ?></h3>
                    <div class="inside">
                        <h4><?php esc_html_e( 'Ukrainian Digital Company', 'sargas-recaptcha' ); ?></h4>
                        <p>
							<?php printf(
								'<a target="_blank" href="%1$s"><img  src="%2$s" alt="Sargas logo" /></a>',
								esc_url( 'https://sargas.io' ),
								esc_url( SARGAS_RECAPTCHA_ADMIN_IMG_SRC . 'logo.png' )
							); ?>
                        </p>
                        <p>
                            <strong><?php esc_html_e( 'Plugin version', 'sargas-recaptcha' ) ?></strong>: <?php echo SARGAS_RECAPTCHA_VERSION ?>
                        </p>
						<?php add_thickbox(); ?>

                        <div id="sargas-recaptcha-feature-request-wrapper" style="display:none;">
                            <div class="inside">
                                <noscript>
									<?php esc_html_e( 'Please enable JavaScript in your browser to submit this form', 'sargas-recaptcha' ); ?>
                                </noscript>
                                <div class="sargas-feature-request">
                                    <div class="sargas-feature-request-form">
                                        <div>
                                            <label for="sargas-feature-request-textarea">
                                                <textarea id="sargas-feature-request-textarea"></textarea>
                                            </label>
                                            <span class="sargas-recaptcha-error-message sargas-recaptcha-validation-error sargas-recaptcha-d-none"></span>
                                        </div>
                                        <p>
                                            <label for="sargas-recaptcha-is-anonymously">
												<?php esc_html_e( 'Send anonymously', 'sargas-recaptcha' ); ?>
                                                <input id="sargas-recaptcha-is-anonymously" type="checkbox"
                                                       name="isAnonymous"/>
                                            </label>
                                            <span class="sargas-recaptcha-tooltip">
                                            <span class="dashicons dashicons-info"></span>
                                            <span class="sargas-recaptcha-tooltip-text">
                                                <?php esc_html_e( 'You can share us your email, WordPress version, and plugin version to help us better understand your wishes and we can contact you. Or you can enable checkbox and submit anonymously.', 'sargas-recaptcha' ); ?>
                                            </span>
                                        </span>
                                        </p>
                                        <p class="sargas-recaptcha-error-message api-error sargas-recaptcha-d-none"></p>
                                        <p class="sargas-recaptcha-success-message sargas-recaptcha-d-none">
											<?php esc_html_e( 'Thank you for contacting us, we received your request successfully!', 'sargas-recaptcha' ); ?>
                                        </p>
                                        <button class="button button-primary submit">
											<?php esc_html_e( 'Request a feature', 'sargas-recaptcha' ); ?>
                                            <img class="sargas-recaptcha-loader sargas-recaptcha-d-none"
                                                 src="<?php echo SARGAS_RECAPTCHA_ADMIN_IMG_SRC . 'loader.svg' ?>"
                                                 alt="loader"/>
                                        </button>
                                    </div>
                                </div>
                            </div> <!-- .inside -->
                        </div>

                        <a title="<?php esc_html_e( 'Submit a feature request', 'sargas-recaptcha' ) ?>"
                           href="#TB_inline?height=150&amp;width=400&amp;inlineId=sargas-recaptcha-feature-request-wrapper"
                           class="thickbox button button-primary">
							<?php esc_html_e( 'Request a feature', 'sargas-recaptcha' ) ?>
                        </a>
                    </div>
                </div>
                <div class="postbox">
                    <h3><?php esc_html_e( 'reCAPTCHA widget preview', 'sargas-recaptcha' ) ?></h3>
                    <div class="inside">
						<?php $options = (array) get_option( 'sargas-recaptcha-options' ); ?>
						<?php if ( ! $options['site_key'] || ! $options['secret_key'] ) { ?>
                            <span class="sargas-recaptcha-error-message"><?php esc_html_e( 'No secret key or site key found.', 'sargas-recaptcha' ); ?></span>
						<?php } else { ?>
                            <noscript><?php esc_html_e( 'Please enable JavaScript in your browser to submit this form', 'sargas-recaptcha' ); ?></noscript>

                            <form class="sargas-recaptcha-test-keys-form">
                                <div id="sargas-recaptcha-keys-verification-error"
                                     class="sargas-recaptcha-error-message"></div>
                                <div id="sargas-recaptcha-keys-verification-success"
                                     class="sargas-recaptcha-success-message"></div>

								<?php if ( 'v2' === $options['recaptcha_type'] ) { ?>
                                    <div class="sargas-recaptcha-wrapper"></div>
								<?php } else { ?>
                                    <input type="hidden" name="g-recaptcha-response"
                                           class="g-recaptcha-response sargas-recaptcha-wrapper">
								<?php } ?>
                                <button type="submit" class="button button-primary">
									<?php esc_html_e( 'Test Keys', 'sargas-recaptcha' ) ?>
                                    <img class="sargas-recaptcha-loader"
                                         src="<?php echo esc_url( SARGAS_RECAPTCHA_ADMIN_IMG_SRC . 'loader.svg' ) ?>"
                                         alt="loader"/>
                                </button>
                            </form>
						<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
