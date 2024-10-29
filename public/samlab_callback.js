function сallbackFunk()
{
	jQuery.confirm(
	{
		title: "Call me back",
		content: "url:wp-admin/admin-ajax.php?action=getformsamlab",
        buttons: {
			sayMyName: {
				text: "Send a message",
				btnClass: "btn-green",
				action: function()
				{
					var name = this.$content.find("input#input-name");
					var email = this.$content.find("input#input-email");
                    var message = this.$content.find("textarea#input-message");
					var errorText = this.$content.find(".text-danger");
					if (!name.val().trim())
					{
						jQuery.alert(
						{
							content: "Please don't keep the name field empty.",
							type: "red"
						});
						return false;
					}
					else if (!email.val().trim())
					{
						jQuery.alert(
						{
							content: "Please don't keep the email field empty.",
							type: "red"
						});
						return false;
					}else if (!message.val().trim())
					{
						jQuery.alert(
						{
							content: "Please don't keep the message field empty.",
							type: "red"
						});
						return false;
					}
					else
					{
						jQuery.alert("Thank you i hope you have a great day!");
					}
				}
			},
			later: function()
			{
				// do nothing.
			}
		}
	});
}