<?php
						require('lib/db.connect.php');
						parse_str($_SERVER['QUERY_STRING'],$params);
						$stmt = $db->prepare('SELECT Book.Bid,Book.Bname,Book.Author,concat(Category.chiName," ",Category.engName) as category,Book.ISBN,Book.Price,Book.Description,Book.PostTime,Book.filename,User.Nickname as Seller FROM Book
						LEFT JOIN Category ON Book.Category = Category.categoryID
						LEFT JOIN User ON User.Uid = Book.Seller
						where ISBN = :happy');
						//$arr=array("{$params['by']}","\"%{$params['q']}%\"");
						//echo $arr[0];
						//echo $arr[1];
						//array("{$params['by']}","\"%{$params['q']}%\"")
						$stmt->bindValue(":happy", "{$params['ISBN']}");
						$stmt->execute();
						$result = $stmt->fetchAll();
						$formatedResult="";
						$data=array();
						if (count($result) > 0){
							foreach ($result as $data) {
				        if ($formatedResult != "") {$formatedResult .= ",";}
								$formatedResult .= '{"Bid":"'  . $data["Bid"] . '",';
								$formatedResult .= '"name":"'  . $data["Bname"] . '",';
					    	$formatedResult .= '"author":"'   . $data["Author"] . '",';
								$formatedResult .= '"Description":"'   . $data["Description"] . '",';
								$formatedResult .= '"ISBN":"'   . $data["ISBN"] . '",';
								$formatedResult .= '"Seller":"'   . $data["Seller"] . '",';
								$formatedResult .= '"category":"'   . $data["category"] . '",';
								$formatedResult .= '"filename":"'   . $data["filename"] . '",';
					    	$formatedResult .= '"PostTime":"'. $data["PostTime"] . '"}';
				      }
							$formatedResult='{"dataset":['.$formatedResult.']}';
							echo $formatedResult;
							}
				    else{
							header('Location: http://bookguide.jaar.ga/error.php');
				      echo($formatedResult);
				    }
						$db=null;
?>
