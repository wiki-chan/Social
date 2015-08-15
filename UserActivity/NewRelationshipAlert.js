function showNewRelationAlert() {
	try {
		var noti_container = document.getElementById('noti-container');
		if( !noti_container ) return ;
		var newCount;
		sajax_request_type = 'POST';
		sajax_do_call( 'wfGetNewRequestRelationship', [], function(req) {
			newCount = req.responseText;
			if (newCount != 0) {
				var noti_container = document.getElementById('noti-container');
				if( !noti_container ) return ;
				var newsign = document.createElement("span");
				newsign.className = "user-activity-alert";
				newsign.innerHTML = newCount;
				noti_container.appendChild(newsign);
				console.log("get notification success");
				console.log(newsign);
			}
		});
	} catch (e) {
		return false;
	}
}

showNewRelationAlert();