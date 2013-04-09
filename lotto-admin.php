<?php 
if (!isset($_SESSION))
{
	session_start();
}
require_once 'ale/factory.php';
include_once('configuration.php');

include_once('custom/class.util.php');
include_once('auth.php');

$lottoUtil = new util();

$lottoID = addslashes($_POST['lotto_id']);
$exec = addslashes($_POST['exec']);
$action = addslashes($_REQUEST['action']);


if($action == 'toggle') {
	$lotto = new ext_lotto();
	$lotto->Get($lottoID);
	$state = $lotto->state;
	$thirdParty = $lotto->third_party;
	
	($state == 1 ? $state = 0 : $state = 1);
	$lotto->state = $state;
	if($state == 0 && $thirdParty == 0) {
		$winner = new ext_tickets();
		$winner->GetWinner($lotto->lottoId);
		$winingPilot = $winner->pilot_name;
		$lotto->winner = $winingPilot;
	}
	else {
		$lotto->winner = '';
	}
	$lotto->save();
	
	
} 
else if ($action == 'edit' || $action == 'add') {
	if(!$exec && $action == 'edit'){
		$lottoEdit = new ext_lotto();
		$lottoEdit->Get($lottoID);
		
		$id = $lottoEdit->lottoId;
		$desc = $lottoEdit->description;
	    $numTickets = $lottoEdit->num_tickets;
	    $ticketPrice = $lottoEdit->ticket_price;
	    $startDate = $lottoEdit->start_date;
	    $endDate = $lottoEdit->end_date;
	    $thirdParty = $lottoEdit->third_party;
	    
	    $expSD = explode('-',$startDate);
	    $expED = explode('-',$endDate);
	} else if($exec) {
		$desc = addslashes($_POST['lotto_desc']);
		if($desc == "") {$errors['lotto_desc'] = true;}
		
	    $numTickets = addslashes($_POST['num_tickets']);
		if(!is_numeric($numTickets)) {$errors['num_tickets'] = true;}
	    
	    $ticketPrice =  addslashes($_POST['ticket_cost']);
		if(!is_numeric($ticketPrice)) {$errors['ticket_cost'] = true;}
	    
	    
	    $sdM = addslashes($_POST['element_4_1']);
	    $sdD = addslashes($_POST['element_4_2']);
	    $sdY = addslashes($_POST['element_4_3']);
		if(!is_numeric($sdM) || !is_numeric($sdD) || !is_numeric($sdY)) {$errors['start_date'] = true;}
	    
	    
	    $edM = addslashes($_POST['element_5_1']);
	    $edD = addslashes($_POST['element_5_2']);
	    $edY = addslashes($_POST['element_5_3']);
		if(!is_numeric($edM) || !is_numeric($edD) || !is_numeric($edY)) {$errors['end_date'] = true;}
	    
	    $startDate = $sdY . "-" . $sdM . "-" . $sdD;
	    $endDate = $edY . "-" . $edM . "-" . $edD;
	    
	    $thirdParty = $_POST['third_party'];
	    
	    $expSD = explode('-',$startDate);
	    $expED = explode('-',$endDate);
	    
	    if(!$errors) {
	    	$lottoAdd = new ext_lotto();
	    	if($action == "add") {
	    		$lottoAdd->code = $lottoUtil->GenLottoCode();
	    		$lottoAdd->state = 0;
	    	} else {
	    		$lottoAdd->Get($lottoID);
	    	}
	    	$lottoAdd->description = $desc;
    		$lottoAdd->num_tickets = $numTickets;
    		$lottoAdd->ticket_price = $ticketPrice;
    		$lottoAdd->start_date = $startDate;
    		$lottoAdd->end_date = $endDate;
    		$lottoAdd->third_party = ($thirdParty ? 1 : 0);
	    	$lottoAdd->Save();
	    	header("Location: ". $_SERVER['PHP_SELF']);
	    	exit;
	    }
	}
	
} 
else if($action == 'remove'){
	$lottoDel = new ext_lotto();
	$lottoDel->Get($lottoID);
	$lottoDel->Delete(true);
	header("Location: ". $_SERVER['PHP_SELF']);
	
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Lotto Admin</title>
        <link rel="stylesheet" type="text/css" href="form/view.css" media="all">
        <script type="text/javascript" src="form/view.js">
        </script>
        <script type="text/javascript" src="form/calendar.js">
        </script>
        <script language="JavaScript">
	        function toggleStatus(idCode) 
	        {
				document.forms[0].lotto_id.value = idCode;
				document.forms[0].action.value = "toggle";
	        }
	        function editLotto(idCode) 
	        {
				document.forms[0].lotto_id.value = idCode;
				document.forms[0].action.value = "edit";
	        }
	        function removeLotto(idCode) 
	        {
	        	var conf = confirm("Delte this Lotto?")
		        if(conf) {
					document.forms[0].lotto_id.value = idCode;
					document.forms[0].action.value = "remove";
		        }
	        }
	        function disableTicketPrice() {
				document.forms[0].ticket_cost.disabled = true;
		        }
	        function enableTicketPrice() {
				document.forms[0].ticket_cost.disabled = false;
		        }
        </script>
    </head>
    <body id="main_body" <?php echo ($action == 'edit' ? "onLoad=\"disableTicketPrice();\"" : "");?>>
        <img id="top" src="form/top.png" alt="">
        <div id="form_container">
        <h1><a>Lotto Admin</a></h1> 
            <form id="lotto-admin" class="appnitro" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php if($action == 'add' || $action == "edit") {?>
                <div class="form_description">
                    <h2><?php echo ($action == 'add' ? "Create" : "Edit")?> Lotto</h2>
                    <p>
                    <?php echo ($action == 'add' ? "Create a new lotto for all the people to enjoy" : "Edit lotto for all the people to enjoy")?>
                    </p>
                </div>
                <ul>
                    <?php if($errors) {?>
                    <li id="error_message">
                        <h3 id="error_message_title">There was a problem with your submission.</h3>
                        <p id="error_message_desc">
                            Errors have been <strong>highlighted</strong>
                            below.
                        </p>
                    </li>
                     <?php }?>
                    <li id="li_1" <?php if($errors['lotto_desc']) {?>class="error"<?php }?>>
                        <label class="description" for="lotto_desc">
                            Lotto Description <?php echo $errors['lotto_desc'];?><span id="required_1" class="required">*</span>: 
                        </label>
                        <div>
                            <textarea id="lotto_desc" name="lotto_desc" class="element textarea medium"><?php echo $desc;?></textarea>
                        </div>
                        <p class="guidelines" id="guide_1">
                            <small>
                                Enter the description for the lotto you are creating. It will show when the pilot does a search for their name. Good things to include might be whats up for grabs, etc.
                            </small>
                        </p>
                    </li>
                    <li id="li_2" <?php if($errors['num_tickets']) {?>class="error"<?php }?>>
                        <label class="description" for="num_tickets">
                            Number of Tickets to Sell<span id="required_1" class="required">*</span>: 
                        </label>
                        <div>
                            <input id="num_tickets" name="num_tickets" class="element text medium" type="text" maxlength="255" value="<?php echo $numTickets?>"/>
                        </div>
                        <p class="guidelines" id="guide_2">
                            <small>
                                How many tickets do you want to sell.
                            </small>
                        </p>
                    </li>
                    <li id="li_3" <?php if($errors['ticket_cost']) {?>class="error"<?php }?>>
                        <label class="description" for="ticket_cost">
                            Ticket Cost<span id="required_1" class="required">*</span>: 
                        </label>
                        <div>
                            <input id="ticket_cost" name="ticket_cost" class="element text medium" type="text" maxlength="255" value="<?php echo $ticketPrice;?>"/>
                        </div>
                        <p class="guidelines" id="guide_3">
                            <small>
                                How much ISK needs to be sent for a single ticket. 
                                <br/><br/>NOTE: For security reason you will not be able to edit
                                this field later. Please make sure you enter the proper ammount the first time.
                            </small>
                        </p>
                    </li>
                    <li id="li_4" <?php if($errors['start_date']) {?>class="error"<?php }?>>
                        <label class="description" for="element_4">
                            Start Date<span id="required_1" class="required">*</span>: 
                        </label>
                        <span><input id="element_4_1" name="element_4_1" class="element text" size="2" maxlength="2" value="<?php echo $expSD[1];?>" type="text">/
                            <label for="element_4_1">
                                MM
                            </label>
                        </span>
                        <span><input id="element_4_2" name="element_4_2" class="element text" size="2" maxlength="2" value="<?php echo $expSD[2];?>" type="text">/
                            <label for="element_4_2">
                                DD
                            </label>
                        </span>
                        <span><input id="element_4_3" name="element_4_3" class="element text" size="4" maxlength="4" value="<?php echo $expSD[0];?>" type="text">
                            <label for="element_4_3">
                                YYYY
                            </label>
                        </span>
                        <span id="calendar_4"><img id="cal_img_4" class="datepicker" src="form/calendar.gif" alt="Pick a date."></span>
                        <script type="text/javascript">
                            Calendar.setup({
                                inputField: "element_4_3",
                                baseField: "element_4",
                                displayArea: "calendar_4",
                                button: "cal_img_4",
                                ifFormat: "%B %e, %Y",
                                onSelect: selectDate
                            });
                        </script>
                        <p class="guidelines" id="guide_4">
                            <small>
                                Date this lotto will begin.
                            </small>
                        </p>
                    </li>
                    <li id="li_5" <?php if($errors['end_date']) {?>class="error"<?php }?>>
                        <label class="description" for="element_5">
                            End Date<span id="required_1" class="required">*</span>: 
                        </label>
                        <span><input id="element_5_1" name="element_5_1" class="element text" size="2" maxlength="2" value="<?php echo $expED[1];?>" type="text">/
                            <label for="element_5_1">
                                MM
                            </label>
                        </span>
                        <span><input id="element_5_2" name="element_5_2" class="element text" size="2" maxlength="2" value="<?php echo $expED[2];?>" type="text">/
                            <label for="element_5_2">
                                DD
                            </label>
                        </span>
                        <span><input id="element_5_3" name="element_5_3" class="element text" size="4" maxlength="4" value="<?php echo $expED[0];?>" type="text">
                            <label for="element_5_3">
                                YYYY
                            </label>
                        </span>
                        <span id="calendar_5"><img id="cal_img_5" class="datepicker" src="form/calendar.gif" alt="Pick a date."></span>
                        <script type="text/javascript">
                            Calendar.setup({
                                inputField: "element_5_3",
                                baseField: "element_5",
                                displayArea: "calendar_5",
                                button: "cal_img_5",
                                ifFormat: "%B %e, %Y",
                                onSelect: selectDate
                            });
                        </script>
                        <p class="guidelines" id="guide_5">
                            <small>
                                Date this lotto will automatically end.
                            </small>
                        </p>
                    </li>
                    <li id="li_6">
                        <label class="description" for="third_party">
                            Allow third party tools to pick winner: 
                        </label>
                        <div>
                        	<input type="checkbox" name="third_party" id="third_party" <?php echo ($thirdParty ? "checked" : "");?> />
                        </div>
                        <p class="guidelines" id="guide_1">
                            <small>
                                Check this box to allow the lotto winner to be picked via a third party tool
                                such as Chirbba's Dice Roller. It will also change the way the lotto is listed
                                when a seach by code is preformed. You will get a list of all the people who 
                                have purchased tickets along with the ticket number.
                            </small>
                        </p>
                    </li>
                    <li class="buttons">
                        <input type="hidden" name="exec" value="true" /><input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" onClick="enableTicketPrice();"/>
                    </li>
					<li class="section_break"></li>
                </ul>
                <?php } else {?>
                <div class="form_description">
                    <h2>Lotto List</h2>
                    <p>
                    List of all lotto's on the system
                    </p>
                    <p><a href="<?php echo $_SERVER['PHP_SELF']?>?action=add">Create Lotto</a></p>
                </div>
                <?php 
                	$lottoList = new ext_lotto();
                	$lottoLists = $lottoList->GetList(array(),'lottoid',false);
                	foreach($lottoLists as $item) {
                		$id = $item->lottoId;
                		$code = $item->code;
                		$desc = $item->description;
                		$numTickets = $item->num_tickets;
                		$ticketPrice = $item->ticket_price;
                		$startDate = $item->start_date;
                		$endDate = $item->end_date;
                		$state = $item->state;
                		$winner = $item->winner;
                		$thirdParty = $item->third_party;
                			
                		$numSold = count($item->GetTicketsList());
                	
                ?>
				<div class="list_lotto">
					<div class="button_row">
						<input type="submit" class="button_text" name="toggle" value="<?php echo ($state == 0 ? "Open Lotto" : "Close Lotto");?>" onClick="toggleStatus('<?php echo $id;?>');"/>
						<input type="submit" class="button_text" name="edit" value="Edit" onClick="editLotto('<?php echo $id;?>');"/>
						<input type="submit" class="button_text" name="edit" value="Delete" onClick="removeLotto('<?php echo $id;?>');"/>
												
					</div>
					<h2>Lotto <?php echo $code;?><?php echo ($winner != "" ? " - Winner: $winner" : '' );?></h2>
					<p class="desc"><small><?php echo $desc;?></small></p>
					<p class="desc"><small>Ticket Price: <?php echo $ticketPrice;?> isk</small></p>
					<div class="float">
						<p>Tickets Sold</p>
						<p><?php echo $numSold;?></p>
					</div>
					<div class="float">
						<p>Number of Tickets</p>
						<p><?php echo $numTickets;?></p>
					</div>
					<div class="float">
						<p>Status</p>
						<p class="<?php echo ($state == 0 ? "red" : "green");?>"><?php echo ($state == 0 ? "Closed" : "Open");?></p>
					</div>
					<div class="float">
						<p>Start Date</p>
						<p><?php echo $startDate;?></p>
					</div>
					<div class="float">
						<p>End Date</p>
						<p><?php echo $endDate;?></p>
					</div>
					<div class="float">
						<p>Third Party</p>
						<p class="<?php echo ($thirdParty  ? "green" : "red");?>"><?php echo ($thirdParty ? "Enabled" : "Disabled");?></p>
					</div>
				</div>
				<?php }?>
			<?php }?>
			
			<input type="hidden" name="action" value="<?php echo $action?>" /><input type="hidden" name="lotto_id" value="<?php echo $id;?>" />
            </form>
            <div id="footer">
                
            </div>
        </div>
        <img id="bottom" src="form/bottom.png" alt="">
    </body>
</html>