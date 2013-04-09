<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `tickets` (
	`ticketsid` int(11) NOT NULL auto_increment,
	`lottoid` int(11) NOT NULL,
	`pilot_name` VARCHAR(255) NOT NULL,
	`ticket_number` INT NOT NULL, INDEX(`lottoid`), PRIMARY KEY  (`ticketsid`)) ENGINE=MyISAM;
*/

/**
* <b>tickets</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0e / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=tickets&attributeList=array+%28%0A++0+%3D%3E+%27lotto%27%2C%0A++1+%3D%3E+%27pilot_name%27%2C%0A++2+%3D%3E+%27ticket_number%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527BELONGSTO%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527INT%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class tickets extends POG_Base
{
	public $ticketsId = '';

	/**
	 * @var INT(11)
	 */
	public $lottoId;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $pilot_name;
	
	/**
	 * @var INT
	 */
	public $ticket_number;
	
	public $pog_attribute_type = array(
		"ticketsId" => array('db_attributes' => array("NUMERIC", "INT")),
		"lotto" => array('db_attributes' => array("OBJECT", "BELONGSTO")),
		"pilot_name" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"ticket_number" => array('db_attributes' => array("NUMERIC", "INT")),
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
	
	function tickets($pilot_name='', $ticket_number='')
	{
		$this->pilot_name = $pilot_name;
		$this->ticket_number = $ticket_number;
	}
	
	
	/**
	* Gets object from database
	* @param integer $ticketsId 
	* @return object $tickets
	*/
	function Get($ticketsId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `tickets` where `ticketsid`='".intval($ticketsId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->ticketsId = $row['ticketsid'];
			$this->lottoId = $row['lottoid'];
			$this->pilot_name = $this->Unescape($row['pilot_name']);
			$this->ticket_number = $this->Unescape($row['ticket_number']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $ticketsList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `tickets` ";
		$ticketsList = Array();
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
			$sortBy = "ticketsid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$tickets = new $thisObjectName();
			$tickets->ticketsId = $row['ticketsid'];
			$tickets->lottoId = $row['lottoid'];
			$tickets->pilot_name = $this->Unescape($row['pilot_name']);
			$tickets->ticket_number = $this->Unescape($row['ticket_number']);
			$ticketsList[] = $tickets;
		}
		return $ticketsList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $ticketsId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `ticketsid` from `tickets` where `ticketsid`='".$this->ticketsId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `tickets` set 
			`lottoid`='".$this->lottoId."', 
			`pilot_name`='".$this->Escape($this->pilot_name)."', 
			`ticket_number`='".$this->Escape($this->ticket_number)."' where `ticketsid`='".$this->ticketsId."'";
		}
		else
		{
			$this->pog_query = "insert into `tickets` (`lottoid`, `pilot_name`, `ticket_number` ) values (
			'".$this->lottoId."', 
			'".$this->Escape($this->pilot_name)."', 
			'".$this->Escape($this->ticket_number)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->ticketsId == "")
		{
			$this->ticketsId = $insertId;
		}
		return $this->ticketsId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $ticketsId
	*/
	function SaveNew()
	{
		$this->ticketsId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `tickets` where `ticketsid`='".$this->ticketsId."'";
		return Database::NonQuery($this->pog_query, $connection);
	}
	
	
	/**
	* Deletes a list of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param bool $deep 
	* @return 
	*/
	function DeleteList($fcv_array)
	{
		if (sizeof($fcv_array) > 0)
		{
			$connection = Database::Connect();
			$pog_query = "delete from `tickets` where ";
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
	
	
	/**
	* Associates the lotto object to this one
	* @return boolean
	*/
	function GetLotto()
	{
		$lotto = new lotto();
		return $lotto->Get($this->lottoId);
	}
	
	
	/**
	* Associates the lotto object to this one
	* @return 
	*/
	function SetLotto(&$lotto)
	{
		$this->lottoId = $lotto->lottoId;
	}
}
?>