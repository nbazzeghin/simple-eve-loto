<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `lotto` (
	`lottoid` int(11) NOT NULL auto_increment,
	`code` TEXT NOT NULL,
	`description` TEXT NOT NULL,
	`num_tickets` INT NOT NULL,
	`ticket_price` INT NOT NULL,
	`start_date` DATE NOT NULL,
	`end_date` DATE NOT NULL,
	`state` TINYINT NOT NULL,
	`winner` TEXT NOT NULL,
	`latest_cache` DATETIME NOT NULL,
	`third_party` INT NOT NULL,
	`last_ticketnum` INT NOT NULL, PRIMARY KEY  (`lottoid`)) ENGINE=MyISAM;
*/

/**
* <b>lotto</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0e / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=lotto&attributeList=array+%28%0A++0+%3D%3E+%27tickets%27%2C%0A++1+%3D%3E+%27code%27%2C%0A++2+%3D%3E+%27description%27%2C%0A++3+%3D%3E+%27num_tickets%27%2C%0A++4+%3D%3E+%27ticket_price%27%2C%0A++5+%3D%3E+%27start_date%27%2C%0A++6+%3D%3E+%27end_date%27%2C%0A++7+%3D%3E+%27state%27%2C%0A++8+%3D%3E+%27winner%27%2C%0A++9+%3D%3E+%27latest_cache%27%2C%0A++10+%3D%3E+%27third_party%27%2C%0A++11+%3D%3E+%27last_ticketnum%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527HASMANY%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527TEXT%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527TEXT%2527%252C%250A%2B%2B3%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B4%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B5%2B%253D%253E%2B%2527DATE%2527%252C%250A%2B%2B6%2B%253D%253E%2B%2527DATE%2527%252C%250A%2B%2B7%2B%253D%253E%2B%2527TINYINT%2527%252C%250A%2B%2B8%2B%253D%253E%2B%2527TEXT%2527%252C%250A%2B%2B9%2B%253D%253E%2B%2527DATETIME%2527%252C%250A%2B%2B10%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B11%2B%253D%253E%2B%2527INT%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class lotto extends POG_Base
{
	public $lottoId = '';

	/**
	 * @var private array of tickets objects
	 */
	private $_ticketsList = array();
	
	/**
	 * @var TEXT
	 */
	public $code;
	
	/**
	 * @var TEXT
	 */
	public $description;
	
	/**
	 * @var INT
	 */
	public $num_tickets;
	
	/**
	 * @var INT
	 */
	public $ticket_price;
	
	/**
	 * @var DATE
	 */
	public $start_date;
	
	/**
	 * @var DATE
	 */
	public $end_date;
	
	/**
	 * @var TINYINT
	 */
	public $state;
	
	/**
	 * @var TEXT
	 */
	public $winner;
	
	/**
	 * @var DATETIME
	 */
	public $latest_cache;
	
	/**
	 * @var INT
	 */
	public $third_party;
	
	/**
	 * @var INT
	 */
	public $last_ticketnum;
	
	public $pog_attribute_type = array(
		"lottoId" => array('db_attributes' => array("NUMERIC", "INT")),
		"tickets" => array('db_attributes' => array("OBJECT", "HASMANY")),
		"code" => array('db_attributes' => array("TEXT", "TEXT")),
		"description" => array('db_attributes' => array("TEXT", "TEXT")),
		"num_tickets" => array('db_attributes' => array("NUMERIC", "INT")),
		"ticket_price" => array('db_attributes' => array("NUMERIC", "INT")),
		"start_date" => array('db_attributes' => array("NUMERIC", "DATE")),
		"end_date" => array('db_attributes' => array("NUMERIC", "DATE")),
		"state" => array('db_attributes' => array("NUMERIC", "TINYINT")),
		"winner" => array('db_attributes' => array("TEXT", "TEXT")),
		"latest_cache" => array('db_attributes' => array("TEXT", "DATETIME")),
		"third_party" => array('db_attributes' => array("NUMERIC", "INT")),
		"last_ticketnum" => array('db_attributes' => array("NUMERIC", "INT")),
		);
	public $pog_query;
	
	
	/**
	* Getter for some private attributes
	* @return mixed $attribute
	*/
	public function __get($attribute)
	{
		if (isset($this->{"_".$attribute}))
		{
			return $this->{"_".$attribute};
		}
		else
		{
			return false;
		}
	}
	
	function lotto($code='', $description='', $num_tickets='', $ticket_price='', $start_date='', $end_date='', $state='', $winner='', $latest_cache='', $third_party='', $last_ticketnum='')
	{
		$this->_ticketsList = array();
		$this->code = $code;
		$this->description = $description;
		$this->num_tickets = $num_tickets;
		$this->ticket_price = $ticket_price;
		$this->start_date = $start_date;
		$this->end_date = $end_date;
		$this->state = $state;
		$this->winner = $winner;
		$this->latest_cache = $latest_cache;
		$this->third_party = $third_party;
		$this->last_ticketnum = $last_ticketnum;
	}
	
	
	/**
	* Gets object from database
	* @param integer $lottoId 
	* @return object $lotto
	*/
	function Get($lottoId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `lotto` where `lottoid`='".intval($lottoId)."' LIMIT 1";
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
			$this->third_party = $this->Unescape($row['third_party']);
			$this->last_ticketnum = $this->Unescape($row['last_ticketnum']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $lottoList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `lotto` ";
		$lottoList = Array();
		if (sizeof($fcv_array) > 0)
		{
			$this->pog_query .= " where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$this->pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) != 1)
					{
						$this->pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						if ($GLOBALS['configuration']['db_encoding'] == 1)
						{
							$value = POG_Base::IsColumn($fcv_array[$i][2]) ? "BASE64_DECODE(".$fcv_array[$i][2].")" : "'".$fcv_array[$i][2]."'";
							$this->pog_query .= "BASE64_DECODE(`".$fcv_array[$i][0]."`) ".$fcv_array[$i][1]." ".$value;
						}
						else
						{
							$value =  POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$this->Escape($fcv_array[$i][2])."'";
							$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
						}
					}
					else
					{
						$value = POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$fcv_array[$i][2]."'";
						$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
					}
				}
			}
		}
		if ($sortBy != '')
		{
			if (isset($this->pog_attribute_type[$sortBy]['db_attributes']) && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'SET')
			{
				if ($GLOBALS['configuration']['db_encoding'] == 1)
				{
					$sortBy = "BASE64_DECODE($sortBy) ";
				}
				else
				{
					$sortBy = "$sortBy ";
				}
			}
			else
			{
				$sortBy = "$sortBy ";
			}
		}
		else
		{
			$sortBy = "lottoid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$lotto = new $thisObjectName();
			$lotto->lottoId = $row['lottoid'];
			$lotto->code = $this->Unescape($row['code']);
			$lotto->description = $this->Unescape($row['description']);
			$lotto->num_tickets = $this->Unescape($row['num_tickets']);
			$lotto->ticket_price = $this->Unescape($row['ticket_price']);
			$lotto->start_date = $row['start_date'];
			$lotto->end_date = $row['end_date'];
			$lotto->state = $this->Unescape($row['state']);
			$lotto->winner = $this->Unescape($row['winner']);
			$lotto->latest_cache = $row['latest_cache'];
			$lotto->third_party = $this->Unescape($row['third_party']);
			$lotto->last_ticketnum = $this->Unescape($row['last_ticketnum']);
			$lottoList[] = $lotto;
		}
		return $lottoList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $lottoId
	*/
	function Save($deep = true)
	{
		$connection = Database::Connect();
		$this->pog_query = "select `lottoid` from `lotto` where `lottoid`='".$this->lottoId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `lotto` set 
			`code`='".$this->Escape($this->code)."', 
			`description`='".$this->Escape($this->description)."', 
			`num_tickets`='".$this->Escape($this->num_tickets)."', 
			`ticket_price`='".$this->Escape($this->ticket_price)."', 
			`start_date`='".$this->start_date."', 
			`end_date`='".$this->end_date."', 
			`state`='".$this->Escape($this->state)."', 
			`winner`='".$this->Escape($this->winner)."', 
			`latest_cache`='".$this->latest_cache."', 
			`third_party`='".$this->Escape($this->third_party)."', 
			`last_ticketnum`='".$this->Escape($this->last_ticketnum)."' where `lottoid`='".$this->lottoId."'";
		}
		else
		{
			$this->pog_query = "insert into `lotto` (`code`, `description`, `num_tickets`, `ticket_price`, `start_date`, `end_date`, `state`, `winner`, `latest_cache`, `third_party`, `last_ticketnum` ) values (
			'".$this->Escape($this->code)."', 
			'".$this->Escape($this->description)."', 
			'".$this->Escape($this->num_tickets)."', 
			'".$this->Escape($this->ticket_price)."', 
			'".$this->start_date."', 
			'".$this->end_date."', 
			'".$this->Escape($this->state)."', 
			'".$this->Escape($this->winner)."', 
			'".$this->latest_cache."', 
			'".$this->Escape($this->third_party)."', 
			'".$this->Escape($this->last_ticketnum)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->lottoId == "")
		{
			$this->lottoId = $insertId;
		}
		if ($deep)
		{
			foreach ($this->_ticketsList as $tickets)
			{
				$tickets->lottoId = $this->lottoId;
				$tickets->Save($deep);
			}
		}
		return $this->lottoId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $lottoId
	*/
	function SaveNew($deep = false)
	{
		$this->lottoId = '';
		return $this->Save($deep);
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete($deep = false, $across = false)
	{
		if ($deep)
		{
			$ticketsList = $this->GetTicketsList();
			foreach ($ticketsList as $tickets)
			{
				$tickets->Delete($deep, $across);
			}
		}
		$connection = Database::Connect();
		$this->pog_query = "delete from `lotto` where `lottoid`='".$this->lottoId."'";
		return Database::NonQuery($this->pog_query, $connection);
	}
	
	
	/**
	* Deletes a list of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param bool $deep 
	* @return 
	*/
	function DeleteList($fcv_array, $deep = false, $across = false)
	{
		if (sizeof($fcv_array) > 0)
		{
			if ($deep || $across)
			{
				$objectList = $this->GetList($fcv_array);
				foreach ($objectList as $object)
				{
					$object->Delete($deep, $across);
				}
			}
			else
			{
				$connection = Database::Connect();
				$pog_query = "delete from `lotto` where ";
				for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
				{
					if (sizeof($fcv_array[$i]) == 1)
					{
						$pog_query .= " ".$fcv_array[$i][0]." ";
						continue;
					}
					else
					{
						if ($i > 0 && sizeof($fcv_array[$i-1]) !== 1)
						{
							$pog_query .= " AND ";
						}
						if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
						{
							$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$this->Escape($fcv_array[$i][2])."'";
						}
						else
						{
							$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$fcv_array[$i][2]."'";
						}
					}
				}
				return Database::NonQuery($pog_query, $connection);
			}
		}
	}
	
	
	/**
	* Gets a list of tickets objects associated to this one
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array of tickets objects
	*/
	function GetTicketsList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$tickets = new tickets();
		$fcv_array[] = array("lottoId", "=", $this->lottoId);
		$dbObjects = $tickets->GetList($fcv_array, $sortBy, $ascending, $limit);
		return $dbObjects;
	}
	
	
	/**
	* Makes this the parent of all tickets objects in the tickets List array. Any existing tickets will become orphan(s)
	* @return null
	*/
	function SetTicketsList(&$list)
	{
		$this->_ticketsList = array();
		$existingTicketsList = $this->GetTicketsList();
		foreach ($existingTicketsList as $tickets)
		{
			$tickets->lottoId = '';
			$tickets->Save(false);
		}
		$this->_ticketsList = $list;
	}
	
	
	/**
	* Associates the tickets object to this one
	* @return 
	*/
	function AddTickets(&$tickets)
	{
		$tickets->lottoId = $this->lottoId;
		$found = false;
		foreach($this->_ticketsList as $tickets2)
		{
			if ($tickets->ticketsId > 0 && $tickets->ticketsId == $tickets2->ticketsId)
			{
				$found = true;
				break;
			}
		}
		if (!$found)
		{
			$this->_ticketsList[] = $tickets;
		}
	}
}
?>