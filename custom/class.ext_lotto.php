<?php

include_once('objects/class.lotto.php');
class ext_lotto extends lotto
{

	/**
	* Gets object from database
	* @param string $code 
	* @return object $lotto
	*/
	function GetFromCode($code)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `lotto` where `code`='{$code}' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->lottoId = $row['lottoid'];
			$this->code = $this->Unescape($row['code']);
			$this->description = $this->Unescape($row['description']);
			$this->num_tickets = $this->Unescape($row['num_tickets']);
			$this->ticket_price = $this->Unescape($row['ticket_price']);
			$this->start_date = $row['start_date'];
			$this->end_date = $row['end_date'];
			$this->state = $this->Unescape($row['state']);
			$this->winner = $this->Unescape($row['winner']);
			$this->latest_cache = $row['latest_cache'];
			$this->third_party = $row['third_party'];
			$this->last_ticketnum = $row['last_ticketnum'];
		}
		return $this;
	}	
}
?>