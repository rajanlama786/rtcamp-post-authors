<?php declare(strict_types=1);
require './vendor/autoload.php';
require './includes/helper.php';

class TestResult extends PHPUnit\Framework\TestCase {

	public function testUser( $user_ids)
	{

		$contrib = ""; 
		foreach( $user_ids as $user_id ){
			$testUser = get_user_by('id', $user_id);
			$contrib .=  sprintf('<a class="author-info" href="%s"><img class="author-thumb" src="%2s"><span>%3s</span></a>', esc_url( get_author_posts_url( get_the_author_meta( $testUser->ID ) ) ),esc_url( get_avatar_url( $testUser->ID  ) ), esc_attr( $testUser->user_login ) );
		}

		$this->assertEquals($contrib, contributer(1));
	}
}