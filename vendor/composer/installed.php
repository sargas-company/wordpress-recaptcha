<?php return array(
	'root'     => array(
		'name'           => 'sargas/recaptcha',
		'pretty_version' => 'dev-main',
		'version'        => 'dev-main',
		'reference'      => '46f3ebc0d61c82a11ac2cc90c522e44a8e3e4c3d',
		'type'           => 'wordpress-plugin',
		'install_path'   => __DIR__ . '/../../',
		'aliases'        => array(),
		'dev'            => true,
	),
	'versions' => array(
		'google/recaptcha' => array(
			'pretty_version'  => '1.2.4',
			'version'         => '1.2.4.0',
			'reference'       => '614f25a9038be4f3f2da7cbfd778dc5b357d2419',
			'type'            => 'library',
			'install_path'    => __DIR__ . '/../google/recaptcha',
			'aliases'         => array(),
			'dev_requirement' => false,
		),
		'sargas/recaptcha' => array(
			'pretty_version'  => 'dev-main',
			'version'         => 'dev-main',
			'reference'       => '46f3ebc0d61c82a11ac2cc90c522e44a8e3e4c3d',
			'type'            => 'wordpress-plugin',
			'install_path'    => __DIR__ . '/../../',
			'aliases'         => array(),
			'dev_requirement' => false,
		),
	),
);
