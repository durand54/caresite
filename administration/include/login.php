<?php
	
	function login ()
	{
		if (!isset($_SESSION["session"]["id"]) || empty($_SESSION["session"]["id"]))
		{
			$login = '
				<form name="loginForm" method="post" action="'.$_SERVER["PHP_SELF"].'" style="margin: 0px">
				<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="middle" nowrap>
						Username: <input type="text" name="username" size="10" />
						Password: <input type="password" name="password" size="10" />
					</td>
					<td valign="middle" nowrap>
						<input type="image" src="media/images/login.jpg" border="0" name="login" value="Login" />
					</td>
				</tr>
				</table>
				</form>
			';
		}
		return $login;
	}
	
?>