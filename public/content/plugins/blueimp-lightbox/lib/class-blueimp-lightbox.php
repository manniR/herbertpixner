<?php
/**
 * Wordpress blueimp lightbox class 1.0.1
 * http://blueimp.github.io/Gallery/
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under GPLv2 or later:
 * http://opensource.org/licenses/GPL-2.0
 */

class Blueimp_Lightbox {
	protected $options = array(
		'version' => '1.0.0',
		'namespace' => 'blueimp-lightbox',
		'default_media_types' => 'gif,jpg,jpeg,png',
		'lightbox_attribute' => 'data-gallery',
		'tmpl_files' => array(
			'blueimp-gallery',
			'blueimp-gallery-fullscreen'
		),
		'css_files' => array(
			'blueimp-gallery' => array(),
			'blueimp-gallery-indicator' => array('blueimp-gallery'),
			'blueimp-gallery-video' => array('blueimp-gallery'),
		),
		'js_files' => array(
			'blueimp-gallery' => array('jquery'),
			'blueimp-gallery-indicator' => array('blueimp-gallery'),
			'blueimp-gallery-fullscreen' => array('blueimp-gallery'),
			'blueimp-gallery-video' => array('blueimp-gallery'),
			'blueimp-gallery-vimeo' => array('blueimp-gallery-video'),
			'blueimp-gallery-youtube' => array('blueimp-gallery-video'),
			'jquery.blueimp-gallery' => array('jquery', 'blueimp-gallery')
		)
	);

	protected $namespace;
	protected $options_group;

	public function __construct($plugin_path, $options = null) {
		$this->plugin_path = $plugin_path;
        if ($options) {
            $this->options = $options + $this->options;
        }
        $this->namespace = $this->options['namespace'];
		$this->options_group = str_replace('-', '_', $this->namespace);
		// Check if the url returned by plugins_url contains the absolute path:
		if (strpos(
			plugins_url(null, $this->plugin_path),
			dirname($this->plugin_path)
		) !== false) {
			// Add a filter to remove the absolute path to create valid plugin_urls:
			add_filter('plugins_url', array(&$this, 'plugins_url_symlink_fix'), 10, 3);
		}
		add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
		add_action('wp_footer', array(&$this, 'add_lightbox_templates'));
		if (intval(get_option($this->options_group.'_auto_add', 1)) === 1) {
			add_filter('the_content', array(&$this, 'add_attribute'), PHP_INT_MAX);
			add_filter('the_excerpt', array(&$this, 'add_attribute'), PHP_INT_MAX);
		}
		add_action('admin_init', array(&$this, 'admin_init'));
		add_action('admin_menu', array(&$this, 'add_menu'));
		add_action('plugins_loaded', array(&$this, 'load_plugin_textdomain'));
	}

	public function plugins_url_symlink_fix($url, $path, $plugin) {
		// Check if the plugins_url function is called for this plugin:
		if (strpos($plugin, basename($this->plugin_path)) !== false) {
			// Replace the absolute path of the symlinked plugin from the url:
			return str_replace(
				dirname($this->plugin_path),
				'/'.basename($plugin, '.php'),
				$url
			);
		}
		return $url;
	}

	public function enqueue_scripts() {
		foreach ($this->options['css_files'] as $id => $deps) {
			wp_enqueue_style(
				$id,
				plugins_url('css/'.$id.'.css', $this->plugin_path),
				$deps,
				$this->options['version']
			);
		}
		foreach ($this->options['js_files'] as $id => $deps) {
			wp_enqueue_script(
				$id,
				plugins_url('js/'.$id.'.js', $this->plugin_path),
				$deps,
				$this->options['version'],
				true
			);
		}
	}

	public function add_lightbox_templates() {
		$templates_path = plugin_dir_path($this->plugin_path).'tmpl/';
		foreach ($this->options['tmpl_files'] as $id) {
			readfile($templates_path.$id.'.html');
		}
	}

	public function add_attribute ($content) {
		$lightbox_attribute = $this->options['lightbox_attribute'];
		$types = str_replace(',', '|', get_option(
			'blueimp_lightbox_settings_media_types',
			$this->options['default_media_types']
		));
		$pattern = '/(<a(?![^>]*? '.$lightbox_attribute
				.')[^>]*?href="[^"]+?\.(?:'.$types.')"[^>]*)>/i';
		$replacement = '$1 '.$lightbox_attribute.'>';
		return preg_replace($pattern, $replacement, $content);
	}

	public function admin_init () {
		register_setting(
			$this->options_group,
			$this->options_group.'_auto_add',
			'intval'
		);
		register_setting(
			$this->options_group,
			$this->options_group.'_media_types',
			array(&$this, 'media_types_sanitize')
		);
		add_settings_section(
			$this->options_group.'_auto_add',
			__('Automatic lightbox activation', 'blueimp-lightbox'),
			array(&$this, 'settings_section_auto_add'),
			$this->namespace
		);
		add_settings_field(
			$this->options_group.'_auto_add',
			__('Automatic activation', 'blueimp-lightbox'),
			array(&$this, 'settings_field_auto_add'),
			$this->namespace,
			$this->options_group.'_auto_add',
			array('id' => $this->options_group.'_auto_add')
		);
		add_settings_field(
			$this->options_group.'_media_types',
			__('Media types', 'blueimp-lightbox'),
			array(&$this, 'settings_field_media_types'),
			$this->namespace,
			$this->options_group.'_auto_add',
			array('id' => $this->options_group.'_media_types')
		);
	}

	public function add_menu () {
		add_options_page(
			__('blueimp lightbox options', 'blueimp-lightbox'),
			__('blueimp lightbox', 'blueimp-lightbox'),
			'manage_options',
			$this->namespace,
			array(&$this, 'options_page')
		);
	}

	public function options_page () {
		echo '<div class="wrap">';
		screen_icon();
		echo '<h2>'.__('blueimp lightbox options', 'blueimp-lightbox').'</h2>';
		echo '<form method="post" action="options.php">';
		settings_fields($this->options_group);
		do_settings_sections($this->namespace);
		submit_button();
		echo '</form>';
		echo '</div>';
	}

	public function settings_section_auto_add () {
		echo '<p>';
		echo sprintf(
			__(
				'This feature automatically adds the lightbox attribute (%s) to media links.',
				'blueimp-lightbox'
			),
			$this->options['lightbox_attribute']
		);
		echo '</p>';
		echo '<p>';
		echo __(
			'The list of comma-separated media types restricts the feature to specific links.',
			'blueimp-lightbox'
		);
		echo '</p>';
	}

	public function settings_field_auto_add ($args) {
		$id = $args['id'];
		$checked = checked(1, intval(get_option($id, 1)), false);
		$label = __(
			'Enable the automatic activation feature.',
			'blueimp-lightbox'
		);
		echo sprintf(
			'<input type="checkbox" name="%s" id="%s" value="1" %s>',
			$id,
			$id,
			$checked
		);
		echo sprintf(' <label for="%s">%s</label>', $id, $label);
	}

	public function settings_field_media_types ($args) {
		$default_media_types = $this->options['default_media_types'];
		$id = $args['id'];
		$value = get_option($id, $default_media_types);
		$placeholder = $default_media_types;
		echo sprintf(
			'<input type="text" name="%s" id="%s" value="%s" placeholder="%s">',
			$id,
			$id,
			$value,
			$placeholder
		);
	}

	public function media_types_sanitize ($value) {
		return preg_replace('/[^\w,]+/', '', $value);
	}

	public function load_plugin_textdomain () {
		load_plugin_textdomain(
			'blueimp-lightbox',
			false,
			dirname(plugin_basename($this->plugin_path)).'/lang/'
		);
	}

}
