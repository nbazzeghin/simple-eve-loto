<?php
include_once('objects/class.database.php');
include_once('custom/class.ext_lotto.php');
include_once('custom/class.ext_tickets.php');
class util
{

	/**
	 * Generates lotto code that is not currently in the database.
	 * @return String $code
	 */
	function GenLottoCode() {

		$vowels .= "AEIUY";
		$letters .= $vowels . 'BCDFGHJKLMNPQRSTVWXZ';
		$numbers .= '23456789';

		$code = $letters[rand(0,24)] . $letters[rand(0,24)] . $numbers[rand(0,7)] . $numbers[rand(0,7)] . $numbers[rand(0,7)];
		$extLotto = new ext_lotto();
		if($extLotto->GetFromCode($code)->lottoId) {
			return self::GenLottoCode();
		}
		else {
			//return self::GenLottoCode();
			return $code;
		} 
	}
	function GetTicketNum($extLotto) {
		$ticketNum = $extLotto->last_ticketnum;
		$ticketNum = $ticketNum + 1;
		$extLotto->last_ticketnum = $ticketNum;
		$extLotto->Save();
		return $ticketNum;
	}
}
?>