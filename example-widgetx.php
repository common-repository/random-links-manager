<?php
	define(URL,'http://www.expertseo.me/linksmanager/get_links.php');
/**
 * Plugin Name: Random Links Manager
 * Plugin URI: http://www.expertseo.me
 * Description: A Random blogroll widget. This widget pulls links from a remote centralised database that you can use to host a linkfarm, or feedsite network setup. This part is the widget, that clients who use it on there own sites, can update it through the wordpress repository.
 * Version: 0.2
 * Author: Jason Suli
 * Author URI: http://expertseo.me
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'my_example_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function my_example_load_widgets() {
	register_widget( 'Example_Widgetx' );
}

/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Example_Widgetx extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Example_Widgetx() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'example', 'description' => __('Displays Random Links In Your Sidebar from Central Database', 'example') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'example-widget', __('Random Links Manager', 'example'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$name = $instance['name'];
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display name from widget settings if one was input. */
			$x=new scrape2();
			$x->abc($name);
			$x->close();

		/* If show sex was selected, display the user's sex. */

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );

		/* No need to strip tags for sex and show_sex. */
		$instance['sex'] = $new_instance['sex'];
		$instance['show_sex'] = $new_instance['show_sex'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Example', 'example'), 'name' => __('10', 'example'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Your Name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Number links:', 'example'); ?></label>
			<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}
class scrape2 {
	private $ch;
	function __construct($v=true) {
		if($v){
			$this->ch = curl_init();
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($this->ch, CURLOPT_MAXREDIRS, 10);
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 60);
			curl_setopt($this->ch, CURLOPT_TIMEOUT, 300);
			curl_setopt($this->ch, CURLOPT_HEADER, 0);
			curl_setopt($this->ch, CURLOPT_COOKIESESSION, TRUE);
			curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($this->ch, CURLOPT_HTTPHEADER,array ('User-Agent: Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.4) Gecko Galeon/2.0.6 (Debian 2.0.6-2+b1)','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8','Accept-Language: en','Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7','Keep-Alive: 300','Connection: keep-alive'));
		}
	}
	public function abc($limit){
		$url=URL."?limit=$limit";
		curl_setopt($this->ch, CURLOPT_URL, $url);
		$body = $this->getpage();
		echo $body;
	}
	public function getpage(){
		$tries=0;
		$body="";
		$body = curl_exec($this->ch);
		return $body;
	}
	public function close(){
		curl_close($this->ch);
	}
}

?>
