<?php

/*
 * PHPExec Plugin
 */

class PHPExecPlugin extends Plugin
{
	function filter_post_content_out($content, $post) {
		if($post->info->phpexec == 'true') {
			$content = str_replace('<!--php', '<?php', $content);
			$content = str_replace('?-->', '?>', $content);

			ob_start();
			$theme = Themes::create();
			eval('?>' . $content . '<?php ');
			$content = ob_get_clean();
		}
		return $content;
	}

	public function action_form_publish( $form, $post ) {
		$form->settings->append( 'checkbox', 'phpexec', 'null:null', _t( 'PHP Exec', 'phpexec' ), 'tabcontrol_checkbox' );

		if ( 0 != $post->id ) {
			$form->phpexec->value = $post->info->phpexec == 'true';
		}
	}

	public function action_publish_post( $post, $form ) {
		$post->info->phpexec = $form->phpexec->value ? 'true' : 'false';
	}

}
?>