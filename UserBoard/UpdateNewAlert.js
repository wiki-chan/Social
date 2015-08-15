function setUserBoardMaxId() {
	try {
		var max_id = document.getElementById( 'user-board-message-max-id' );
		if (max_id)
			localStorage.setItem( "user-board-message-max-id", max_id.innerHTML );
			sajax_do_call( 'wfGetResetNewMessageCount' );
	} catch (e) {
		return false;
	}
}

function showNewMessageAlert() {
	try {
		var noti_container = document.getElementById('noti-container');
		//return ;
		if( !noti_container ) return ;
		var max_id = localStorage.getItem("user-board-message-max-id");
		var newCount;
		sajax_request_type = 'POST';
		sajax_do_call( 'wfGetNewMessage', [max_id], function(req) {
			newCount = req.responseText;
			if (newCount != 0) {
				var noti_container = document.getElementById('noti-container');
				if( !noti_container ) return ;
				var newsign = document.createElement("span");
				newsign.className = "user-board-alert";
				newsign.innerHTML = newCount;
				noti_container.appendChild(newsign);
				console.log("get notification success");
			}
		});
	} catch (e) {
		return false;
	}
}

if (wgTitle == wgUserName) setUserBoardMaxId();
showNewMessageAlert();