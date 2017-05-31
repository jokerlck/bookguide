<?php
	header('Content-Type: application/json; charset=utf-8');
	require('lib/db.connect.php');
	parse_str($_SERVER['QUERY_STRING'],$params);
	if(!array_key_exists('by', $params)){
		$qs="";
		$hashtag="";
		$seller=0;
		foreach ($params as $key => $var) {
			if($var <> "" && $var != "NULL" ){
				if($key == "category"){
					$qs.="a.";
					$qs.=$key;
					$qs.=" = ";
					$qs.="{$var}&&";
				}
				elseif($key == "min_price"){
					$qs.="a.";
					$qs.="Price";
					$qs.=" BETWEEN ";
					$qs.="{$var}";
				}
				elseif($key == "max_price"){
					$qs.=" AND ";
					$qs.="{$var}&&";
				}
				elseif($key == "hash_tag"){
					$tag=explode(",",$var);
					foreach ( $tag as $i) {
						# code...
						$hashtag.="Tag";
						$hashtag.=" like \"%";
						$hashtag.=$i;
						$hashtag.="%\" || ";
					}
					$hashtag=rtrim($hashtag,"|| ");

				}
				elseif($key == "Bname"){
					$qs.="a.";
					$qs.=$key;
					$qs.=" like ";
					$qs.="\"%{$var}%\"&&";
				}
				elseif($key == "ISBN"){
					$qs.="a.";
					$qs.=$key;
					$qs.=" like ";
					$qs.="\"%{$var}%\"&&";
				}
				elseif($key == "Author"){
					$qs.="a.";
					$qs.=$key;
					$qs.=" like ";
					$qs.="\"%{$var}%\"&&";
				}
				elseif($key == "Seller"){
					$seller=1;
					if(is_numeric($var)){
						$qs.="a.";
						$qs.=$key;
						$qs.=" = ";
						$qs.="{$var} &&";
					}
					else{
						$qs.="User.Nickname";
						$qs.=" like ";
						$qs.="\"%{$var}%\"&&";
					}
				}
				else{

				}
			}
		}
		$qs=rtrim($qs,"&& ");
		$stmt = $db->prepare('SELECT a.*,User.Nickname,User.Email as Seller FROM Book a INNER JOIN  (SELECT ISBN, MIN(Bid) as Bid FROM Book GROUP BY ISBN ) AS b ON a.ISBN = b.ISBN AND a.Bid = b.Bid left join User on User.Uid=a.Seller left join Hashtag on Hashtag.Book=a.Bid WHERE '.$qs.';');
		$stmt->execute();
		$result = $stmt->fetchAll();
		if ($result){
			$output['dataset'] = $result;
			$output['seller'] = $seller;
		} else {
			$output['error'] = "No Record Found";
    	}
	} else {
		if($params['by']=="Category"){
			if(is_numeric($params['q'])){
				$stmt = $db->prepare('SELECT * FROM `Category` WHERE categoryID=?');
				$stmt->BindValue(1, $params['q']);
				$stmt->execute();
				$categoryResult = $stmt->fetch();
				$category = $categoryResult['engName'];

				$stmt = $db->prepare('SELECT a.*,concat(Category.chiName," ",Category.engName) as category FROM Book a
				INNER JOIN  (SELECT ISBN, MIN(Bid) as Bid FROM Book GROUP BY ISBN )AS b ON a.ISBN = b.ISBN AND a.Bid = b.Bid
				left join Category on Category.categoryID=a.Category
				WHERE a.Category=:colour AND a.`Status`!="c"');
				$stmt->bindValue(":colour", "{$params['q']}");
			}
			else{
				$stmt = $db->prepare('SELECT a.*,concat(Category.chiName," ",Category.engName) as category FROM Book a
				INNER JOIN  (SELECT ISBN, MIN(Bid) as Bid FROM Book GROUP BY ISBN )AS b ON a.ISBN = b.ISBN AND a.Bid = b.Bid
				left join Category on Category.categoryID=a.Category
				WHERE (Category.chiName like :colour or lower(Category.engName) like :colour2) AND a.`Status`!="c"');
				$stmt->bindValue(":colour", "%{$params['q']}%");
				$stmt->bindValue(":colour2", "%{$params['q']}%");
			}

		}
		else if($params['by']=="Hashtag"){
			$stmt = $db->prepare("SELECT b.*, `User`.`Nickname` FROM `User` INNER JOIN (SELECT * FROM `Hashtag` INNER JOIN `Book` ON `Book`.`Bid`=`Hashtag`.`Book`) AS b ON b.`Seller` = `User`.`Uid` WHERE b.`Tag`= :colour AND b.`Status`!='c' ORDER BY `PostTime` DESC LIMIT 50");
			$stmt->bindValue(":colour", "{$params['q']}");
		}
		else{
			$stmt = $db->prepare('SELECT a.* FROM Book a INNER JOIN  (SELECT ISBN, MIN(Bid) as Bid FROM Book GROUP BY ISBN ) AS b ON a.ISBN = b.ISBN AND a.Bid = b.Bid WHERE lower(a.' . $params['by'] . ') like :colour');
			$stmt->bindValue(":colour", "%{$params['q']}%");
		}
		//$arr=array("{$params['by']}","\"%{$params['q']}%\"");
		//echo $arr[0];
		//echo $arr[1];
		//array("{$params['by']}","\"%{$params['q']}%\"");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$num=count($result);
		if (count($result) > 0){
			$output['dataset'] = $result;			
			$output['by'] = $params['by'];
			if ($params['by'] == 'Bname')
				$output['by'] = 'Book Name';
			$output['num'] = $num;
			if (isset($category))
				$output['q'] = $category;
			else
				$output['q'] = $params['q'];
		} else {
			$output['error'] = "Error Occured;";
    	}
	}	
    echo json_encode($output);
?>
