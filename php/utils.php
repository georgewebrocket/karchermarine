<?php


class arrayfunctions
{
    
    //Array function
    static function filter_by_value ($array, $index, $value){
        $i=0;
        $newarray = array();
        if(is_array($array) && count($array)>0) 
        {            
            foreach(array_keys($array) as $key){
                $temp[$key] = $array[$key][$index];
                
                if ($temp[$key] == $value){
                    $newarray[$i] = $array[$key];
                    $i++;
                }                
            }
            //return $newarray;
        }
        return $newarray;
    } 
    
}

class func
{
    
	static function cookiesEnabled() {
		setcookie("test_cookie", "test", time() + 3600, '/');
		if(count($_COOKIE) > 0) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
	
	static function normURL($str) {
        $res = str_replace(" ", "-", $str);
		$res = str_replace("&", "-", $res);
		$res = str_replace("<", "-", $res);
		$res = str_replace(">", "-", $res);
		$res = str_replace("/", "-", $res);
		/*$res = str_replace(",", "-", $str);
		$res = str_replace("-----", "-", $str);
		$res = str_replace("----", "-", $str);
		$res = str_replace("---", "-", $str);
		$res = str_replace("--", "-", $str);*/
        $res = mb_convert_case($res, MB_CASE_LOWER, "UTF-8");         
        $normalizeChars = array('ά'=>'α', 'έ'=>'ε', 'ή'=>'η', 'ί'=>'ι', 'ό'=>'ο', 'ώ'=>'ω', 'ύ'=>'υ');
        $res = strtr($res, $normalizeChars);        
        return $res;
    }
	
	
	static function str14toDate($str14, $delimiter="-", $locale = "GR") {
        if (strlen($str14)!=14) {
            return $str14;
        } 
        $YYYY = substr($str14, 0, 4);
        $MM = substr($str14, 4, 2);
        $DD = substr($str14, 6, 2);
        switch ($locale) {
            case "GR":
                return $DD.$delimiter.$MM.$delimiter.$YYYY;
                break;
            case "EN":
                return $YYYY.$delimiter.$MM.$delimiter.$DD;
                break;
            default:
        }
        
    }
    
    static function dateTo14str($val, $delimiter = array("/","-","."), $locale = "GR") {
        $delem = self::explode_by_array($delimiter, $val);
        switch ($locale) {
            case "GR":
                return $delem[2].$delem[1].$delem[0]."000000";
                break;
            case "EN":
                return $delem[2].$delem[0].$delem[1]."000000";
                break;
            default:
        }
    }
    
    static function explode_by_array($delim, $input) {
        $unidelim = $delim[0];
        $step_01 = str_replace($delim, $unidelim, $input); //Extra step to create a uniform value
        return explode($unidelim, $step_01);
    }
    
    static function format($val,$type,$locale="GR") {
        switch ($type) {
            case "DATE":
                return self::str14toDate($val, "/", $locale);
                break;
            case "CURRENCY":
                return self::nrToCurrency($val, $locale);
                break;
            case "YESNO":
                return self::yesno($val);
            case "YESNOHASCONTENT":
                return self::yesno($val, "CUSTOM", array("......",""));
            default :
                return $val;
        }
    }
    
    static function nrToCurrency($val,$locale="GR") {
        switch ($locale) {
            case "GR":
                //echo "VAL=".number_format($val, 2, ",", ".");
                return number_format($val, 2, ",", ".");
                break;
            case "EN":
                return number_format($val, 2, ".", ",");
                break;
            default :
        }
    }
    
    static function CurrencyToNr($val,$locale="GR") {
        $mystr = $val;
        switch ($locale) {
            case "GR":
                $mystr = str_replace(".", "", $val);
                $mystr = str_replace(",", ".", $val);
                return $mystr;
                break;
            case "EN":
                $mystr = str_replace(",", "", $val);
                return $mystr;
                break;
            default :
        }
    }
    
    static function vlookup($fieldname, $tablename, $criteria, $conn)
    {
        $ssql = "SELECT " . $fieldname . " FROM " . $tablename . " WHERE " . $criteria;	
        $all_rows = $conn->getRS($ssql);
        $iCount = count($all_rows);
        if ($iCount > 0) {
            return $all_rows[0][$fieldname];
        }
        else {
            return "";	
        }
    }
    
    static function yesno($val, $locale="GR", $arrayYN = NULL)
    {
        switch ($locale) {
            case "GR":
                switch ($val){
                    case 1:
                        return "Ναι";
                        break;
                    case 2:
                        return "Όχι";
                        break;
                    default:
                        return "Όχι";
                        break;
                }
            case "EN":
                switch ($val){
                    case 1:
                        return "Υes";
                        break;
                    case 2:
                        return "Νo";
                        break;
                    default:
                        return "Νo";
                        break;
                }
            case "CUSTOM":
                        switch ($val){
                    case 1:
                        return $arrayYN[0];
                        break;
                    case 2:
                        return $arrayYN[1];
                        break;
                    default:
                        return "";
                        break;
                }
                 
        }
    }
    
    static function validateDate($date, $format = "", $locale="GR")
    {
        if($format == ""){
            switch ($locale) {
                case "GR":
                    $format = "d/m/Y";
                    break;
                case "EN":
                    $format = "Y/m/d";
                    break;

            }            
        }
        $d = DateTime::createFromFormat($format, $date);
        return var_dump($d && $d->format($format) == $date);
    }
    
    static function shortDescription($str,$length,$LR = "LEFT")
    {
        $myStr = $str;
        if (strlen($str) > $length){
            switch($LR){
                case "LEFT":
                    $myStr = substr($str,0,$length)." ...";
                    break;
                case "RIGHT":
                    $myStr = substr($str,-1,$length)." ...";
                    break;
            }
        }
        return $myStr;        
    }
    
    static function rsSum($rs,$col) {
        $res = 0;
        for ($i=0;$i<count($rs);$i++) {
            $res += $rs[$i][$col];
        }
        return $res;
    }
    
    static function get_category_path($catId, $conn) {
        $sep = '-';
        $ssql = "SELECT T2.id".
        " FROM ( ".
            "SELECT ".
                "@r AS _id, ".
                "(SELECT @r := parentid FROM CATEGORIES WHERE id = _id) AS parentid, ".
                "@l := @l + 1 AS lvl ".
            "FROM ".
                "(SELECT @r := ".$catId." , @l := 0) vars, ".
                "CATEGORIES h ".
            "WHERE @r <> 0) T1 ".
        "JOIN CATEGORIES T2 ".
        "ON T1._id = T2.id ".
        "ORDER BY T1.lvl DESC ";
        $result = $conn->getRS($ssql);
        $arrPath = array();
        for($i=0;$i<count($result);$i++){
            array_push($arrPath, $result[$i]['id']); 
        }
        $strPath = $sep.implode($sep, $arrPath).$sep;
        return $strPath;
    }
    
    static function ConcatSpecial($str1,$str2,$delimiter) {
        if ($str=="") {
            return $str2;
        }
        else {
            return $str1 . $delimiter . $str2;
        }
    }
	
	static function clearHtml($str) {
        $str = str_replace("<p>", "", $str);
        $str = str_replace("</p>", "", $str);
        $str = str_replace("<span>", "", $str);
        $str = str_replace("</span>", "", $str);
        //$str = str_replace("<br/>", "", $str);
        return $str;
    }
    
    
            
    
        
}


class MyUtils
{	
	static function sanit($unsafe_variable) {
		return mysql_real_escape_string($unsafe_variable);
	}
	
	//pros8etei kritiria se ena sql string
    static function AddCriteria(&$ssql, $criteria)
    {
        if (strpos($ssql, "WHERE")>0)
        {
            $ssql .= " AND (" . $criteria . ")";
        }
        else 
        {
            $ssql .= " WHERE (" . $criteria . ")";
        }
    }
    
    //sygkrinei 2 strings me ids ta opoia xwrizontai me sygkekrimeno tropo px me ,
    //kai an kapoio stoixeio tou prwtou string yparxei sto deftero tote epistrefei true
    //alliws false
    //paradeigma: CompareIds_("1,22","-[33][22][2]",",","[","]") => TRUE
    static function CompareIds_($Ids1, $Ids2, $delimiter1, $char1, $char2)
    {
        $arIds1 = explode($delimiter, $Ids1);
        
        for ($i=0;$i<count($arIds1);$i++)
        {
            if (strpos($Ids2, $char1 . $arIds1[$i] . $char2)>0)
            {
                return TRUE;
            }
        }
        return FALSE;        
    }
    
    static function CompareIds($Ids1, $Ids2)
    {
        return CompareIds_($Ids1, $Ids2, ",", "[", "]");
    }
    
    //Array function
    static function filter_by_value ($array, $index, $value){
        if(is_array($array) && count($array)>0) 
        {
            foreach(array_keys($array) as $key){
                $temp[$key] = $array[$key][$index];
                
                if ($temp[$key] == $value){
                    $newarray[$key] = $array[$key];
                }
            }
          }
      return $newarray;
    } 
    
    //Array function
    static function filter_by_value_new_key ($array, $index, $value){
        $i=0;
        if(is_array($array) && count($array)>0) 
        {            
            foreach(array_keys($array) as $key){
                $temp[$key] = $array[$key][$index];
                
                if ($temp[$key] == $value){
                    $newarray[$i] = $array[$key];
                    $i++;
                }                
            }
          }
      return $newarray;
    } 
    
    //Array function
    static function filter_by_criteria ($array, $index, $value, $criteria) {
        $i=0;
        $condition = FALSE;
        if(is_array($array) && count($array)>0) 
        {            
            foreach(array_keys($array) as $key){
                $temp[$key] = $array[$key][$index];
                
                switch ($criteria) {
                    case '=':
                        $condition = ($temp[$key] == $value);
                        break;
                    case '==':
                        $condition = ($temp[$key] == $value);
                        break;
                    case '>':
                        $condition = ($temp[$key] > $value);
                        break;
                    case '>=':
                        $condition = ($temp[$key] >= $value);
                        break;
                    case '<':
                        $condition = ($temp[$key] < $value);
                        break;
                    case '<=':
                        $condition = ($temp[$key] <= $value);
                        break;
                    case '!=':
                        $condition = ($temp[$key] != $value);
                        break;

                    default:
                        break;
                }
                
                if ($condition){
                    $newarray[$i] = $array[$key];
                    $i++;
                }                
            }
          }
      return $newarray;
    }
        
    
    //Array function
    static function filter_by_ids ($array, $index, $values){
        $i=0;
        if(is_array($array) && count($array)>0) 
        {            
            foreach(array_keys($array) as $key){
                $temp[$key] = $array[$key][$index];
                //echo strpos($values,"[$temp[$key]]") . ",";
                if (strpos($values,"[$temp[$key]]")>0) {
                    $newarray[$i] = $array[$key];
                    $i++;
                }                
            }
          }
      return $newarray;
    }
    
    static function get_ids($array, $index, $unionstr) {
        $my_ids = "";
		
		/*foreach($array as $item){
			echo "array".$item[$index]."</br>";
			$my_ids = $this->myconcat($my_ids, $item[$index], $unionstr);	
		}*/
		
		for ($i=0;$i<count($array);$i++) {
			$my_ids = $this->myconcat($my_ids, $array[$i][$index], $unionstr);
        }
		return $my_ids;
    }
	
	static function myconcat($firststr, $secondstr, $unionstr)
	{	
		if ($firststr=="") {
			return $secondstr;
		}
		else
		{
			return $firststr . $unionstr . $secondstr;
		}
		
	}
	
	static function myconcat2($firststr, $secondstr, $unionstr)
	{	
		if ($secondstr=="") {
			return $firststr;
		}
		else
		{
			return $firststr . $unionstr . $secondstr;
		}
		
	}

    //convert string to time format
    //px 3,29 => 3:29
    static function convert_totime($mystr) {
        $mystr = str_replace(',', ':', $mystr); 
        $mystr = str_replace('.', ':', $mystr);
        //...
        return $mystr;
    }
    
    static function convert_to_secs($myduration) {
        $myar = explode(":", $myduration);        
        $mymins = (int)$myar[0];
        $mysecs = (int)$myar[1];
        $mytime = $mymins * 60 + $mysecs;
        return $mytime;
    }
    
    static function vpn_path($mypath) {
        $myStr = str_replace(MyConfig::$local_mp3_str, MyConfig::$vpn_mp3_str, $mypath);
        $myStr = str_replace(MyConfig::$local_mp3_str2, MyConfig::$vpn_mp3_str, $myStr);
        $myStr = str_replace("\\", "/", $myStr);
        $myStr = urlencode($myStr);
        return $myStr;
    }
	
	static function curPageURL() {
	 	$pageURL = 'http';
	 	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 	$pageURL .= "://";
	 	if ($_SERVER["SERVER_PORT"] != "80") {
	  		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 	} else {
	  		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 	}
	 	return $pageURL;
	}
	
	static function get_img_src($img)
	{
		$pos1 = strpos($img, "src=\"");
		$pos2 = strpos($img, "\"", $pos1+5);
		return substr($img, $pos1+5, $pos2-$pos1-5);
	}	
	
	 static function GetNode($SearchInto, $NodeTag) {
        $ipos1 = strpos($SearchInto, '<' . $NodeTag . '>');
        $ipos2 = strpos($SearchInto, '</' . $NodeTag . '>');
        $istart = $ipos1 + strlen($NodeTag) + 2;
        $ilength = $ipos2 - $istart;
        return substr($SearchInto, $istart, $ilength);
    }
    
    static function str_code_replace($str,$arrWithReplacement,$arrPossitions ){
        //p.x
        //$arrPossitions = array(array(0,1),array(1,3),array(4,3),array(7,1));
        //$arrWithReplacement = array(".","-",".");
        $arr = array();
        $result = "";
        foreach ($arrPossitions as $key => $valuePos) {
            $arr[] = substr($str, $valuePos[0],$valuePos[1]);
        }
        foreach ($arr as $key => $value) {
            $result .= $value.$arrWithReplacement[$key];
        }
        return $result;
    }
    
    static function set_codes($str_codes){
        $result = "";
        if(trim($str_codes) != ""){
            $arr_result = explode(",",$str_codes);        
            foreach ($arr_result as $key => $my_item_code) {
                $arr_result[$key] =  "[".$arr_result[$key]."]";
            }
            $result = implode(",", $arr_result);
        }
        return $result;
    }

    static function get_codes($str_codes){
        $result = "";
        if(trim($str_codes) != ""){
            $arr_result = explode(",",$str_codes);
            foreach ($arr_result as $key => $my_item_code) {
                $arr_result[$key] = str_replace(array("[","]"), "", $arr_result[$key]);
            }
            $result = implode(",", $arr_result);
        }
        return $result;
    }
	
    
}

class categories_view
{
    protected $_myconn, $_ssql, $_data, $_index, $_parent_id, $_level, $_rs_child_nodes; 
    public function __construct($myconn, $ssql, $parent_id, $level) {
        $this->_myconn = $myconn;
        $this->_ssql = $ssql;
        $this->_parent_id = $parent_id;
        $this->_level = $level;
        $this->_data = array();
        $this->_index = array();
        $this->_rs_child_nodes = array();
        
        $rows = $this->_myconn->getRS($this->_ssql);
        
        foreach ($rows as $value) {
            $id = $value["id"];
            $parent_id = $value["parent_id"] === NULL ? "NULL" : $value["parent_id"];
            $this->_data[$id] = $value;
            $this->_index[$parent_id][] = $id;
        }
    }

    /*
     * Recursive top-down tree traversal example:
     * Indent and print child nodes
     */
    function display_child_nodes($parent_id, $level)
    {
        /*
         * Electronics
            -Cameras and Photography
            --Accessories
            --Camcorders
            --Digital Cameras
         */
        $parent_id = $parent_id === NULL ? "NULL" : $parent_id;
        if (isset($this->_index[$parent_id])) {
            foreach ($this->_index[$parent_id] as $id) {
                //echo str_repeat("-|", $level) . $this->_data[$id]["name"]."</br>";
                array_push($this->_rs_child_nodes, str_repeat("-", $level) . $this->_data[$id]["name"]);
                $this->display_child_nodes($id, $level + 1);
            }
        }
    }
    
    function get_tree($parent_id, $level){
        $this->display_child_nodes($parent_id, $level);
        return $this->_rs_child_nodes;
    }
    
    
    function display_child_nodes_for_combobox($parent_id, $level)
    {
        /*
         * Electronics
            -Cameras and Photography
            --Accessories
            --Camcorders
            --Digital Cameras
         */
        $parent_id = $parent_id === NULL ? "NULL" : $parent_id;
        if (isset($this->_index[$parent_id])) {
            foreach ($this->_index[$parent_id] as $id) {
                $item = array();
                $item["id"] = $this->_data[$id]["id"];
                $item["description"] = str_repeat("-", $level) . $this->_data[$id]["name"];
                $item["parent_id"] = $this->_data[$id]["parent_id"];
                array_push($this->_rs_child_nodes, $item);
                $this->display_child_nodes_for_combobox($id, $level + 1);
            }
        }
    }
    
    function get_tree_for_combobox($parent_id, $level){
        $this->display_child_nodes_for_combobox($parent_id, $level);
        return $this->_rs_child_nodes;
    }
    
    /*
    * Retrieving nodes using return statement:
    * Get ids of child nodes
    */
   function get_child_nodes2($parent_id)
   {
       /*
        * $children = get_child_nodes2(5); /* TV and Audio */
        /*    echo implode("\n", $children);*/
        
       $children = array();
       $parent_id = $parent_id === NULL ? "NULL" : $parent_id;
       if (isset($this->_index[$parent_id])) {
           foreach ($this->_index[$parent_id] as $id) {
               $children[] = $id;
               $children = array_merge($children, $this->get_child_nodes2($id));
           }
       }
       return $children;
   }
   
	/*
	 * Display parent nodes
	 */
	function display_parent_nodes($id, $withCurrent = FALSE)
	{
		//global $data;
		$current = $this->_data[$id];
		$parent_id = $current["parent_id"] === NULL ? "NULL" : $current["parent_id"];
		$parents = array();
                if($withCurrent){
                    $i=count($parents);
                    $parents[$i]['name'] = $current["name"];
                    $parents[$i]['id'] = $current["id"];
                }
		while (isset($this->_data[$parent_id])) {
                        $i=count($parents);
			$current = $this->_data[$parent_id];
			$parent_id = $current["parent_id"] === NULL ? "NULL" : $current["parent_id"];
			$parents[$i]['name'] = $current["name"];
                        $parents[$i]['id'] = $current["id"];
		}
                
		//echo implode(" > ", array_reverse($parents));
                return array_reverse($parents);
	}
	/*display_parent_nodes(24); /* iPad */
   
   
}



?>