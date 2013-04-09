<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `alecache` (
	`alecacheid` int(11) NOT NULL auto_increment,
	`host` varchar(64) NOT NULL,
  	`path` varchar(64) NOT NULL,
  	`params` varchar(64) NOT NULL,
  	`content` longtext NOT NULL,
  	`cachedUntil` datetime default NULL,
  	PRIMARY KEY  (`alecacheid`,`host`,`path`,`params`)) DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;
*/

/**
* <b>alecache</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0e / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=alecache&attributeList=array+%28%0A++0+%3D%3E+%27host%27%2C%0A++1+%3D%3E+%27path%27%2C%0A++2+%3D%3E+%27params%27%2C%0A++3+%3D%3E+%27content%27%2C%0A++4+%3D%3E+%27cachedUntil%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++1+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++2+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++3+%3D%3E+%27LONGTEXT%27%2C%0A++4+%3D%3E+%27DATETIME%27%2C%0A%29
*/
include_once('class.pog_base.php');
class alecache extends POG_Base
{
	public $alecacheId = '';

	/**
	 * @var VARCHAR(64)
	 */
	public $host;
	
	/**
	 * @var VARCHAR(64)
	 */
	public $path;
	
	/**
	 * @var VARCHAR(64)
	 */
	public $params;
	
	/**
	 * @var LONGTEXT
	 */
	public $content;
	
	/**
	 * @var DATETIME
	 */
	public $cachedUntil;
	
	public $pog_attribute_type = array(
		"alecacheId" => array('db_attributes' => array("NUMERIC", "INT")),
		"host" => array('db_attributes' => array("TEXT", "VARCHAR", "64")),
		"path" => array('db_attributes' => array("TEXT", "VARCHAR", "64")),
		"params" => array('db_attributes' => array("TEXT", "VARCHAR", "64")),
		"content" => array('db_attributes' => array("TEXT", "LONGTEXT")),
		"cachedUntil" => array('db_attributes' => array("TEXT", "DATETIME")),
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
	
	function alecache($host='', $path='', $params='', $content='', $cachedUntil='')
	{
		$this->host = $host;
		$this->path = $path;
		$this->params = $params;
		$this->content = $content;
		$this->cachedUntil = $cachedUntil;
	}
	
	
	/**
	* Gets object from database
	* @param integer $alecacheId 
	* @return object $alecache
	*/
	function Get($alecacheId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `alecache` where `alecacheid`='".intval($alecacheId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->alecacheId = $row['alecacheid'];
			$this->host = $this->Unescape($row['host']);
			$this->path = $this->Unescape($row['path']);
			$this->params = $this->Unescape($row['params']);
			$this->content = $this->Unescape($row['content']);
			$this->cachedUntil = $row['cacheduntil'];
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $alecacheList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `alecache` ";
		$alecacheList = Array();
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
			$sortBy = "alecacheid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$alecache = new $thisObjectName();
			$alecache->alecacheId = $row['alecacheid'];
			$alecache->host = $this->Unescape($row['host']);
			$alecache->path = $this->Unescape($row['path']);
			$alecache->params = $this->Unescape($row['params']);
			$alecache->content = $this->Unescape($row['content']);
			$alecache->cachedUntil = $row['cacheduntil'];
			$alecacheList[] = $alecache;
		}
		return $alecacheList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $alecacheId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `alecacheid` from `alecache` where `alecacheid`='".$this->alecacheId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `alecache` set 
			`host`='".$this->Escape($this->host)."', 
			`path`='".$this->Escape($this->path)."', 
			`params`='".$this->Escape($this->params)."', 
			`content`='".$this->Escape($this->content)."', 
			`cacheduntil`='".$this->cachedUntil."' where `alecacheid`='".$this->alecacheId."'";
		}
		else
		{
			$this->pog_query = "insert into `alecache` (`host`, `path`, `params`, `content`, `cacheduntil` ) values (
			'".$this->Escape($this->host)."', 
			'".$this->Escape($this->path)."', 
			'".$this->Escape($this->params)."', 
			'".$this->Escape($this->content)."', 
			'".$this->cachedUntil."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->alecacheId == "")
		{
			$this->alecacheId = $insertId;
		}
		return $this->alecacheId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $alecacheId
	*/
	function SaveNew()
	{
		$this->alecacheId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `alecache` where `alecacheid`='".$this->alecacheId."'";
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
			$pog_query = "delete from `alecache` where ";
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
?>