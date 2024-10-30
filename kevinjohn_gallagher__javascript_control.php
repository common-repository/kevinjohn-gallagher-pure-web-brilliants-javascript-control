<?php
/*
	Plugin Name: 			Kevinjohn Gallagher: Pure Web Brilliant's JavaScript Control
	Description: 			Overwrites Wordpress defined javaScript to nullify impact of multiple changes during the release cycle 
	Version: 				2.2
	Author: 				Kevinjohn Gallagher
	Author URI: 			http://kevinjohngallagher.com/
	
	Contributors:			kevinjohngallagher, purewebbrilliant 
	Donate link:			http://kevinjohngallagher.com/
	Tags: 					kevinjohn gallagher, pure web brilliant, framework, cms, simple, multisite, jquery, javascripts, beta, release cycle, deployment, testing
	Requires at least:		3.0
	Tested up to: 			3.4
	Stable tag: 			2.2
*/
/**
 *
 *	Kevinjohn Gallagher: Pure Web Brilliant's JavaScript Control
 * ==============================================================
 *
 *	Overwrites Wordpress defined javaScript to nullify impact of multiple changes during the release cycle.
 *
 *
 *	This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 *	General Public License as published by the Free Software Foundation; either version 3 of the License, 
 *	or (at your option) any later version.
 *
 * 	This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 *	without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *	See the GNU General Public License (http://www.gnu.org/licenses/gpl-3.0.txt) for more details.
 *
 *	You should have received a copy of the GNU General Public License along with this program.  
 * 	If not, see http://www.gnu.org/licenses/ or http://www.gnu.org/licenses/gpl-3.0.txt
 *
 *
 *	Copyright (C) 2008-2012 Kevinjohn Gallagher / http://www.kevinjohngallagher.com
 *
 *
 *	@package				Pure Web Brilliant
 *	@version 				2.2
 *	@author 				Kevinjohn Gallagher <wordpress@kevinjohngallagher.com>
 *	@copyright 				Copyright (c) 2012, Kevinjohn Gallagher
 *	@link 					http://kevinjohngallagher.com
 *	@license 				http://www.gnu.org/licenses/gpl-3.0.txt
 *
 *
 */



 	if ( ! defined( 'ABSPATH' ) )
 	{ 
 			die( 'Direct access not permitted.' ); 
 	}
 	
 	
 	


	define( '_KEVINJOHN_GALLAGHER___javascript_control', '2.2' );



	if (class_exists('kevinjohn_gallagher')) 
	{
		
		
		class	kevinjohn_gallagher___javascript_control 
		extends kevinjohn_gallagher
		{
		
				/*
				**
				**		VARIABLES
				**
				*/
				const PM		=	'_kevinjohn_gallagher___javascript_control';
				
				var					$instance;
				var 				$plugin_name;
				var					$uniqueID;
				var					$plugin_dir;
				var					$plugin_url;
				var					$plugin_page_title; 
				var					$plugin_menu_title; 					
				var 				$plugin_slug;
				var 				$http_or_https;
				var 				$plugin_options;

				var 				$jquery_new_url;
				var 				$jquery_mobile_url;
				var 				$core_jquery_version;
				
		
				/*
				**
				**		CONSTRUCT
				**
				*/
				public	function	__construct() 
				{
						$this->instance					=&	$this;
						$this->uniqueID 				=	self::PM;
						$this->plugin_name				=	"Kevinjohn Gallagher: Pure Web Brilliant's JavaScript Control";
						$this->plugin_page_title		=	"javascript control"; 
						$this->plugin_menu_title		=	"javascript control"; 					
						$this->plugin_slug				=	"javascript-control";
						
												
						
						$this->core_jquery_version		=	$GLOBALS['wp_scripts']->registered['jquery']->ver;
						$this->http_or_https			=	is_ssl() ? 'https:' : 'http:';

						
						add_action( 'init',				array( $this, 'init' ) );
						add_action( 'init',				array( $this, 'init_child' ) );
						add_action(	'admin_init',		array( $this, 'admin_init_register_settings'),100);
						add_action( 'admin_menu',		array( $this, 'add_plugin_to_menu'));
						
						if ( ! get_option( self::PM . '___options' ) )
						{
							//	echo	"no options for:" . self::PM . '___options';
							//	die();
						}
						//	$this->initialize_settings();
												
				}
				
				
				
				
				/*
				**
				**		INIT_CHILD
				**
				*/
			
				public function init_child() 
				{
				
				
						$this->plugin_dir										=	plugin_dir_path(__FILE__);	
						$this->plugin_url										=	plugin_dir_url(__FILE__);				
				
				
						$this->child_settings_sections 							=	array();
						$this->child_settings_sections['back']					= 'Back-End (overwrites admin):';
						$this->child_settings_sections['front'] 				= 'Front-End (overwrites theme):';

						$this->plugin_options									=	get_option($this->uniqueID . '___options');
										
				
						$this->child_settings_array = array();
						
						$this->child_settings_array['admin_where_to_load_from'] = array(
																				'id'      		=> 'admin_where_to_load_from',
																				'title'   		=> 'Where to load files from:',
																				'description'	=> 'Loading from the Google API is the fastest method, but only works if you have a constant internet connection and its open to change without notice. <br /> Loading from the local version is the safest, especially during WordPress\' long release cycle. <br /> Change back to "WordPress Install" once you are satisfied the versions wont change. ',
																				'type'    		=> 'radio',
																				'section' 		=> 'back',
																				'choices' 		=> array(
																											'local'		=> 'Plugin',
																											'google'	=> 'Google API',
																											'wordpress'	=> 'WordPress Install'
																									),
																				'class'   		=> ''
																			);
																			
						$this->child_settings_array['admin_jquery_version'] = array(
																				'id'      		=> 'admin_jquery_version',
																				'title'   		=> 'jQuery Version',
																				'description'	=> '',
																				'type'    		=> 'select',
																				'section' 		=> 'back',
																				'choices' 		=> array(
																											'1-7-2'		=> 'jQuery 1.7.2  -  WordPress 3.3.2',
																											'1-7-1'		=> 'jQuery 1.7.1  -  WordPress 3.3 RC1',
																											'1-7-0'		=> 'jQuery 1.7.0  -  WordPress 3.3 beta 3',
																											'1-6-4'		=> 'jQuery 1.6.4  -  WordPress ?',
																											'1-6-3'		=> 'jQuery 1.6.3  -  WordPress ?',
																											'1-6-2'		=> 'jQuery 1.6.2  -  WordPress ?',
																											'1-6-1'		=> 'jQuery 1.6.1  -  WordPress 3.2',
																											'1-6-0'		=> 'jQuery 1.6.0  -  WordPress ?',
																											'1-5-2'		=> 'jQuery 1.5.2  -  WordPress ?',
																											'1-5-1'		=> 'jQuery 1.5.1  -  WordPress ?',
																											'1-5-0'		=> 'jQuery 1.5.0  -  WordPress ?',
																											'1-4-4'		=> 'jQuery 1.4.4  -  WordPress 3.1',
																											'1-4-3'		=> 'jQuery 1.4.3  -  WordPress ?',
																											'1-4-2'		=> 'jQuery 1.4.2  -  WordPress 3.0',
																											'1-4-1'		=> 'jQuery 1.4.1  -  WordPress ?',
																											'1-4-0'		=> 'jQuery 1.4.0  -  WordPress ?',
																											'0'			=> ' == Deactivate jQuery == '
																									),
																				'class'   		=> ''
																			);	
																			
																			

																			
																			
						$this->child_settings_array['front_where_to_load_from'] = array(
																				'id'      		=> 'front_where_to_load_from',
																				'title'   		=> 'Where to load files from:',
																				'description'	=> '',
																				'type'    		=> 'radio',
																				'section' 		=> 'front',
																				'choices' 		=> array(
																											'local'		=> 'Plugin',
																											'google'	=> 'Google API',
																											'wordpress'	=> 'WordPress Install'
																									),
																				'class'   		=> ''
																			);

						$this->child_settings_array['front_jquery_version'] = array(
																				'id'      		=> 'jquery_version',
																				'title'   		=> 'jQuery Version',
																				'description'	=> '',
																				'type'    		=> 'select',
																				'section' 		=> 'front',
																				'choices' 		=> array(
																											'1-7-2'		=> 'jQuery 1.7.2  -  WordPress 3.3.2',
																											'1-7-1'		=> 'jQuery 1.7.1  -  WordPress 3.3 RC1',
																											'1-7-0'		=> 'jQuery 1.7.0  -  WordPress 3.3 beta 3',
																											'1-6-4'		=> 'jQuery 1.6.4  -  WordPress ?',
																											'1-6-3'		=> 'jQuery 1.6.3  -  WordPress ?',
																											'1-6-2'		=> 'jQuery 1.6.2  -  WordPress ?',
																											'1-6-1'		=> 'jQuery 1.6.1  -  WordPress 3.2',
																											'1-6-0'		=> 'jQuery 1.6.0  -  WordPress ?',
																											'1-5-2'		=> 'jQuery 1.5.2  -  WordPress ?',
																											'1-5-1'		=> 'jQuery 1.5.1  -  WordPress ?',
																											'1-5-0'		=> 'jQuery 1.5.0  -  WordPress ?',
																											'1-4-4'		=> 'jQuery 1.4.4  -  WordPress 3.1',
																											'1-4-3'		=> 'jQuery 1.4.3  -  WordPress ?',
																											'1-4-2'		=> 'jQuery 1.4.2  -  WordPress 3.0',
																											'1-4-1'		=> 'jQuery 1.4.1  -  WordPress ?',
																											'1-4-0'		=> 'jQuery 1.4.0  -  WordPress ?',
																											'0'			=> ' == Deactivate jQuery == '
																									),
																				'class'   		=> ''
																			);	

						$this->child_settings_array['front_jquery_ui_version'] = array(
																				'id'      		=> 'front_jquery_ui_version',
																				'title'   		=> 'jQuery UI Version',
																				'description'	=> '',
																				'type'    		=> 'select',
																				'section' 		=> 'front',
																				'choices' 		=> array(
																											'0'			=> ' == Do not use jQuery UI == ',
																											'1-8-20'	=> 'jQuery UI 1.8.20  ',
																											'1-8-18'	=> 'jQuery UI 1.8.18  ',
																											'1-7-3'		=> 'jQuery UI 1.7.3  ',
																											'1-6-0'		=> 'jQuery UI 1.6.0  ',
																											'1-5-3'		=> 'jQuery UI 1.5.3  '
																									),
																				'class'   		=> ''
																			);	

						$this->child_settings_array['front_jquery_ui_theme'] = array(
																				'id'      		=> 'front_jquery_ui_theme',
																				'title'   		=> 'jQuery UI theme',
																				'description'	=> '',
																				'type'    		=> 'select',
																				'section' 		=> 'front',
																				'choices' 		=> array(
																											'0'					=> ' == None == ',
																											'ui-lightness'		=> ' UI Lightness ',
																											'ui-darkness'		=> ' UI Darkness ',
																											'smoothness'		=> ' Smothness ',
																											'redmond'			=> ' Redmond ',
																											'flick'				=> ' Flick ',
																											'eggplant'			=> ' Eggplant ',
																											'cupertino'			=> ' Cupertino ',
																											'blitzer'			=> ' Blitzer ',
																											'vader'				=> ' Vader ',
																											'trontastic'		=> ' Trontastic '
																									),
																				'class'   		=> ''
																			);	

																			
//		$kevinjohn_gallagher___mobile_control			=	new kevinjohn_gallagher___mobile_control();

						if( class_exists('kevinjohn_gallagher___mobile_control') )
						{

								$this->child_settings_array['front_jquery_mobile'] = array(
																						'id'      		=> 'front_jquery_mobile',
																						'title'   		=> 'jQuery Mobile version:',
																						'description'	=> 'These will only load on a mobile device.',
																						'type'    		=> 'select',
																						'section' 		=> 'front',
																						'choices' 		=> array(
																													'0'		=> ' == No thanks ==',
																													'1-1-0'		=> 'jQuery Mobile 1.1.0 '
																											),
																						'class'   		=> ''
																					);	
																					
								/*
		
								$this->child_settings_array['front_jquery_ui_touch_punch'] = array(
																						'id'      		=> 'front_jquery_ui_touch_punch',
																						'title'   		=> 'jQuery plugin: Touch Punch',
																						'description'	=> 'This adds touch controls to mobile devices. <br/> It requires both jQuery UI and jQuery Mobile.',
																						'type'    		=> 'radio',
																						'section' 		=> 'front',
																						'choices' 		=> array(
																													'1'			=> ' Yes ',
																													'0'			=> ' No '
																											),
																						'class'   		=> ''
																					);	
								*/
																			
						} else {
							

								$this->child_settings_array['front_jquery_mobile'] = array(
																						'id'      		=> 'front_jquery_mobile',
																						'title'   		=> 'jQuery Mobile version:',
																						'description'	=> 'This requires "Kevinjohn Gallagher\'s Mobile Control" plugin',
																						'type'    		=> 'text_only',
																						'section' 		=> 'front',
																						'choices' 		=> array(
																											),
																						'class'   		=> ''
																					);	
		
								/*
								$this->child_settings_array['front_jquery_ui_touch_punch'] = array(
																						'id'      		=> 'front_jquery_ui_touch_punch',
																						'title'   		=> 'jQuery plugin: Touch Punch',
																						'description'	=> 'This requires "Kevinjohn Gallagher\'s Mobile Control" plugin',
																						'type'    		=> 'text_only',
																						'section' 		=> 'front',
																						'choices' 		=> array(
																											),
																						'class'   		=> ''
																					);
								*/	
							
							
							
						}												
																			

						/*
						$this->child_settings_array['front_firebug_lite'] = array(
																				'id'      		=> 'front_firebug_lite',
																				'title'   		=> 'Firebug Lite:',
																				'description'	=> 'This is really great for testing themes in multiple browsers (IE)',
																				'type'    		=> 'radio',
																				'section' 		=> 'front',
																				'choices' 		=> array(
																											'1'			=> ' Yes ',
																											'0'			=> ' No '
																									),
																				'class'   		=> ''
																			);	
						*/



						add_action('wp_enqueue_scripts', 		array($this, 'replace_javascripts'));
						add_action('admin_header', 				array($this, 'jquery_mobile_version_check'));
						add_action('admin_enqueue_scripts', 	array($this, 'admin_replace_javascripts'));																																					
																																						
				}
				
				
				private 	function 	return_right_version($product, $version_to_parse)
				{
						if ($product == "jQuery" || $product == "jQuery-Mobile" || $product == "jQuery-UI")
						{
								$newstr 		=	str_replace('-', '.', $version_to_parse);
								$version		= 	$newstr;	
						}
				
						return						$version;
				}
				
				
				
				private 	function 	plugin_jquery_url($version)
				{
						$jquery_plugin_url 			=	$this->plugin_url. "_javascripts/jquery/jquery-" . $version . ".min.js";
					
						return						$jquery_plugin_url;
				}
				
				
				private 	function 	google_jquery_url($version)
				{
						$jquery_google_url		=	$this->http_or_https .'//ajax.googleapis.com/ajax/libs/jquery/'. $version .'/jquery.min.js';
						
						return						$jquery_google_url;
								
				}

				private 	function 	plugin_jquery_ui_url($version)
				{
						$jquery_plugin_url 			=	$this->plugin_url. "_javascripts/jquery-ui/jquery-ui-" . $version . "/js/jquery-ui-" . $version . ".min.js";
					
						return						$jquery_plugin_url;
				}
				
				
				private 	function 	google_jquery_ui_url($version)
				{
						$jquery_ui_google_url		=	$this->http_or_https .'//ajax.googleapis.com/ajax/libs/jqueryui/'. $version .'/jquery-ui.min.js';
						
						return						$jquery_ui_google_url;
								
				}
				

				private 	function 	google_jquery_ui_css_url($version, $theme)
				{
						$jquery_ui_css_google_url		=	$this->http_or_https .'//ajax.googleapis.com/ajax/libs/jqueryui/'. $version .'/themes/'.$theme.'/jquery-ui.css';
						
						return						$jquery_ui_css_google_url;
								
				}


				private 	function 	plugin_jquery_mobile_url($version)
				{
						$jquery_plugin_url 			=	$this->plugin_url. "_javascripts/jquery-mobile/jquery.mobile-" . $version . ".min.js";
					
						return						$jquery_plugin_url;
				}


				private 	function 	plugin_jquery_ui_touch_punch($version='')
				{
						$plugin_jquery_ui_touch_punch_url 		=	$this->plugin_url. "_javascripts/jquery-plugins/jquery.ui.touch-punch.min.js";
					
						return						$plugin_jquery_ui_touch_punch_url;
				}




				/*
				**
				**		ADD_PLUGIN0_TO_MENU
				**
				*/				
				public 	function 	add_plugin_to_menu()
				{
						$this->framework_admin_menu_child(	'javascript control', 
															'javascript control', 
															$this->plugin_slug, 		//'javascript-control', 
															array($this, 'child_admin_page')
														);
				
				}
				

				/*
				**
				**		CHILD ADMIN PAGE
				**
				*/				
				public 	function 	child_admin_page()
				{
						$this->framework_admin_page_header('JavaScript Control', 'icon_class');
					 
						$this->framework_admin_page_footer();				
				}
				
				
				
				
				public 	function 	replace_javascripts()
				{
						
						$front_use_google 		=		false;
						$front_use_plugin 		=		false;
						$front_use_default		=		true;
						
						if( $this->plugin_options['front_where_to_load_from'] == "google" )
						{					
								$front_use_google 		=		true;
								$front_use_plugin 		=		false;
								$front_use_default		=		false;
						} 	
						
						if( $this->plugin_options['front_where_to_load_from'] == "local" || $this->plugin_options['front_where_to_load_from'] == "plugin" )
						{					
								$front_use_google 		=		false;
								$front_use_plugin 		=		true;
								$front_use_default		=		false;
						} 									
					
									
					
						if( !$front_use_default )
						{
								wp_deregister_script('jquery');
								
								$chosen_option					=	$this->plugin_options['front_jquery_version'];

								
								if ($chosen_option != 0 && $chosen_option != "0")
								{
									
										$chosen_jquery_version			=	$this->return_right_version('jQuery', $chosen_option);
										
										if( $front_use_google  )
										{
												$this->jquery_new_url		=	$this->google_jquery_url($chosen_jquery_version);
										}
										
										if( $front_use_plugin )
										{
												$this->jquery_new_url		=	$this->plugin_jquery_url($chosen_jquery_version);
										}
										
										//echo "<br />". $this->jquery_new_url;
										
										wp_register_script( 'jquery',	$this->jquery_new_url,	'',	$chosen_jquery_version,	true	);
										wp_enqueue_script( 'jquery' );
										
								}
							
						
						}
						
						/*
						 *		jQuery UI
						 *
						 */
						
						
						$chosen_jquery_ui_option				=	$this->plugin_options['front_jquery_ui_version'];
				
						if ($chosen_jquery_ui_option != 0 && $chosen_jquery_ui_option != "0")
						{
							
								$chosen_jquery_ui_version			=	$this->return_right_version('jQuery-UI', $chosen_jquery_ui_option);
								
								if( $front_use_google  )
								{
										$this->jquery_ui_url		=	$this->google_jquery_ui_url($chosen_jquery_ui_version);
										
								}
									else 
								{
										$this->jquery_ui_url		=	$this->plugin_jquery_ui_url($chosen_jquery_ui_version);
								}
								
							//	echo "<br />". $this->jquery_ui_url;
								
								wp_register_script( 'jquery-ui',	$this->jquery_ui_url,	'',	$chosen_jquery_ui_version,	true	);
								wp_enqueue_script(	'jquery-ui' );
								
								//
								//		Theme Support
								//
								$chosen_jquery_ui_theme_option				=	$this->plugin_options['front_jquery_ui_theme'];
								
						
								if( $front_use_google  )
								{
										$this->jquery_ui_theme_url		=	$this->google_jquery_ui_css_url($chosen_jquery_ui_version, $chosen_jquery_ui_theme_option);
										
								}
									else 
								{
										$this->jquery_ui_theme_url		=	$this->google_jquery_ui_css_url($chosen_jquery_ui_version, $chosen_jquery_ui_theme_option);

//										$this->jquery_ui_theme_url		=	$this->plugin_jquery_ui_css_url($chosen_jquery_ui_version, $chosen_jquery_ui_theme_option);
								}
								

								wp_register_style( 'jquery-ui-theme-'. $chosen_jquery_ui_theme_option, $this->jquery_ui_theme_url, false, $chosen_jquery_ui_version, 'all' );
								wp_enqueue_style( 'jquery-ui-theme-'. $chosen_jquery_ui_theme_option);
								
								
						}
						
						
						
						/*
						 *		Mobile
						 *
						 */
						
					//	$is_mobile				=		wp_is_mobile();
						$is_mobile				=		true;
						
						if ( $is_mobile  )
						{
								$jquery_mobile_version					=	$this->plugin_options['front_jquery_mobile'];	
						
								//echo $jquery_mobile_version;
								 
						
								if( $jquery_mobile_version != 0 || $jquery_mobile_version != "0" )
								{
										$chosen_jquery_mobile_version			=	$this->return_right_version('jQuery-Mobile', $jquery_mobile_version);
										$this->jquery_mobile_url				=	$this->plugin_jquery_mobile_url($chosen_jquery_mobile_version);
										
									//	echo $this->jquery_mobile_url;
									//	die();
								
										wp_register_script( 'jquery-mobile',	$this->jquery_mobile_url,	'jquery',	$chosen_jquery_mobile_version,	true	);
										wp_enqueue_script( 'jquery-mobile' );								
								
								}


								$jquery_ui_touch_punch					=	$this->plugin_options['front_jquery_ui_touch_punch'];

								if( $jquery_ui_touch_punch != 0 || $jquery_ui_touch_punch != "0" )
								{
								
										if ($chosen_jquery_ui_option != 0 && $chosen_jquery_ui_option != "0")
										{
												$this->jquery_ui_touch_punch_url			=	$this->plugin_jquery_ui_touch_punch();
												
											//	echo $this->jquery_ui_touch_punch_url;
											//	die();
										
												wp_register_script( 'jquery-ui-touch-punch',	'0.2.2',	'jquery',	$chosen_jquery_mobile_version,	true	);
												wp_enqueue_script(	'jquery-ui-touch-punch' );								
										}
								}
								
						
						}
						
						
						//	https://getfirebug.com/firebug-lite.js

						if ( $this->plugin_options['front_firebug_lite'] )
						{
							wp_register_script( 'firebug-lite',	'https://getfirebug.com/firebug-lite.js',	'',	'1.4',	true	);
							wp_enqueue_script( 	'firebug-lite' );								
						}
				
				}
		


				
				
				public 	function 	admin_replace_javascripts()
				{


						$admin_use_google 		=		false;
						$admin_use_plugin 		=		false;
						$admin_use_default		=		true;
						
						if( $this->plugin_options['admin_where_to_load_from'] == "google" )
						{					
								$admin_use_google 		=		true;
								$admin_use_plugin 		=		false;
								$admin_use_default		=		false;
						} 	
						
						if( $this->plugin_options['admin_where_to_load_from'] == "local" || $this->plugin_options['admin_where_to_load_from'] == "plugin" )
						{					
								$admin_use_google 		=		false;
								$admin_use_plugin 		=		true;
								$admin_use_default		=		false;
						} 									
					
									
					
						if( !$admin_use_default )
						{
						
								wp_deregister_script('jquery');
								
								$chosen_option					=	$this->plugin_options['admin_jquery_version'];

								
								if ($chosen_option != 0 && $chosen_option != "0")
								{
									
										$chosen_jquery_version			=	$this->return_right_version('jQuery', $chosen_option);
										
										if( $admin_use_google  )
										{
												$this->jquery_new_url		=	$this->google_jquery_url($chosen_jquery_version);
										}
										
										if( $admin_use_plugin )
										{
												$this->jquery_new_url		=	$this->plugin_jquery_url($chosen_jquery_version);
										}
										
										//echo "<br />". $this->jquery_new_url;
										
										wp_register_script( 'jquery',	$this->jquery_new_url,	'',	$chosen_jquery_version,	true	);
										wp_enqueue_script( 'jquery' );
										
								}
							
						
						}
						
						
				}



				private 	function 	version_to_number($version_to_parse)
				{
						$version 				=	str_replace('-', '', $version_to_parse);
						$number					=	int($version);
						return 						$number;
				}


				public 		function 	jquery_mobile_version_check()
				{
						$jquery_mobile_version					=	$this->plugin_options['front_jquery_mobile'];
						$jquery_version							=	$this->plugin_options['front_jquery_version'];
						$chosen_jquery_version					=	$this->version_to_number($jquery_version);
				
						if( $jquery_mobile_version != 0 || $jquery_mobile_version != "0" )
						{
							if ($chosen_jquery_version > 160)
							{
								echo	"<div id='message' class='error'>";						
								echo	"<p>";
								echo	"<strong>Warning: </strong> ";	
								echo	"jQuery Mobile requires jQuery version 1.6 and above to function";
								echo	"</p>";
							}
						}
				} 
	

		
		
		}	//	class
		
	
		$kevinjohn_gallagher___javascript_control			=	new kevinjohn_gallagher___javascript_control();
		
	
	} else {
	

			function kevinjohn_gallagher___javascript_control___parent_needed()
			{
					echo	"<div id='message' class='error'>";
					
					echo	"<p>";
					echo	"<strong>Kevinjohn Gallagher: Pure Web Brilliant's JavaScript Control</strong> ";	
					echo	"requires the parent framework to be installed and activated";
					echo	"</p>";
			} 

			add_action('admin_footer', 'kevinjohn_gallagher___javascript_control___parent_needed');	
	
	}


