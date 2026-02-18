<?php

class content
{	
	static function breadcrumbs($type, $post) {
		
		if ($type=="wp") {
			if(count($post->get_post_categories_ids()) > 0){
				$myAr = $post->get_post_categories_ids();
				$cat_id = $myAr[0];
			}else{
				$cat_id = 0;
			}
			$tprefix =  $post->get_tprefix();			
			$sql = "SELECT {$tprefix}terms.term_id AS id, {$tprefix}terms.name, {$tprefix}term_taxonomy.parent AS parent_id FROM  {$tprefix}term_taxonomy INNER JOIN {$tprefix}terms on {$tprefix}term_taxonomy.term_id = {$tprefix}terms.term_id WHERE taxonomy =  'category'";
			$cat_view = new categories_view($post->get_dbo(),$sql,0,0);
			$breadcrumbs = $cat_view->display_parent_nodes($cat_id, TRUE);
			$breadcrumbs_str = '';
			$breadcrumbs_str = '<ul>';
			$breadcrumbs_str .= '<li><a href="'.app::$host.'">Home</a></li>';
			foreach ($breadcrumbs as $key => $value) {
				if ($breadcrumbs[$key]['id']!="") {
				$breadcrumbs_str .= '<li><a href="wpcategory/'.$breadcrumbs[$key]['id'].'">'.$breadcrumbs[$key]['name'].'</a></li>';
				}
			}
			$breadcrumbs_str .= '<li class="current">'.$post->get_custom_field('H1').'</li>';;
			$breadcrumbs_str .= '</ul>';
			return $breadcrumbs_str;
		}
		else if ($type=="app") {
			//...
		}
			
	}
	
	
	static function richcontent($str, $params = NULL) {
		
		$str = str_replace("\r\n\r\n", "</p><p>", $str);
		
		$str = str_replace("[COL-9]", "<div class=\"col-9 col-sm-12\"><div style=\"margin-right:20px\">", $str);
		$str = str_replace("[COL-8]", "<div class=\"col-8 col-sm-12\"><div style=\"margin-right:20px\">", $str);
		$str = str_replace("[COL-6]", "<div class=\"col-6 col-sm-12\"><div style=\"margin-right:20px\">", $str);
		$str = str_replace("[COL-4]", "<div class=\"col-4 col-sm-12\"><div style=\"margin-right:20px\">", $str);
		$str = str_replace("[COL-3]", "<div class=\"col-3 col-sm-12\"><div style=\"margin-right:20px\">", $str);
		$str = str_replace("[COL-2]", "<div class=\"col-2 col-sm-6\"><div style=\"margin-right:20px\">", $str);
		$str = str_replace("[COL-1]", "<div class=\"col-1 col-sm-4\"><div style=\"margin-right:20px\">", $str);
		$str = str_replace(array("[/COL-9]", "[/COL-8]", "[/COL-6]", "[/COL-4]", "[/COL-3]", "[/COL-2]", "[/COL-1]"), "</div></div>", $str);
		
		$str = str_replace("[CLEAR]", "<div style=\"clear:both\"></div>", $str);
		$str = str_replace("[CLEAR-50]", "<div style=\"clear:both; height:50px\"></div>", $str);		
		$str = str_replace("[LINE]", "<div class=\"line\"></div>", $str);
		
		$str = self::replaceblock2("[BUTTON]","[/BUTTON]", $str, "button");		
		
		$str = self::replaceblock2("[2-COLS]","[/2-COLS]", $str, "twoCols");
		$str = self::replaceblock2("[3-COLS]","[/3-COLS]", $str, "threeCols");
		$str = self::replaceblock2("[PRODUCTS]","[/PRODUCTS]", $str, "getproducts", $params);
		$str = self::replaceblock2("[PRODUCTS2]","[/PRODUCTS2]", $str, "getproducts2");
		$str = self::replaceblock2("[TABLE]","[/TABLE]", $str, "createTable");
		
		$str = self::replaceblock2("[TABS]","[/TABS]", $str, "tabs");                       
                $str = self::replaceblock2("[IMG-COMPARE]","[/IMG-COMPARE]", $str, "twentytwenty");
						
		return "<p>".$str."</p>";
			
	}
	
	static function getblock($codestart, $codeend, $str) {
		$block = array();
		$pos1 = TRUE;
		do {
			$pos1 = strpos($str, $codestart) ;
			if ($pos1!==FALSE) {
				$mypos1 = $pos1 + strlen($codestart);
				$pos2 = strpos($str, $codeend);
				$newblock = substr($str, $mypos1, $pos2-$mypos1);
				array_push($block, $newblock);
				$str = substr($str, $pos2 + strlen($codeend));
			}
		} while ($pos1);
		
		return $block;			
	}
	
	static function replaceblock($codestart, $codeend, $str, $block) {		
		$pos1 = TRUE; $mystr = ''; $i=0;
		do {
			$pos1 = strpos($str, $codestart) ;
			if ($pos1!==FALSE) {
				$mypos1 = $pos1 + strlen($codestart);
				$pos2 = strpos($str, $codeend);
				$mystr .= substr($str, 0, $pos1);
				$mystr .= $block[$i];
				$i++;
				$str = substr($str, $pos2 + strlen($codeend));
			}
		} while ($pos1);
		$mystr .= $str;
		return $mystr;		
	}
	
	static function replaceblock2($codestart, $codeend, $str, $function, $params = NULL) {		
		
		$pos1 = TRUE; $mystr = '';
		do {
			$pos1 = strpos($str, $codestart) ;
			if ($pos1!==FALSE) {
				$mypos1 = $pos1 + strlen($codestart);
				$pos2 = strpos($str, $codeend);
				$block = substr($str, $mypos1, $pos2-$mypos1);
				$block = self::$function($block, $params);
				$mystr .= substr($str, 0, $pos1);
				$mystr .= $block;
				$str = substr($str, $pos2 + strlen($codeend));
			}
		} while ($pos1);
		$mystr .= $str;
		return $mystr;		
	}
	
	
	/*static function replaceblock3($codestart, $codeend, $str, $function) {
		$pos1 = TRUE; $mystr = '';
		do {
			$pos1 = strpos($str, $codestart) ;
			if ($pos1!==FALSE) {
				$mypos1 = $pos1 + strlen($codestart);
				$pos2 = strpos($str, $codeend);
				$block = substr($str, $mypos1, $pos2-$mypos1);
				$block = self::$function($block, $params);
				$mystr .= substr($str, 0, $pos1);
				$mystr .= $block;
				$str = substr($str, $pos2 + strlen($codeend));
			}
		} while ($pos1);
		$mystr .= $str;
		return $mystr;
	
	}
	*/
	
	
	
	
	static function bold($str) {
		return "<strong>".$str."</strong>";
	}
	
	static function button($str) {
		$str = str_replace(array("<p>", "</p>", "<br/>", "<br />"), "", $str);
		$ar = explode("==", $str);
		if (count($ar)==2) {
		return "<a href=\"$ar[1]\" class=\"button\">$ar[0]</a>";
		}
		if (count($ar)==3) {
		return "<a target=\"$ar[2]\" href=\"$ar[1]\" class=\"button\">$ar[0]</a>";
		}
		
	}
	
	static function tabs($str) {
		$tabsmenu = '';
		$tabscontent = '';
        $result = '';
		$ar = explode("====", $str);
                if($ar[0] != ""){
                    for ($i=0;$i<count($ar);$i++) {
                            $details = explode("==", $ar[$i]);
                            $tabsmenu .= "<li class=\"tab-menu-item\"><a href=\"#tab-$i\">".$details[0]."</a></li>";			
                            $tabscontent .= "<div class=\"tab-content\" style=\"clear:both;\" id=\"tab-$i\"><h2>".$details[1]."</h2>" .
                                    "<div>".$details[2]."</div></div>";
                    }

                    $tabsmenu = str_replace(array("</p>","<p>"), "", $tabsmenu);

                    $result = "<ul id=\"tab-menu\" class=\"tab-menu col-sm-0\">".$tabsmenu . "<div style=\"clear:both\"></div></ul>" . 
                            "<div style=\"clear:both; height:30px\"></div>" .
                            $tabscontent;
                }
                return $result;
		
	}
	
	static function twoCols($str) {
		return "<div class=\"two-cols\"".$str."</div>";	
	}
	
	static function threeCols($str) {
		return "<div class=\"three-cols\"".$str."</div>";	
	}
	
	static function img100($str) {
		return "<div class=\"img-100\"".$str."</div>";	
	}
	
	static function imgLeft($str) {
		return "<div class=\"imgLeft\"".$str."</div>";	
	}
	
	static function getproducts($str, $params) {
        //print_r($params);
		$cat = $params[0];
		$curpage = count($params)>1? $params[1]: 0;
		$sort = count($params)>2? $params[2]: 0;
		$str = file_get_contents(app::$host."_products.php?id=".$cat."&curpage=".
			$curpage."&sort=".$sort);
			//echo $str;
		return $str;
	}
	
	static function getproducts2($str) {
		$ids = $str;
		$str = file_get_contents(app::$host.'products-inc.php?PRODUCT-INC=related_product&PRODUCT_CODES='.$ids);
		return "<div class=\"container-related-product\">".$str."</div>";
	}
	
	static function createTable($str) {
		$result = '';
		$rows = explode("====",$str);
		$result = "<table width=\"100%\" cellspacing=\"1\" class=\"thetable\">";
		for ($i=0;$i<count($rows);$i++) {
			$result .= "<tr>";
			$cells = explode("==",$rows[$i]);	
			for ($k=0;$k<count($cells);$k++) {
				$result .= "<td>";
				$result .= $cells[$k];
				$result .= "</td>";	
			}
			$result .= "/<tr>";
		}
		$result .= "</table>";
		return $result;	
	}
        
        static function twentytwenty($str) {
            $res = "<div class=\"twentytwenty-container\" style=\"height:600px\">";
            $res .= $str;
            $res .= "</div>";
            
            $script = <<<EOT
<script src="js/jquery.event.move.js"></script>
<script src="js/jquery.twentytwenty.js"></script> 
<script>
$(function(){
  $(".twentytwenty-container").twentytwenty();
});
</script>              
<link href="css/twentytwenty.css" rel="stylesheet" type="text/css" />

EOT;
            
            $res .= $script;
            return $res;
        }
	
	
}

class products
{
    protected $_myconn, $_ids ;
    public function __construct($myconn, $_ids, $my_rows = NULL) {
        $all_rows = NULL;
        $this->_ids = $_ids;
        $this->_myconn = $myconn;
        
    }
}

?>