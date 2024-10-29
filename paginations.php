<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
	/* Setup page vars for display. */
	if ($pageid == 0) $pageid = 1;					//if no page var is given, default to 1.
	$prev = $pageid - 1;							//previous page is page - 1
	$next = $pageid + 1;							//next page is page + 1
	//$lastpage = ceil($total_records/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/

	$pagination = "";
	if($lastpage > 1)
	{	
		//$pagination .= "<div class=\"pagination\">";
		//previous button

		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $pageid)
					$pagination.= "<li><span class=\"active\">$counter</span> </li>";
				else
					$pagination.= "<li><a href=\"$targetpage&pageid=$counter\">$counter</a></li>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($pageid < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $pageid)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<li><a href=\"$targetpage&pageid=$counter\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"$targetpage&pageid=$lpm1\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage&pageid=$lastpage\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $pageid && $pageid > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"$targetpage&pageid=1\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage&pageid=2\">2</a></li>";
				$pagination.= "...";
				for ($counter = $pageid - $adjacents; $counter <= $pageid + $adjacents; $counter++)
				{
					if ($counter == $pageid)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<li><a href=\"$targetpage&pageid=$counter\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"$targetpage&pageid=$lpm1\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage&pageid=$lastpage\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li><a href=\"$targetpage&pageid=1\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage&pageid=2\">2</a></li>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $pageid)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<li><a href=\"$targetpage&pageid=$counter\">$counter</a></li>";					
				}
			}
		}
		

		//$pagination.= "</div>\n";		
	}

?>
