function setUserBoardMaxId() {
	try {
		console.log("try to save message-max-id");
		var max_id = document.getElementById( 'user-board-message-max-id' );
		if (max_id) {
			localStorage.setItem( "user-board-message-max-id", max_id.innerHTML );
			console.log("success to save message-max-id");
		}
	} catch (e) {
		return false;
	}
}

function showNewAlert() {
	try {
		var max_id = localStorage.getItem("user-board-message-max-id");
		var newCount;
		sajax_request_type = 'POST';
		sajax_do_call( 'wfGetNewMessage', [max_id], function(req) {
			newCount = req.responseText;
			var newsign = document.createElement("span");
			newsign.className = "user-board-alert";
			newsign.innerHTML = newCount;
			document.getElementsByClassName('account')[0].children[0].appendChild(newsign);
		});
	} catch (e) {
		return false;
	}
}
