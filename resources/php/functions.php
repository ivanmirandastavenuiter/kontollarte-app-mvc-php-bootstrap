<?php 

// Builds custom message on modals
function writeErrorMessage($newUsername, $newEmail, $newRealName, $modalType) {

	if (strcmp($modalType, "register") == 0) {

		echo "<script>$('#r-user-exists').find('.modal-body').append('<p>The following errors have been detected</p>');</script>";
		echo "<script>$('#r-user-exists').find('.modal-body').append('<ul>');</script>";

		if (!$newUsername) {
			echo "<script>$('#r-user-exists').find('.modal-body').children().eq(1).append('<li>Username already exists</li>');</script>";
		} 
		if (!$newEmail) {
			echo "<script>$('#r-user-exists').find('.modal-body').children().eq(1).append('<li>Email already exists</li>');</script>";
		}
		if (!$newRealName) {
			echo "<script>$('#r-user-exists').find('.modal-body').children().eq(1).append('<li>User real name already exists</li>');</script>";
		}

		echo "<script>$('#r-user-exists').find('.modal-body').append('</ul>');</script>";

	} else if (strcmp($modalType, "update") == 0) {

		echo "<script>$('#u-user-exists').find('.modal-body').append('<p>The following errors have been detected</p>');</script>";
		echo "<script>$('#u-user-exists').find('.modal-body').append('<ul>');</script>";

		if (!$newUsername) {
			echo "<script>$('#u-user-exists').find('.modal-body').children().eq(1).append('<li>Username already exists</li>');</script>";
		} 
		if (!$newEmail) {
			echo "<script>$('#u-user-exists').find('.modal-body').children().eq(1).append('<li>Email already exists</li>');</script>";
		}
		if (!$newRealName) {
			echo "<script>$('#u-user-exists').find('.modal-body').children().eq(1).append('<li>User real name already exists</li>');</script>";
		}

		echo "<script>$('#u-user-exists').find('.modal-body').append('</ul>');</script>";

	}
}