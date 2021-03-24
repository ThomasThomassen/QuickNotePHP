<?php
	session_start();

	

	function confirm_logged_in() {
		if (!isset($_SESSION['user_id'])) {
			redirect_to("/login");
		}
	}
		
    function redirect_to($location) {
       	#echo "<script>window.location.href = '$location';</script>";

		header("Location: {$location}");
        exit;
    }

?>