<?php
if (sizeof($_POST) > 0 && $GLOBALS['configuration']['setup_password'] != "" && (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']))
{
	if ($_POST['setup_password'] == $GLOBALS['configuration']['setup_password'])
	{
		$_SESSION['authenticated'] = true;
	}
	//$_POST = null;
}
if ((!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) && $GLOBALS['configuration']['setup_password'] != "")
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>.</title>
        <link rel="stylesheet" type="text/css" href="form/view.css" media="all">
        <script type="text/javascript" src="form/view.js">
        </script>
    </head>
    <body id="main_body">
        <img id="top" src="form/top.png" alt="">
        <div id="form_container">
        <h1><a>Lotto Admin</a></h1>
            <form id="lottosearch" class="appnitro" method="post" action="./lotto-admin.php?action=list">
            <ul>
                <li id="li_1">
                    <label class="description" for="element_1">
                        Password: 
                    </label>
                    <div>
                        <input id="setup_password" name="setup_password" class="element text medium" type="password" maxlength="255" value="" />
                    </div>
                    <p class="guidelines" id="guide_1">
                        <small>
                            Enter password to gain access to admin functions.
                        </small>
                    </p>
                </li>
                <li class="buttons">
                    <input type="hidden" name="form_id" value="256383" /><input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
                </li>
            </ul>
            </ul>
        </form>
        <div id="footer">
        </div>
        </div>
        <img id="bottom" src="form/bottom.png" alt="">
    </body>
</html>
<?php
exit;
}
?>