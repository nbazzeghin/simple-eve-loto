<?php
require_once 'ale/factory.php';
include_once('configuration.php');

include_once('custom/class.util.php');

$wallet = $GLOBALS['configuration']['wallet'];
$lottoUtil = new util();
try {
	$ale = AleFactory::getEVEOnline();
	$ale->setCredentials($GLOBALS['configuration']['apiID'],$GLOBALS['configuration']['apiKey'],$GLOBALS['configuration']['apiCharID']);
	$parms = array('accountKey' => '1000');

	$utc_str = gmdate("Y-m-d H:i:s", time());
	$CorpWalletJournal = ($wallet == "corp" ? $ale->corp->WalletJournal($parms) : $ale->char->WalletJournal($parms));
	foreach ($CorpWalletJournal->result->entries as $lineItem) {
		$trans_date = $lineItem->date;
		$pilotName = $lineItem->ownerName1;
		$ammount = $lineItem->amount;
		$lottoCode = $lineItem->reason;
		$lottoCode = strtoupper(addslashes($lottoCode));
		$lotto = new ext_lotto();
		$lotto->GetFromCode($lottoCode);
		$thirdParty = $lotto->third_party;
		if($lotto->lottoId && $lotto->state != 0 && (strtotime($lotto->start_date) <= strtotime($utc_str))) {

			if(strtotime($trans_date) >= strtotime($lotto->latest_cache)) {

				$numTickets = floor($ammount / $lotto->ticket_price);


				if($numTickets > 0) {

					for($i = 0; $i < $numTickets; $i++) {
						$TicketList = $lotto->GetTicketsList();
						$usedTickets = count($TicketList);
						if($usedTickets < $lotto->num_tickets) {
							$ticket = new tickets();
							$ticket->pilot_name = $pilotName;
							$ticket->ticket_number = $lottoUtil->GetTicketNum($lotto);

							$lotto->AddTickets($ticket);
							$lotto->Save(true);

						}
						else if(!$lotto->winner) {

							if(!$thirdParty) {
								$winner = new ext_tickets();
								$winner->GetWinner($lotto->lottoId);
								$winingPilot = $winner->pilot_name;

								$lotto->winner = $winingPilot;
							}
							$lotto->state = 0;
							$lotto->Save();
						}
					}
				}
			}
		}
	}
	$lottoEntries = new ext_lotto();
	$lottoList = $lottoEntries->GetList();
	$date = date_create($utc_str);
	date_modify($date, '+1 hour');
	foreach($lottoList as $lottoEntry) {
		$lottoEntry->latest_cache = date_format($date, 'Y-m-d H:i:s');
		$thirdParty = $lottoEntry->third_party;
		if((strtotime(date_format($date, 'Y-m-d H:i:s')) >= strtotime($lottoEntry->end_date)) && $lottoEntry->state != 0){
			if(!$thirdParty){
				$winner = new ext_tickets();
				$winner->GetWinner($lottoEntry->lottoId);
				$winingPilot = $winner->pilot_name;

				$lottoEntry->winner = $winingPilot;
			}
			$lottoEntry->state = 0;
		}
		$lottoEntry->Save();
	}
}
catch (Exception $e){
	echo $e->getMessage();
}
?>