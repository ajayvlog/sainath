<?php
define("ENCRYPTION_KEY", "@a#b$c*d)e%f");
class Comman {
	
function get_opening_interest($custid,$int_type)
{
	$sql = mysql_query("select * from m_customer where custid = '$custid'");
	while($row = mysql_fetch_array($sql))
	{
		$custid = $row['custid'];
		$opening_balance_gm = $row['opening_balance_gm'];
		$opening_balance_rs = $row['opening_balance_rs'];
		$opening_balance_date = $row['opening_balance_date'];
		$current_date = date('Y-m-d');
		$inst_start_date = date('Y-m-d', strtotime("+3 months", strtotime($opening_balance_date)));
		
		
		if($opening_balance_date != "0000-00-00")
		{
			$begin = new DateTime($inst_start_date);
			$end = new DateTime($current_date);
			//$end = new DateTime("2016-01-31");
			//die;
			
			$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
			$sum_of_ins = 0;
			$i = 1;
			
			foreach($daterange as $date)
			{
				$interest_date =  $date->format("Y-m-d");
				if($int_type == "gm")
				{
					$tot_paid = $this->getvalfield("bill_payment","sum(paidqty)","custid='$custid' and billid=0 and return_date between '$opening_balance_date' and '$interest_date'");
					$balance = $opening_balance_gm - $tot_paid;
					
				}
				else
				{
					$tot_paid = $this->getvalfield("bill_payment","sum(paidamt)","custid='$custid' and billid=0 and return_date between '$opening_balance_date' and '$interest_date'");
					$balance = $opening_balance_rs - $tot_paid;
				}
				
				//$per_day_ins = ($balance_qty * 1.5 * 1)/100;
				$per_day_ins = ($balance * 0.05)/100;
				$sum_of_ins += $per_day_ins;
				$i++;
			}
		}//if close
		
		//echo $i;
		//echo "<br>";
		//echo $sum_of_ins;
		//die;
	}
	return($sum_of_ins);
}

function get_cgst($tax_id)
{
	$tax_cat_id= $this->getvalfield("m_tax","tax_cat_id","tax_id='$tax_id'"); 
	$tax= $this->getvalfield("m_tax","tax","tax_id='$tax_id'");
		
	if($tax_cat_id==4)	
	{
		$gsttax=$tax/2;	
	}
	else
	{
		$gsttax=0;
	}
	
	return $gsttax;
}

function get_sgst($tax_id)
{
	$tax_cat_id= $this->getvalfield("m_tax","tax_cat_id","tax_id='$tax_id'");
	$tax= $this->getvalfield("m_tax","tax","tax_id='$tax_id'");
		
	if($tax_cat_id==4)	
	{
		$gsttax=$tax/2;	
	}
	else
	{
		$gsttax=0;
	}
	
	return $gsttax;
}

function get_igst($tax_id)
{
	$tax_cat_id= $this->getvalfield("m_tax","tax_cat_id","tax_id='$tax_id'");
	$tax= $this->getvalfield("m_tax","tax","tax_id='$tax_id'");
		
	if($tax_cat_id==3)	
	{
		$gsttax=$tax;	
	}
	else
	{
		$gsttax=0;
	}
	
	return $gsttax;
}



function getopenstock($productid,$todate)
{
	$date=date_create($todate);
	date_sub($date,date_interval_create_from_date_string("1 days"));
 	$newdate=date_format($date,"Y-m-d");
 
	
	$opening_stock=0;
	$stockdate= $this->getvalfield("m_product","stockdate","productid='$productid'");
	
	
		 $opening_stock= $this->getvalfield("m_product","opening_stock","productid='$productid'"); 

				$pur=0;
				$sql_p = mysql_query("select purchaseid from purchaseentry where purchasedate < '$newdate'");
				while($row_p = mysql_fetch_assoc($sql_p))
				{
			 	$pur += $this->getvalfield("purchasentry_detail","sum(qty)","productid='$productid' and purchaseid='$row_p[purchaseid]'");//purchase
				}
				
					 $sold = 0;																
						$sql_s = mysql_query("select saleid from saleentry where saledate < '$newdate'");
						while($row_s = mysql_fetch_assoc($sql_s))
						{
						$sold += $this->getvalfield("saleentry_detail","sum(qty)","productid='$productid' and saleid='$row_s[saleid]'");//purchase
						}
				
					$total= $opening_stock +$pur - $sold;
					
					return($total);
}


function getstock($productid,$fromdate,$rest_id)
{
	$date=date_create($fromdate);
	date_sub($date,date_interval_create_from_date_string("1 days"));
 	$newdate=date_format($date,"Y-m-d");
	$opening_stock=0;	
	$stockdate= $this->getvalfield("m_product","stockdate","productid='$productid'");
	$opening_stock= $this->getvalfield("m_product","opening_stock","productid='$productid'"); 	
	
				$pur=0;
				$sql_p = mysql_query("select purchaseid from purchaseentry where purchasedate <= '$newdate' && restorent_id='$rest_id' && type='purchase'");
				while($row_p = mysql_fetch_assoc($sql_p))
				{
    $pur += $this->getvalfield("purchasentry_detail","sum(qty)","productid='$productid' and purchaseid='$row_p[purchaseid]'");//purchase
				}
				
				$pur_ret=0;				
			 	$pur_ret = $this->getvalfield("pur_return as A left join purchaseentry as B on A.purchaseid=B.purchaseid","sum(ret_qty)","productid='$productid' and ret_date <='$newdate' && restorent_id='$rest_id'");//purchase
				
				$trans = 0;											 
				$sql_p = mysql_query("select transid from stock_transfer where transdate <='$newdate' && restorent_id='$rest_id'"); 
				while($row_p = mysql_fetch_assoc($sql_p))
				{
				$trans += $this->getvalfield("transfer_detail","sum(qty)","productid='$productid' and transid='$row_p[transid]'");//purchase
				}
				
				$rec = 0;											 
				$sql_p = mysql_query("select transid from stock_transfer where transdate <='$newdate' && restorent_id='$rest_id'"); 
				while($row_p = mysql_fetch_assoc($sql_p))
				{
				$rec += $this->getvalfield("transfer_detail as A left join stock_transfer as B on A.transid=B.transid","sum(A.qty)","A.productid='$productid' and B.transrestorent_id='$row_p[transid]'");//purchase
				}
				
				
					 $stockin=0;
					 $sql_p = mysql_query("select purchaseid from purchaseentry  where purchasedate <='$newdate' and type='stockin' && restorent_id='$rest_id'"); 
						while($row_p = mysql_fetch_assoc($sql_p))
						{
						$stockin += $this->getvalfield("purchasentry_detail","sum(qty)","productid='$productid' and purchaseid='$row_p[purchaseid]'");//purchase
						}
				
						$issue = 0;							
						$sql_p = mysql_query("select issueid from issuentry where issuedate <='$newdate' && restorent_id='$rest_id'"); 
						while($row_p = mysql_fetch_assoc($sql_p))
						{
						$issue += $this->getvalfield("issue_detail","sum(qty)","productid='$productid' and issueid='$row_p[issueid]'");//purchase
						}
					
						$issuedto = 0;							
						$sql_p = mysql_query("select issueid from issuentry where issuedate <='$newdate' && sendto='$rest_id'"); 
						while($row_p = mysql_fetch_assoc($sql_p))
						{
						$issuedto += $this->getvalfield("issue_detail","sum(qty)","productid='$productid' and issueid='$row_p[issueid]'");//purchase
						}
							
						 $issue_ret = 0;						 
					 $issue_ret += $this->getvalfield("issue_return as A left join issuentry as B on A.issueid=B.issueid","sum(A.ret_qty)","productid='$productid' && ret_date <='$newdate' && restorent_id='$rest_id'");//purchase
						
					
						 $sold = 0;																
						$sql_s = mysql_query("select saleid from saleentry where saledate <= '$newdate' && type='sale' && restorent_id='$rest_id'");
						while($row_s = mysql_fetch_assoc($sql_s))
						{
						$sold += $this->getvalfield("saleentry_detail","sum(qty)","productid='$productid' and saleid='$row_s[saleid]'");//purchase
						}
						
						$sold_ret=0;
						
					//	$sold_ret=$this->getvalfield("salereturn","sum(ret_qty)","productid='$productid' and sale_retdate <='$newdate'");
					
					 $consume = 0;																
						$sql_s = mysql_query("select saleid from saleentry where saledate <= '$newdate' and type='consume' && restorent_id='$rest_id'");
						while($row_s = mysql_fetch_assoc($sql_s))
						{
						$consume += $cmn->getvalfield("saleentry_detail","sum(qty)","productid='$productid' and saleid='$row_s[saleid]'");//purchase
						}	
				
					$total= $opening_stock +$pur - $sold - $pur_ret + $sold_ret-$trans+$rec-$issue+$issuedto+$stockin-$issue_ret-$consume;
					
					return($total);
}

function get_purchase_payment($dealerid,$type)
{
	//dealer opening balance 
	$opening_balance_gm = $this->getvalfield("m_dealer","opening_balance_gm","dealerid='$dealerid'");
	$opening_balance_rs = $this->getvalfield("m_dealer","opening_balance_rs","dealerid='$dealerid'");
	
	//previous purchase_payment paid 
	$paid_gm = $this->getvalfield("purchase_payment","sum(paidamt)","dealerid='$dealerid' and paidtype = 'silver'");
	$paid_rs = $this->getvalfield("purchase_payment","sum(paidamt)","dealerid='$dealerid' and paidtype = 'labour'");
	
	$res = mysql_query("select * from purchase_entry where dealerid = '$dealerid'");
	$grand_fine_silver = 0;
	$grand_labourcost = 0;
	while($row = mysql_fetch_array($res))
	{
		//$total_weight_silver = $this->getvalfield("purchase_entry_details","sum(weight)","purchaseid='$row[purchaseid]'");
		//$total_meltingcost = $this->getvalfield("purchase_entry_details","sum(meltingcost)","purchaseid='$row[purchaseid]'");
		$total_fine_silver = $this->getvalfield("purchase_entry_details","sum(finesilver)","purchaseid='$row[purchaseid]'");
		$total_labourcost = $this->getvalfield("purchase_entry_details","sum(labourcost)","purchaseid='$row[purchaseid]'");
		
		
		$grand_fine_silver += $total_fine_silver;
		$grand_labourcost += $total_labourcost;
	}
	
	if($type == "gm")
	return($grand_fine_silver + $opening_balance_gm - $paid_gm);
	
	if($type == "rs")
	return($grand_labourcost + $opening_balance_rs - $paid_rs);
	
}




function get_bill_interest($billid,$int_type)
{
	$billdate = $this->getvalfield("bill_entry","billdate","billid='$billid'");
	$bill_balance_gm = $this->getvalfield("bill_entry_details","sum(finesilver)","billid='$billid'");
	$bill_balance_rs = $this->getvalfield("bill_entry_details","sum(labourcost)","billid='$billid'");
	$current_date = date('Y-m-d');
	$inst_start_date = date('Y-m-d', strtotime("+3 months", strtotime($billdate)));
	
	if($billdate != "0000-00-00")
	{
		$begin = new DateTime($inst_start_date);
		$end = new DateTime($current_date);
		//$end = new DateTime("2016-01-31");
		//die;
		
		$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
		$sum_of_ins = 0;
		$i = 1;
		
		foreach($daterange as $date)
		{
			$interest_date =  $date->format("Y-m-d");
			if($int_type == "gm")
			{
				$tot_paid = $this->getvalfield("bill_payment","sum(paidqty)","billid='$billid' and return_date between '$billdate' and '$interest_date'");
				$balance = $bill_balance_gm - $tot_paid;
				
			}
			else
			{
				$tot_paid = $this->getvalfield("bill_payment","sum(paidamt)","billid='$billid' and return_date between '$billdate' and '$interest_date'");
				$balance = $bill_balance_rs - $tot_paid;
			}
			
			//$per_day_ins = ($balance_qty * 1.5 * 1)/100;
			$per_day_ins = ($balance * 0.05)/100;
			$sum_of_ins += $per_day_ins;
			$i++;
		}
	}//if close
	
	//echo $i;
	//echo "<br>";
	//echo $sum_of_ins;
	//die;
	return($sum_of_ins);
}
	
	

function getagentTotal($agent_id)
{
	$tot_amt = $this->getvalfield("rto_entry","sum(amount)","agent_id = '$agent_id' ") +  $this->getvalfield(" vehicle_insurance","sum(amt)","agent_id = '$agent_id' ");
	$tot_paid = $this->getvalfield("rto_payment","sum(payamt)","agent_id = '$agent_id' ");
	return ($tot_amt - $tot_paid);
}

function getSubTotal($id,$tblname,$tblpkey)
{
	$total = 0;
	//return "Select rate,weight from $tblname where $tblpkey = '$id'";
	$sql = mysql_query("Select rate,weight from $tblname where $tblpkey = '$id'");
	if($sql )
	{
		
		while($row = mysql_fetch_array($sql))
		{
			$subtotal = $row['rate'] * $row['weight'];
			$total += $subtotal ;
		}
	}

	return $total;
}

function get_product_wise_total_sale($productid)
{
	$total = 0;
	//return "Select rate,weight from $tblname where $tblpkey = '$id'";
	$sql = mysql_query("Select rate,qty from bill_details where productid = '$productid'");
	if($sql )
	{
		while($row = mysql_fetch_array($sql))
		{
			$subtotal = $row['rate'] * $row['qty'];
			$total += $subtotal ;
		}
	}
	return $total;
}

function getrec($tablename,$tablepkey,$cond)
{
	$num =  $this->getvalfield($tablename,"max($tablepkey)","$cond");
	//if($num == NULL)
	//$num = 0;
    ++$num; // add 1;
    $len = strlen($num);
    for($i=$len; $i< 5; ++$i) {
        $num = '0'.$num;
    }
	$num='rec'.$num;
    return $num;
}


function getrecsupp($tablename,$tablepkey,$cond)
{
	$num =  $this->getvalfield($tablename,"max($tablepkey)","$cond");
	//if($num == NULL)
	//$num = 0;
    ++$num; // add 1;
    $len = strlen($num);
    for($i=$len; $i< 5; ++$i) {
        $num = '0'.$num;
    }
	$num='rec'.$num;
    return $num;
}



function getcode($tablename,$tablepkey,$cond)
{
    $num =  $this->getvalfield($tablename,"max($tablepkey)",$cond);
	//if($num == NULL)
	//$num = 0;
    ++$num; // add 1;
    $len = strlen($num);
    for($i=$len; $i< 5; ++$i) {
        $num = '0'.$num;
    }
    return $num;
}

function getkotcode($tablename,$tablepkey,$cond)
{
    $num =  $this->getvalfield($tablename,"max($tablepkey)",$cond);
	//if($num == NULL)
	//$num = 0;
    ++$num; // add 1;
    $len = strlen($num);
    for($i=$len; $i< 5; ++$i) {
        $num = '0'.$num;
    }
    return $num;
}



function getret($tablename,$tablepkey,$cond)
{
	$num =  $this->getvalfield($tablename,"max($tablepkey)","$cond");
	//if($num == NULL)
	//$num = 0;
    ++$num; // add 1;
    $len = strlen($num);
    for($i=$len; $i< 5; ++$i) {
        $num = '0'.$num;
    }
    return 'RET'.$num;
}


function getlowestdate()
{
	$lowestpurdate=strtotime($this->getvalfield("purchaseentry","min(purchasedate)","purchasedate <> '0000-00-00'"));
	$lowestsaledate=strtotime($this->getvalfield("saleentry","min(saledate)","saledate <> '0000-00-00'"));
	$lowestopeningstockdate=strtotime($this->getvalfield("m_product","min(stockdate)","stockdate <> '0000-00-00'"));
	
	$mindate= min($lowestpurdate,$lowestsaledate,$lowestopeningstockdate);
	$mindate=date('d-m-Y',$mindate);
	
	return $mindate;

}



function find_dana_bill($total_type, $saleid)
{
	$dana_rate = $this->getvalfield("shop_dana_sale","dana_rate","saleid='$saleid'");
	$dana_qty = $this->getvalfield("shop_dana_sale","dana_qty","saleid='$saleid'");
	$discount = $this->getvalfield("shop_dana_sale","discount","saleid='$saleid'");
	
	$grand_total = $dana_rate * $dana_qty;
	$net_total = $grand_total - $discount;
	
	if($total_type == 'grand')
	return $grand_total;
	else
	return $net_total;
}
function bal_seller_amt($sellerid)
{
	$net_total =0;
	//get billid
	$sql = mysql_query("select * from process_purchase where sellerid = '$sellerid'");
	if($sql)
	{
		while($row = mysql_fetch_assoc($sql))
		{
			$purchaseid = $row['purchaseid'];
			$discount = $row['discount'];
			$pur_rate  = $row['pur_rate'];
			$discount_rupees   = $row['discount_rupees'];
			$discount_percent  = $row['discount_percent'];
			$tax =  $row['tax'];
			
			if($discount_rupees != 0)
			$pur_rate = $pur_rate - $discount_rupees;
			
			if($discount_percent != 0)
			$pur_rate = $pur_rate - ($pur_rate * $discount_percent/100);
			
			
			if($tax != 0)
			$pur_rate = $pur_rate + ($pur_rate * $tax);
			//get bill detail
			
			$net_total += $pur_rate;
			
		}
	}
	$total_paid = $this->getvalfield("seller_payment","sum(payamt)"," sellerid = '$sellerid'");
	//return $net_total;
	return round($net_total - $total_paid);
}

function bal_buyer_amt($buyerid)
{
	$net_total =0;
	//get billid
	$sql = mysql_query("select * from process_sells where buyerid = '$buyerid'");
	if($sql)
	{
		while($row = mysql_fetch_assoc($sql))
		{
			$sellsid = $row['sellsid'];
			$discount = $row['discount'];
			$sell_rate  = $row['sell_rate'];
			$discount_rupees   = $row['discount_rupees'];
			$discount_percent  = $row['discount_percent'];
			$tax =  $row['tax'];
			
			if($discount_rupees != 0)
			$sell_rate = $sell_rate - $discount_rupees;
			
			if($discount_percent != 0)
			$sell_rate = $sell_rate - ($sell_rate * $discount_percent/100);
			
			
			if($tax != 0)
			$sell_rate = $sell_rate + ($sell_rate * $tax);
			//get bill detail
			
			$net_total += $sell_rate;
			
		}
	}
	$total_paid = $this->getvalfield("buyer_payment","sum(payamt)"," buyerid = '$buyerid'");
	//return $net_total;
	return round($net_total - $total_paid);
	
}


function bal_order_amt($partyid)
{
	$net_total =0;
	$sql = mysql_query("Select orderid  from order_entry where partyid = '$partyid'");
	if($sql)
	{
		while($row = mysql_fetch_assoc($sql))
		{
			$orderid = $row['orderid'];
			$net_total += $this->getSubTotal($orderid,'order_items','orderid');
			
		}
	}
	$prevbalance = $this->getvalfield("m_party","sum(prevbalance)","partyid='$partyid'");
	$discountpercent = $this->getvalfield("m_party","sum(discount)","partyid='$partyid'");
	$discount = $this->getvalfield("order_entry","sum(discount)","partyid='$partyid'");
	$paidamt = $this->getvalfield("payment_party","sum(payamt)","partyid='$partyid'");
	$net_total = $net_total - $paidamt - $discount + $prevbalance;
	$net_total = $net_total + ($discountpercent * $net_total / 100);
	return $net_total ;
}
function bal_purchase_amt($supplierid)
{
	$net_total =0;
	$sql = mysql_query("Select purchaseid  from purchase_entry where supplierid = '$supplierid'");
	if($sql)
	{
		while($row = mysql_fetch_assoc($sql))
		{
			$purchaseid = $row['purchaseid'];
			$net_total += $this->getSubTotal($purchaseid,'purchased_items','purchaseid');
			
		}
	}
	//return "Select purchaseid  from purchase_entry where supplierid = '$supplierid'";
	$prevbalance = $this->getvalfield("m_supplier","prevbalance","supplierid='$supplierid'");
	$discount = $this->getvalfield("purchase_entry","sum(discount)","supplierid='$supplierid'");
	$other_charges = $this->getvalfield("purchase_entry","sum(other_charges)","supplierid='$supplierid'");
	$paidamt = $this->getvalfield("payment_supplier","sum(payamt)","supplierid='$supplierid'");
	 $net_total = $net_total - $paidamt - $discount + $prevbalance + $other_charges;
	return $net_total ;
}
function getdispnum()
{
	$num =  $this->getvalfield("process_dispatch_entry","max(disp_num)","1=1");
	//if($num == NULL)
	//$num = 0;
    ++$num; // add 1;
    $len = strlen($num);
    for($i=$len; $i< 5; ++$i) {
        $num = '0'.$num;
    }
    return $num;
}


function get_balance_silver($billid)
{
	$total_finesilver = $this->getvalfield("bill_entry_details","sum(finesilver)","billid='$billid'");
	
	
	//prev return qty and cost
	$total_return_silver = $this->getvalfield("bill_payment","sum(paidqty)","billid='$billid'");
	
	//balance fine silver
	$balance_silver = ($total_finesilver - $total_return_silver);
	return($balance_silver);
}


function get_balance_labour_cost($billid)
{
	$total_labourcost = $this->getvalfield("bill_entry_details","sum(labourcost)","billid='$billid'");
	
	
	//prev return qty and cost
	$total_return_labour = $this->getvalfield("bill_payment","sum(paidamt)","billid='$billid'");
	
	//balance fine silver
	$balance_labourcost = ($total_labourcost - $total_return_labour);
	return($balance_labourcost);
}



// get value if you know the primary key value //
function getvalMultiple($table,$field,$where)
{
	$sql = "select $field from $table where $where";
	//echo $sql;
	$getvalue = mysql_query($sql);
	$getval="";
	while($row = mysql_fetch_row($getvalue))
	{
		if($getval == "")
		$getval = $row[0];
		else
		$getval .= ",". $row[0];
	}
	return $getval;
}


// get value from any condition //
function getvalfield($table,$field,$where)
{
	$sql = "select $field from $table where $where";
	//echo $sql;
	$getvalue = mysql_query($sql);
	$getval = mysql_fetch_row($getvalue);

	return $getval[0];
}

// get date format (01 march 2012) from 2012-03-01 //
function dateformat($date)
{
	if($date != "0000-00-00")
	{
	$ndate = explode("-",$date);
	$year = $ndate[0];
	$day = $ndate[2];
	$month = intval($ndate[1])-1;
	$montharr = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	$month1 = $montharr[$month];
	
	
	return $day . " " . $month1 . " " . $year;
	}
	else
	return "";
}

// get date format (01-03-2012) from (2012-03-01) //
function dateformatindia($date)
{
	$ndate = explode("-",$date);
	$year = $ndate[0];
	$day = $ndate[2];
	$month = $ndate[1];
	
	if($date == "0000-00-00" || $date =="")
	return "";
	else
	return $day . "-" . $month . "-" . $year;
	
}

// get date format (01-03-2012) from (2012-03-01 23:12:04) //
function dateFullToIndia($date,$full)
{
	$fdate = explode(" ",$date);
	
	$ndate = explode("-",$fdate[0]);
	$year = $ndate[0];
	$day = $ndate[2];
	$month = $ndate[1];
	
	$time = explode(":",$fdate[1]);
	$hour = $time[0];
	$minute = $time[1];
	$second = $time[2];
	if($hour > 12)
	{
		$h = $hour-12;
		if($h < 10)
		$h = "0" . $h;
		$fulltime = $h . ":" . $minute . ":" . $second . " PM";
	}
	else
	$fulltime = $hour . ":" . $minute . ":" . $second . " AM";
	
	
	if($full == "full")
	return $day . "-" . $month . "-" . $year . " " . $fdate[1];
	else if($full == "fullindia")
	return $day . "-" . $month . "-" . $year . " " . $fulltime;
	else if($full == "time")
	return $fulltime;
	else
	return $day . "-" . $month . "-" . $year;
}

// get date format (2012-03-01) from (01-03-2012) //
function dateformatusa($date)
{
	$ndate = explode("-",$date);
	$year = $ndate[2];
	$day = $ndate[0];
	$month = $ndate[1];
	
	return $year . "-" . $month . "-" . $day;
}

function getTotalBillAmt($id)
{
	$total = 0;
	//echo "Select * from saleentry_detail where saleid = '$id'";
	$sql = mysql_query("Select * from saleentry_detail where saleid = '$id'");
	if($sql )
	{
		
		while($row = mysql_fetch_array($sql))
		{
			$retqty=$this->getvalfield("salereturn","sum(ret_qty)","saleid = '$id' and productid='$row[productid]'");			
			$qty = $row['qty']-$retqty;
			$rate = $row['rate'];
			$gst = $row['cgst'] + $row['sgst'];			
			$igst = $row['igst'];
			$vat = $row['vat'];
			$disc_per = $row['disc_per'];
			$subtotal = $rate * $qty;
			if($disc_per!=0)
			{
			$discamt = $subtotal * $disc_per/100;	
			$subtotal = $subtotal - $discamt;	
			}
			
			$total += $subtotal;
		}
	}
	
	
	return $total;
}


function getTotalGst($id)
{
	$total=0;
	
	$sql = mysql_query("Select * from saleentry_detail where saleid = '$id'");
	if($sql )
	{
		
		while($row = mysql_fetch_array($sql))
		{
			$taxamt=0;	
			$retqty=$this->getvalfield("salereturn","sum(ret_qty)","saleid = '$id' and productid='$row[productid]'");
			$qty = $row['qty']-$retqty;
			$rate = $row['rate'];
			$disc_per = $row['disc_per'];
			$tax= $row['cgst'] + $row['sgst']+ $row['igst'];
			$total=$qty * $rate;
			
			if($disc_per !='0')
			{
			$discamt= $total * $disc_per/100;
			$total= $total - $discamt;
			}
			$taxamt = ($total * $tax)/100;
			$stotal += $taxamt;
		}
	}
	
	return $stotal;
}



function getTotalcGst($id)
{
	$total=0;
	
	$sql = mysql_query("Select * from saleentry_detail where saleid = '$id'");
	if($sql )
	{
		
		while($row = mysql_fetch_array($sql))
		{
			$taxamt=0;	
			$retqty=$this->getvalfield("salereturn","sum(ret_qty)","saleid = '$id' and productid='$row[productid]'");
			$qty = $row['qty']-$retqty;
			$rate = $row['rate'];
			$disc = $row['disc'];
			$tax= $row['cgst'] + $row['sgst'];
			$total=$qty * $rate;
			
			if($disc !='0')
			{
			$total= $total - $disc;
			}
			$taxamt = ($total * $tax)/100;
			$stotal += $taxamt;
		}
	}
	
	return $stotal;
}




function getTotalcgst_pur($id)
{
	$total=0;
	$sql = mysql_query("Select * from purchasentry_detail where purchaseid = '$id'");
	if($sql )
	{
		
		while($row = mysql_fetch_array($sql))
		{
			$taxamt=0;
			$ret_qty=$this->getvalfield("pur_return","sum(ret_qty)","purchaseid='$id' && productid='$row[productid]'");
			$qty = $row['qty']-$ret_qty;
			$rate = $row['rate'];
			$disc = $row['disc'];
			
			if($row['cgst'] !='0' && $row['sgst'] !='0')
				{	
				$tax= $row['cgst'] + $row['sgst'];				
				$total=$qty * $rate;				
				if($disc !='0')
				{
					$total= $total - ($total * $disc)/100;
				}
			
				$taxamt = ($total * $tax)/100;
				
			 $stotal += $taxamt;
			 	}
		}
	
	}
	
	
	return $stotal;
}


function getTotalGst_pur($id)
{
	$total=0;
	$sql = mysql_query("Select * from purchasentry_detail where purchaseid = '$id'");
	if($sql )
	{
		
		while($row = mysql_fetch_array($sql))
		{
			$taxamt=0;	
			$tax=0;
			$ret_qty = $this->getvalfield("pur_return","sum(ret_qty)","purchaseid='$id' && productid='$row[productid]'");
			$qty = $row['qty']-$ret_qty;
			$rate = $row['rate'];
			$disc = $row['disc'];
			
			if($row['cgst'] !='0' && $row['sgst'] !='0')
				{	
				$tax= $row['cgst'] + $row['sgst'];				
				}
				else if($row['igst'] !='0')
				{
					$tax= $row['igst'];					
				}				
				$total=$qty * $rate;				
				if($disc !='0')
				{
					$total= $total - ($total * $disc)/100;
				}			
				$taxamt = ($total * $tax)/100;				
			 $stotal += $taxamt;
		}
	
	}
	
	
	return $stotal;
}

function getTotalIgst_pur($id)
{
	$total=0;
	$sql = mysql_query("Select * from purchasentry_detail where purchaseid = '$id'");
	if($sql )
	{
		
		while($row = mysql_fetch_array($sql))
		{
			$taxamt=0;	
			$ret_qty=$this->getvalfield("pur_return","sum(ret_qty)","purchaseid='$id' && productid='$row[productid]'");
			$qty = $row['qty']-$ret_qty;
			$rate = $row['rate'];
			$disc = $row['disc'];
			
			if($row['igst'] !='0')
				{
					 $tax= $row['igst'];
					  $total=$qty * $rate;
			
				if($disc !='0')
				{
					$total= $total - $disc;
				}
				 $taxamt = ($total * $tax)/100;
			  $igsttotal += $taxamt;
				}
		}
	}
	
	return $igsttotal;
}

function getTotalIgst_Sale($id)
{
	$total=0;
	$sql = mysql_query("Select * from saleentry_detail where saleid = '$id'");
	if($sql )
	{
		
		while($row = mysql_fetch_array($sql))
		{
			$taxamt=0;			
			$retqty=$this->getvalfield("salereturn","sum(ret_qty)","saleid = '$id' and productid='$row[productid]'");
			$qty = $row['qty']-$retqty;
			$rate = $row['rate'];
			$disc = $row['disc'];
			
			if($row['igst'] !='0')
				{
					 $tax= $row['igst'];
					  $total=$qty * $rate;
			
				if($disc !='0')
				{
					$total= $total - $disc;
				}
				 $taxamt = ($total * $tax)/100;
			  $igsttotal += $taxamt;
				}
		}
	}
	
	return $igsttotal;
}

function getgsttaxes($saleid,$tax_id)
{
	
	$stotal=0;
	
	$sql = mysql_query("Select * from saleentry_detail where saleid = '$saleid' && tax_id='$tax_id'");
	if($sql )
	{
		
		while($row = mysql_fetch_array($sql))
		{
			$taxamt=0;	
			
			$retqty=$this->getvalfield("salereturn","sum(ret_qty)","saleid = '$saleid' and productid='$row[productid]'");
			$qty =$row['qty']-$retqty;	
			$rate = $row['rate'];
			$disc = $row['disc'];
			
			$disc_rs=$this->getvalfield("saleentry","disc","saleid = '$saleid'");
			
			if($row['cgst'] !='0' && $row['sgst'] !='0')
				{	
				$tax= $row['cgst'] + $row['sgst'];
				
				}
				else if($row['igst'] !='0')
				{
					$tax= $row['igst'];
					
				}
				else
				{
					$tax=0;
				}
				
				 $total=$qty * $rate;
				
				if($disc !='0')
				{
					$total= $total - $disc;
				}
			
				$taxamt = ($total * $tax)/100;
			 
			 $stotal += $taxamt;
		}
	}
	
	
	return $stotal;
	
}




function getgsttaxes_pur($purchaseid,$tax_id)
{
	
	$stotal=0;
	
	$sql = mysql_query("Select * from purchasentry_detail where purchaseid = '$purchaseid' && tax_id='$tax_id'");
	if($sql )
	{
		
		while($row = mysql_fetch_array($sql))
		{
			$taxamt=0;	
			$tax=0;
			$ret_qty=$this->getvalfield("pur_return","sum(ret_qty)","purchaseid='$id' && productid='$row[productid]'");
			$qty = $row['qty']-$ret_qty;
			$rate = $row['rate'];
			$disc = $row['disc'];
			
			$disc_rs=$this->getvalfield("purchaseentry","disc","purchaseid = '$purchaseid'");
			
			if($row['cgst'] !='0' && $row['sgst'] !='0')
				{	
				$tax= $row['cgst'] + $row['sgst'];
				
				}
				else if($row['igst'] !='0')
				{
					$tax= $row['igst'];
					
				}
				
				 $total=$qty * $rate;
				
				if($disc !='0')
				{
					$total= $total - $disc;
				}
			
				$taxamt = ($total * $tax)/100;
			 
			 $stotal += $taxamt;
		}
	}
	
	
	return $stotal;
	
}



function getbillwisegst($field,$tblkey)
{
		
		$tax=0;	
		$sql=mysql_query("select * from purchasentry_detail where purchaseid='$tblkey'");
		while($row=mysql_fetch_assoc($sql))
		{
			$taxamount=0;
			$total=0;
			$total= $row['qty'] * $row['rate'];
			$total -= $row['disc'];
		 	$taxamount=($total * $row["$field"])/100;
			$tax +=$taxamount;
		}		
		return $tax;
}

function getbillwisegstsale($field,$tblkey)
{
	
	
	$tax=0;	
		
		$sql=mysql_query("select * from saleentry_detail where saleid='$tblkey'");
		while($row=mysql_fetch_assoc($sql))
		{
			$taxamount=0;
			$total=0;
			$total= $row['qty'] * $row['rate'];
			$total -= $row['disc'];
		 	$taxamount=($total * $row["$field"])/100;
			$tax +=$taxamount;
		}		
		return $tax;
		
		
}


function getTotalPerchaseBillAmt($id)
{
	$total = 0;
	$sql = mysql_query("Select * from purchasentry_detail where purchaseid = '$id'");
	if($sql )
	{
		
		while($row = mysql_fetch_array($sql))
		{
			$ret_qty = $this->getvalfield("pur_return","sum(ret_qty)","purchaseid='$id' && productid='$row[productid]'");
			 $qty = $row['qty']-$ret_qty;
			 $rate = $row['rate'];
			 $gst = $row['cgst'] + $row['sgst'];			
			$igst = $row['igst'];
			$vat = $row['vat'];
			  $disc = $row['disc'];
			  $subtotal = $rate * $qty ;
			  $subtotal = $subtotal - ($subtotal * $disc)/100;
			 
			 $total += $subtotal;
		}
	}
	
	
	return round($total);
}


function getTotalsell($curr_date)
{
$grand_total=0;
$sql=mysql_query("Select * from bills where billdate ='$curr_date'");
while($row=mysql_fetch_assoc($sql))
{
		$total=0;
		$taxamount=0;
		$tax1=0;
		$tax2=0;
		$tax3=0;									
		$total=$this->getTotalBillAmt($row['billid']);	
		$tax1=$row['tax1'];
		$tax2=$row['tax2'];
		$tax3=$row['tax3'];
		
		if($tax1 !=0)
		{
		$taxamount= ($total * $tax1)/100;
		$total +=$taxamount;
		}
		
		if($tax2 !=0)
		{
		$taxamount= ($total * $tax2)/100;
		$total +=$taxamount;
		}
		
		if($tax1 !=0)
		{
		$taxamount= ($total * $tax3)/100;
		$total +=$taxamount;
		}
		
		$grand_total = $grand_total+$total;
		$net_total = $grand_total-1;
									
}

return round($net_total);
}


function get_client_ip() 
{
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';

      return $ipaddress; 
}

// get image in particular size. if you writ only width then it returns in ratio of height. and you can set width and height //
function convert_image($fname,$path,$wid,$hei)
{
	$wid = intval($wid); 
	$hei = intval($hei); 
	//$fname = $sname;
	$sname = "$path$fname";
	//echo $sname;
	//header('Content-type: image/jpeg,image/gif,image/png');
	//image size
	list($width, $height) = getimagesize($sname);
	
	if($hei == "")
	{
		if($width < $wid)
		{
			$wid = $width;
			$hei = $height;
		}
		else
		{
			$percent = $wid/$width;  
			$wid = $wid;
			$hei = round ($height * $percent);
		}
	}
	
	//$wid=469;
	//$hei=290;
	$thumb = imagecreatetruecolor($wid,$hei);
	//image type
	$type=exif_imagetype($sname);
	//check image type
	switch($type)
	{
	case 2:
	$source = imagecreatefromjpeg($sname);
	break;
	case 3:
	$source = imagecreatefrompng($sname);
	break;
	case 1:
	$source = imagecreatefromgif($sname);
	break;
	}
	// Resize
	imagecopyresized($thumb, $source, 0, 0, 0, 0,$wid,$hei, $width, $height);
	//echo "converted";
	//else
	//echo "not converted";
	// source filename
	$file = basename($sname);
	//destiantion file path
	//$path="uploaded/flashgallery/";
	$dname=$path.$fname;
	//display on browser
	//imagejpeg($thumb);
	//store into file path
	imagejpeg($thumb,$dname);
}

// for get mixed no. like password etc. //
function getmixedno($totalchar)
{
	$abc= array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
	$mixedno = "";
	for($i=0; $i<=$totalchar; $i++)
	{
		$mixedno .= $abc[rand(0,35)];
	}
	return $mixedno;
}


// get total no. of rows //
function getTotalNum($table,$where)
{
	$sql = "select * from $table where $where";
	//echo $sql;
	$getvalue = mysql_query($sql);
	$getval = mysql_num_rows($getvalue);

	return $getval;
}


// trial for pagination //
function startPagination($page_query, $data_in_a_page)
{
	$getrow = mysql_query($page_query);
	$count = mysql_num_rows($getrow);
	
	$page_for_site = "";
	
	$page=1;
	if(isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
	
	if($count > $data_in_a_page)
	{
		$cnt = ceil($count / $data_in_a_page);
		
		$page_for_site .= "<div style='float:left; padding-top:3px; color:#c0f;'>Page $page of $cnt &nbsp;&nbsp;&nbsp;</div>";
		
		for($i = 1; $i<= $cnt; $i++)
		{
			$class = " class='pagination' ";
			if($i == $page)
			$class = " class='pagination-current' ";
			
			$pu = $this->curPageURL();
			$cm = explode("/",$pu);
			$n = count($cm);
			$curl = $cm[$n-1];
			
			$qm_avail = strpos($curl,"?");
			if($qm_avail == "")
			$page_for_site .= "<a href='?page=$i' $class>$i</a>";
			else
			{
				$page_avail = strpos($curl,"page=");
				if($page_avail != "")
				{
					$pagevalue = $_REQUEST['page'];
					$past_page = "page=$pagevalue";
					$finalurl = str_replace($past_page,"page=$i",$curl);
					$page_for_site .= "<a href='$finalurl' $class>$i</a>";
				}
				else
				$page_for_site .= "<a href='$curl&page=$i' $class>$i</a>";
			}
		}
		$page_for_site .= "<div style='clear:both'></div>";
	}
	echo $page_for_site;
}


// return present page url //
function curPageURL()
{
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") 
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	else
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	return $pageURL;
}

// change number into word format //
function numtowords($num)
{
	$ones = array(
	1 => "one",
	2 => "two",
	3 => "three",
	4 => "four",
	5 => "five",
	6 => "six",
	7 => "seven",
	8 => "eight",
	9 => "nine",
	10 => "ten",
	11 => "eleven",
	12 => "twelve",
	13 => "thirteen",
	14 => "fourteen",
	15 => "fifteen",
	16 => "sixteen",
	17 => "seventeen",
	18 => "eighteen",
	19 => "nineteen"
	);
	$tens = array(
	2 => "twenty",
	3 => "thirty",
	4 => "forty",
	5 => "fifty",
	6 => "sixty",
	7 => "seventy",
	8 => "eighty",
	9 => "ninety"
	);
	$hundreds = array(
	"hundred",
	"thousand",
	"million",
	"billion",
	"trillion",
	"quadrillion"
	); //limit t quadrillion
	$num = number_format($num,2,".",",");
	$num_arr = explode(".",$num);
	$wholenum = $num_arr[0];
	$decnum = $num_arr[1];
	$whole_arr = array_reverse(explode(",",$wholenum));
	krsort($whole_arr);
	$rettxt = "";
	foreach($whole_arr as $key => $i)
	{
		if($i < 20)
		{
			$rettxt .= $ones[$i];
		}
		elseif($i < 100)
		{
			$rettxt .= $tens[substr($i,0,1)];
			$rettxt .= " ".$ones[substr($i,1,1)];
		}
		else
		{
			$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];
			$rettxt .= " ".$tens[substr($i,1,1)];
			$rettxt .= " ".$ones[substr($i,2,1)];
		}
		
		if($key > 0)
		{
			$rettxt .= " ".$hundreds[$key]." ";
		}
	}
	if($decnum > 0)
	{
		$rettxt .= " and ";
		if($decnum < 20)
		{
			$rettxt .= $ones[$decnum];
		}
		elseif($decnum < 100)
		{
			$rettxt .= $tens[substr($decnum,0,1)];
			$rettxt .= " ".$ones[substr($decnum,1,1)];
		}
	}
	return $rettxt;
} 

// mail content //
function getEmailContent($content,$loginbtn,$loginurl)
{
	$urlOfOurSite1 = "http://www.fullonwms.com/fullonwms/";
	$mc = "<html><body><table width='400' align='center' cellpadding='0' cellspacing='0' style='border-top:5px solid #0079d6;border-left:5px solid #0079d6; border-right:5px solid #50b2fd; border-bottom:5px solid #50b2fd'><tr><td><table width='500' cellpadding='5' cellspacing='5'><tr><td align='center'><img src='".$urlOfOurSite1."images/maillogo2.jpg' width='500' height='130'></td></tr><tr><td style='text-align:justify; color:#024c84; font-size:16px'><span style='color:#024c84'><strong>Dear member,</strong></span><br><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
	$mc .= $content;
	
	$logincontent = "<br /><strong>Regards,<br>FullOnWMS team</strong></td></tr></table></td></tr></table></body></html>";
	if($loginbtn=="Y")
	{
		$mc .= "<center><a href='".$urlOfOurSite1.$loginurl."' target='_blank' style='text-decoration:none'><span style='background-color:#0079d6; width:230px; height:30px; color:#FFF; font-weight:bold; padding:15px; padding-bottom:10px; padding-top:10px; font-size:22px'>Login</span></a></center>";
	}
	
	$mc .= "<br /><br /><br /><strong>Regards,<br>FullOnWMS team</strong></td></tr></table></td></tr></table></body></html>";
	return $mc;
}


function sendsmsold($request)
{
	//First prepare the info that relates to the connection
	$host = "sms.reliableindya.info";
	$script = "/web2sms.php";
	$request_length = strlen($request);
	$method = "POST"; // must be POST if sending multiple messages
	if ($method == "GET") 
	{
	  $script .= "?$request";
	}
	 
	//Now comes the header which we are going to post. 
	$header = "$method $script HTTP/1.1\r\n";
	$header .= "Host: $host\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: $request_length\r\n";
	$header .= "Connection: close\r\n\r\n";
	$header .= "$request\r\n";
	//Now we open up the connection
	$socket = @fsockopen($host, 80, $errno, $errstr); 
	if ($socket) //if its open, then...
	{ 
	  fputs($socket, $header); // send the details over
	  while(!feof($socket))
	  {
		$output[] = fgets($socket); //get the results 
	  }
	  fclose($socket); 
	} 
}

function sendsms($smsuname,$msg_token,$smssender,$msg,$mobile)
{
	//echo "Called";
	//http://loginsms.trinitysolutions.pw/api/send_transactional_sms.php?username=u2377&msg_token=dgy4ws&sender_id=PALITP&message=hello%20nipesh&mobile=9770131555
	$request = ""; //initialize the request variable
	$param["username"] = $smsuname; //this is the username of our TM4B account
	$param["msg_token"] = $msg_token; //this is the password of our TM4B account
	$param["sender_id"] =$smssender;//this is our sender 
	$param["message"] = $msg; //this is the message that we want to send
	$param["mobile"] = $mobile; //these are the recipients of the message
			
	foreach($param as $key=>$val) //traverse through each member of the param array
	{ 
		$request.= $key."=".urlencode($val); //we have to urlencode the values
		$request.= "&"; //append the ampersand (&) sign after each paramter/value pair
	}
	$request = substr($request, 0, strlen($request)-1); //remove the final ampersand sign from the request
	
	//die;
	//First prepare the info that relates to the connection
	$host = "loginsms.trinitysolutions.pw";
	$script = "/api/send_transactional_sms.php";
	$request_length = strlen($request);
	$method = "POST"; // must be POST if sending multiple messages
	if ($method == "GET") 
	{
	  $script .= "?$request";
	}
	
	//echo $host; die;
	//Now comes the header which we are going to post. 
	$header = "$method $script HTTP/1.1\r\n";
	$header .= "Host: $host\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: $request_length\r\n";
	$header .= "Connection: close\r\n\r\n";
	$header .= "$request\r\n";
	
	//echo $header; die;
	//Now we open up the connection
	$socket = @fsockopen($host, 80, $errno, $errstr); 
	if ($socket) //if its open, then...
	{ 
	  fputs($socket, $header); // send the details over
	  while(!feof($socket))
	  {
		$output[] = fgets($socket); //get the results 
	  }
	  fclose($socket); 
	} 
}
//Insert into log history in CA admin //
function insertLoginLogout($userid ,$usertype,$process,$sessionid,$ipaddress)
{
	$date = date("Y-m-d H:i:s");
    $sql = "insert into  loginlogoutreport set userid = '$userid' ,usertype = '$usertype' ,process = '$process' ,sessionid = '$sessionid',loginlogouttime = '$date'  ,ipaddress = '$ipaddress', createdate = '$date'";
	mysql_query($sql);
	//echo $sql;die;
}

function InsertLog($connection,$pagename, $module, $submodule, $tablename, $tablekey, $keyvalue, $action)
{
	$sessionid = $_SESSION['sessionid'];
	$userid = $_SESSION['userid'];
	$usertype = $_SESSION['usertype'];
	$activitydatetime  = date('Y-m-d H:m:s');
	
	$sqlquery = "insert into activitylogreport(userid, usertype, module, submodule, pagename, primarykeyid ,tablename, activitydatetime, action) values('$userid', '$usertype', '$module', '$submodule',  '$pagename', '$keyvalue','$tablename', '$activitydatetime', '$action')";
	//echo $sqlquery;die;
	mysqli_query($con,$sqlquery);
}


function InsertLogin($memberid, $emuid, $associationid, $asuid, $membertype, $username)
{
	$password = $this->getmixedno(8);
	$sqlquery = "insert into login(memberid, emuid, associationid, asuid, membertype, username, password, enable) values('$memberid', '$emuid', '$associationid', '$asuid', '$membertype', '$username', '$password', 1)";
	mysql_query($sqlquery);
	return $password;
}

function genNDigitCode($joinchar, $id, $num)
{
	$digit = strlen($id);
	$zeronum = "";
	for($i=$digit; $i<$num;  $i++)
	$zeronum .= "0";
	return $joinchar . $zeronum . $id;
}


// get Load Order no. code //
function getordercode($associationid)
{
	$sql = "select load_entry.orderno from load_entry left join m_corporate on load_entry.corporateid = m_corporate.corporateid where m_corporate.associationid='$associationid' order by load_entry.loadid desc";
	//echo $sql,"<br>";
	$getvalue = mysql_query($sql);
	$getval = mysql_fetch_row($getvalue);
		
	$asdigit = $this->genNDigitCode("",$associationid,2);
	//echo "--".$getval[0]."--","<br>";
	if($getval[0] != "")
	$lastOrderCode = substr($getval[0], -5);
	else
	$lastOrderCode = 0;
	
	//echo $lastOrderCode,"<br>";
	$orderCode = intval($lastOrderCode) + 1;
	
	//echo $orderCode,"<br>";
	
	$orderDigit = $this->genNDigitCode("",$orderCode,5);
		
	return $asdigit . $orderDigit;
}


// get Token no. //
function getTokencode($associationid)
{
	$sql = "select tokenno from issue_token where associationid = '$associationid' order by tokenno desc";
	//echo $sql,"<br>";
	$getvalue = mysql_query($sql);
	$getval = mysql_fetch_row($getvalue);
		
	$asdigit = $this->genNDigitCode("",$associationid,2);
	//echo "--".$getval[0]."--","<br>";
	if($getval[0] != "")
	$lastOrderCode = substr($getval[0], -5);
	else
	$lastOrderCode = 0;
	
	//echo $lastOrderCode,"<br>";
	$orderCode = intval($lastOrderCode) + 1;
	
	//echo $orderCode,"<br>";
	
	$orderDigit = $this->genNDigitCode("",$orderCode,5);
		
	return $asdigit . $orderDigit;
}




function get_billno($tblname,$tblpkey)
{
	$maxid = $this ->getvalfield($tblname,"max($tblpkey)","1=1");	
	
	
	$id = $maxid + 1;
	$strlen = strlen($id);
	if($strlen == 1)
	$id = '00000'.$id;
	else if($strlen == 2)
	$id = '0000'.$id;
	else if($strlen == 3)
	$id = '000'.$id;
	else if($strlen == 4)
	$id = '00'.$id;
	else if($strlen == 5)
	$id = '0'.$id;
	else if($strlen == 6)
	$id = $id;
	return $id;
	
}
// To encrypt data based on key //
function encrypt($string, $key = ENCRYPTION_KEY)
{
	$result = '';
	for($i=0; $i<strlen($string); $i++)
	{
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)+ord($keychar));
		$result.=$char;
	}
	return base64_encode($result);
}

// To decrypt data based on key //
function decrypt($string, $key = ENCRYPTION_KEY)
{
	$result = '';
	$string = base64_decode($string);
	
	for($i=0; $i<strlen($string); $i++)
	{
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	return $result;
}
function getTotal($id,$tblname,$tblpkey)
{
	$total = 0;
	//echo "Select rate,qty,vat from $tblname where $tblpkey = '$id'";
	$sql = mysql_query("Select rate,qty,vat from $tblname where $tblpkey = '$id'");
	if($sql )
	{
		
		while($row = mysql_fetch_array($sql))
		{
			$subtotal = $row['rate'] * $row['qty'];
			$total += $subtotal + ($subtotal * $row['vat'] /100);
		}
	}

	return $total;
}

function checkmenu($mudule_setting,$loginid)
{

  $sql=mysql_query("SELECT B.* FROM privilage_setting AS A LEFT JOIN m_userprivilege AS B ON A.page_id = B.page_id where B.menuname='$mudule_setting' and A.userid='$loginid'");	
  $numrows=mysql_num_rows($sql);

  return $numrows;	
}



function check_menuname($location,$loginid)
{
//echo "select * from privilage_setting as A left join m_userprivilege as B on A.page_id = B.page_id  where A.userid='$loginid' && B.pagelink='$location'";
	$sql=mysql_query("select * from privilage_setting as A left join m_userprivilege as B on A.page_id = B.page_id  where A.userid='$loginid' && B.pagelink='$location'");
	$numrows=mysql_num_rows($sql);		
			
	return $numrows;	
}

function check_editBtn($location,$loginid)
{
	
	$sql=mysql_query("select * from privilage_setting as A left join m_userprivilege as B on A.page_id = B.page_id  where A.userid='$loginid' && B.pagelink='$location'");
	$rowedit=mysql_fetch_array($sql);				
	return $rowedit['pagedit'];	
}

function check_delBtn($location,$loginid)
{
	
	$sql=mysql_query("select * from privilage_setting as A left join m_userprivilege as B on A.page_id = B.page_id  where A.userid='$loginid' && B.pagelink='$location'");
	$rowedit=mysql_fetch_array($sql);				
	return $rowedit['pagedel'];	
}

function check_pageview($location,$loginid)
{
	
	$sql=mysql_query("select * from privilage_setting as A left join m_userprivilege as B on A.page_id = B.page_id  where A.userid='$loginid' && B.pagelink='$location'");
	$rowedit=mysql_fetch_array($sql);				
	return $rowedit['pageview'];	
}


function get_stock($productid,$rest_id,$batchno)
{
	$curr_date = date('Y-m-d');
	 $purchase_product = $this->getvalfield("purchasentry_detail as A left join purchaseentry as B on A.purchaseid=B.purchaseid", "sum(A.qty)","productid='$productid' and B.restorent_id='$rest_id' && batchno='$batchno' && (expirydate='0000-00-00' || expirydate >= '$curr_date')"); //purchase
	$issueqty = $this->getvalfield("issue_detail as A left join issuentry as B on A.issueid=B.issueid", "sum(A.qty)","productid='$productid' and B.restorent_id='$rest_id' && batchno='$batchno' && (expirydate='0000-00-00' || expirydate >= '$curr_date')");	 //isuue
	$issued_to_you_qty = $this->getvalfield("issue_detail as A left join issuentry as B on A.issueid=B.issueid", "sum(A.qty)","productid='$productid' and B.sendto='$rest_id' && batchno='$batchno' && (expirydate='0000-00-00' || expirydate >= '$curr_date')"); //receive	
	$purchase_return = $this->getvalfield("pur_return as A left join purchaseentry as B on A.purchaseid=B.purchaseid", "sum(ret_qty)","productid='$productid' && batchno='$batchno' && B.restorent_id='$rest_id' && (expirydate='0000-00-00' || expirydate >= '$curr_date')"); //purret
	$saled_product = $this->getvalfield("saleentry_detail as A left join saleentry as B on A.saleid=B.saleid", "sum(A.qty)","productid='$productid' and B.restorent_id='$rest_id' && A.batchno='$batchno' && (expirydate='0000-00-00' || expirydate>='$curr_date')");
	$issueret = $this->getvalfield("issue_return as A left join issuentry as B on A.issueid=B.issueid","sum(ret_qty)","productid='$productid' and B.restorent_id='$rest_id' && A.batchno='$batchno' && (expirydate='0000-00-00' || expirydate >= '$curr_date')");
	$trans_in = $this->getvalfield("transfer_detail as A left join stock_transfer as B on A.transid=B.transid", "sum(A.qty)","A.productid='$productid' && B.transrestorent_id='$rest_id' && A.batchno='$batchno' && (expirydate='0000-00-00' || expirydate >= '$curr_date')");
	$trans_out = $this->getvalfield("transfer_detail as A left join stock_transfer as B on A.transid=B.transid", "sum(A.qty)","A.productid='$productid' && B.transrestorent_id='$rest_id' && A.batchno='$batchno' && (expirydate='0000-00-00' || expirydate >= '$curr_date')");

		
	$stock = $opening_stock + $purchase_product - $saled_product - $purchase_return - $issueqty + $issued_to_you_qty + $issueret + $trans_in - $trans_out;
	
	return $stock;
}

function get_stock_cond($productid,$sr_sessionid='',$from='',$to='')
{
	$con_pur = '';
	$cond_sal = '';
	$cond_scrap = '';
	$cond_sret = '';
	$cond_pretr='';
										  
   if($sr_sessionid !='')
   $cond_scrap .= " and sessionid = '$sr_sessionid' "; 
   else if($from !='' and $to != '')
   $cond_scrap .= " and scrap_date between '$from' and '$to' "; 
   
   //purchase
    $purchase_product =0;
  	if($sr_sessionid !='')
   $con_pur .= " and sessionid = '$sr_sessionid' "; 
   
   if($from !='' and $to != '')
   {
   		 
		$sql_ret = mysql_query("Select purchaseid from  process_purchase where billdate between '$from' and '$to' $con_pur ");
		if($sql_ret)
		{
			
			$row_ret = mysql_fetch_assoc($sql_ret);
			if($row_ret['purchaseid'] != '')
			$purchase_product += $this->getvalfield("purchased_product", "sum(qty)","purchaseid = '$row_ret[purchaseid]' and productid='$productid' $con_pur");
		}
   }
   else
  	$purchase_product = $this->getvalfield("purchased_product", "sum(qty)","productid='$productid' $con_pur");//purchase
   
   //purchase return
   $purchase_return = 0;
   if($sr_sessionid !='')
   $cond_pretr .= " and sessionid = '$sr_sessionid'"; 
   
   if($from !='' and $to != '')
   {
   		 
		$sql_ret = mysql_query("Select pur_returnid from  process_purchase_return where pur_retdate  between '$from' and '$to' $cond_pretr ");
		if($sql_ret)
		{
			$row_ret = mysql_fetch_assoc($sql_ret);
			if($row_ret['pur_returnid'] != '')
			$purchase_return += $this->getvalfield("pur_return_product", "sum(qty)","pur_returnid = '$row[pur_returnid]' and productid='$productid' $cond_pretr");
		}
   }
   else
   $purchase_return = $this->getvalfield("pur_return_product", "sum(qty)","productid='$productid' $cond_pretr");
   
   //sale return
   $sale_return_product =0;
   if($sr_sessionid !='')
   $cond_sret .= " and sessionid = '$sr_sessionid'"; 
   
   if($from !='' and $to != '')
   {
   		 
		$sql_ret = mysql_query("Select sale_returnid from  process_sale_return where sale_retdate between '$from' and '$to' $cond_sret ");
		if($sql_ret)
		{
			$row_ret = mysql_fetch_assoc($sql_ret);
			if($row_ret['sale_returnid'] != '')
			$sale_return_product += $this->getvalfield("pur_return_product", "sum(qty)","sale_returnid = '$row_ret[sale_returnid]' and productid='$productid' $cond_sret");
		}
   }
   else
   $sale_return_product = $this->getvalfield("sale_return_product", "sum(qty)","productid='$productid' $cond_sret");
   
   //saled
    $saled_product =0;
  	if($cond_sal !='')
   $cond_sal .= " and cond_sal = '$cond_sal' "; 
   
   if($from !='' and $to != '')
   {
   		 
		$sql_ret = mysql_query("Select saleid from  process_sale where saledate between '$from' and '$to' $cond_sal ");
		if($sql_ret)
		{
			$row_ret = mysql_fetch_assoc($sql_ret);
			if($row_ret['saleid'] != '')
			$saled_product += $this->getvalfield("saled_product", "sum(qty)","saleid = '$row_ret[saleid]' and productid='$productid' $cond_sal");
		}
   }
   else
  	$saled_product = $this->getvalfield("saled_product", "sum(qty)","productid='$productid' $cond_sal");//saled
											   
	
	
	$scrap_product = $this->getvalfield("scrap_entry", "sum(qty)","productid='$productid' $cond_scrap");//scrap
	$stock = $purchase_product + $sale_return_product - $saled_product - $purchase_return - $scrap_product;
	
	return $stock;
}

function getretcode($tablename,$emp_code,$cond)
{
	$num =  $this->getvalfield($tablename,"max($emp_code)","$cond");
	
	
	//if($num == NULL)
	//$num = 0;
    ++$num; // add 1;
    $len = strlen($num);
    for($i=$len; $i< 5; ++$i) {
        $num = '0'.$num;
    }
return	$num='EMP'.$num;
    return $num;

}

function getcbwfreg($tablename,$cbwtf_code,$cond)
{
	$num =  $this->getvalfield($tablename,"max($cbwtf_code)","$cond");
	
	
	//if($num == NULL)
	//$num = 0;
    ++$num; // add 1;
    $len = strlen($num);
    for($i=$len; $i< 3; ++$i) {
        $num = '0'.$num;
    }
	//$num="BMW".$num;
   return $num;
	//return $num='CBWT'.$num;
}

function gethcfreg($tablename,$hcf_no,$cond)
{
	
	$num =  $this->getvalfield($tablename,"max($hcf_no)","$cond");
	
	
	//if($num == NULL)
	//$num = 0;
    ++$num; // add 1;
    $len = strlen($num);
    for($i=$len; $i< 5; ++$i) {
        $num = '0'.$num;
    }
	$num=$num;
   return $num;
	//return $num='CBWT'.$num;
}



 /*?>function getreturncode($tablename,$cbwtf_code,$cond)
{
	$num =  $this->getvalfield($tablename,"max($cbwtf_code)","$cond");
	
	
	if($num == NULL)
	$num = 0;
    ++$num; // add 1;
    $len = strlen($num);
    for($i=$len; $i< 5; ++$i) {
        $num = '0'.$num;
    }
	$num='bmw'.$num;
    return $num;
}
<?php */

function backup_tables($host,$user,$pass,$name,$tables = '*')
{
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
	$handle = fopen('backup/db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
}

}
?>