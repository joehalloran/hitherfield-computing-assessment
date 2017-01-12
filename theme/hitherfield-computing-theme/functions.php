<?php 

function hitherfield_computing_login_redirect(  ) {
	return site_url();
}
add_filter( 'login_redirect', 'hitherfield_computing_login_redirect', 10, 3 );

?>