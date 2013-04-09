<?php
require_once 'ale/factory.php';
include_once('configuration.php');

include_once('objects/class.database.php');
include_once('custom/class.ext_lotto.php');
include_once('custom/class.ext_tickets.php');

$tickets = new ext_tickets();
if(isset($_POST['pilotname'])){
	$ticketList = $tickets->GetListTicketCount(array(array("pilot_name", "=", addslashes($_POST['pilotname']))),'lottoid',false);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Lotto Search</title>
<link rel="stylesheet" type="text/css" href="form/view.css" media="all">
<script type="text/javascript" src="form/view.js">
        </script>
</head>
<body id="main_body">
<img id="top" src="form/top.png" alt="">
<div id="form_container">
<h1><a>Lotto Search</a></h1>
<form id="lottosearch" class="appnitro" method="post"
	action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="form_description">
<h2>Lotto Search</h2>
<p>Search for lotto stats by pilot name or lotto code.</p>
</div>
<ul>
	<li id="li_1"><label class="description" for="element_1"> Pilot Name: </label>
	<div><input id="pilotname" name="pilotname" class="element text medium"
		type="text" maxlength="255" value="" /></div>
	<p class="guidelines" id="guide_1"><small> Enter Pilot's Name to see
	how many tickets they have purchased. It must be the exact name of the
	pilot who sent the isk to the lotto. </small></p>
	</li>
	<li id="li_2"><label class="description" for="element_1"> Lotto Code: </label>
	<div><input id="lottocode" name="lottocode" class="element text medium"
		type="text" maxlength="255" value="" /></div>
	<p class="guidelines" id="guide_1"><small> Enter Lotto Code to see how
	many tickets have been sold, and the status of the lotto. It must be
	the exact code of the lotto code. </small></p>
	</li>
	<li class="buttons"><input type="hidden" name="form_id" value="256383" /><input
		id="saveForm" class="button_text" type="submit" name="submit"
		value="Submit" /></li>
		<?php
		if($_POST['lottocode'] == "" && count($ticketList) > 0){ ?>
				<li class="section_break"></li>
				<li>
				<div class="form_description">
				<h2><?php echo $_POST['pilotname'];?></h2>
				</div>
				</li>
				<?php
				foreach($ticketList as $ticket) {
					$lotto = new ext_lotto();
					$lotto->Get($ticket->lottoId);
					$code = $lotto->code;
					$desc = $lotto->description;
					$state = $lotto->state;
					$count = $ticket->ticketCount;
					$winner = $lotto->winner;
					?>
				<li>
				<div class="form_description">
				<p <?php echo ($state ? "class='green'" : "class='red'"); ?>>Code: <?php echo $code; ?>
				(<?php echo ($state ? "open" : "closed");?>) | Tickets: <?php echo $count; ?>
				<?php if($winner) {?>| Winner: <?php echo $winner; }?></p>
				<p class="guidelines" id="guide_1"><small><?php echo $desc;?></small></p>
				</div>
				</li>
				<?php
				}
			} 
			else if($_POST['lottocode'] != "") {?>

				<li class="section_break"></li>
			
				<?php
			
				$lotto = new ext_lotto();
				$lotto->GetFromCode(addslashes($_POST['lottocode']));
				$code = $lotto->code;
				$desc = $lotto->description;
				$state = $lotto->state;
				$thirdParty = $lotto->third_party;
				if($thirdParty) {
					$ticketList = $lotto->GetTicketsList();
					$count = count($ticketList);
					$ticket = new ext_tickets();
					$ticketList = $ticket->GetListTicketNumbers(array(array('lottoid','=',$lotto->lottoId)));
				}
				else {
					$ticketList = $lotto->GetTicketsList();
					$count = count($ticketList);
				}
				
				$winner = $lotto->winner;
				?>
				<li>
				
				<p <?php echo ($state ? "class='green'" : "class='red'"); ?>>Code: <?php echo $code; ?>
				(<?php echo ($state ? "open" : "closed");?>) | Tickets: <?php echo $count; ?>
				<?php if($winner && !$thirdParty) {?>| Winner: <?php echo $winner; }?></p>
				<p class="guidelines" id="guide_1"><small><?php echo $desc;?></small></p>
				
				</li>
				<?php 
				if($thirdParty) {
					foreach($ticketList as $usedTickets) {
				?>
				
				<li class="section_break"></li>
				<li>
				<p><?php echo $usedTickets->pilot_name; ?>:<br/> <?php echo $usedTickets->usedTickets;?> </p>
				</li>
				
				<?php 
					}
				}?>
				

	<?php 
			} else if($_POST['form_id'] == '256383') {?>
	<li class="section_break"></li>
	<li>
	<div class="form_description">
	<h2>No Pilot or Lotto Code Found</h2>
	</div>
	</li>
	<?php }?>
</ul>
</form>
<div id="footer"></div>
</div>
<img id="bottom" src="form/bottom.png" alt="">

</body>
</html>
