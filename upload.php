<?php
  // Handling file uploading
  if (isset($_FILES['image'])){
    error_reporting(E_ERROR);
    header('Content-Type: application/json; charset=utf-8');
    $output = array();
    $output['uploaded_file'] = array();
    $target_dir = "data/upload/";

    for ($i = 0; $i < count($_FILES["image"]["name"]); $i++){
      $new_filename = date("YmdHis")."_".preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES["image"]["name"][$i]));
      $target_file = $target_dir . $new_filename;
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"][$i]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
          $output['error'] = "File is not an image.";
            $uploadOk = 0;
        }

      if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF") {
          $output['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
        }

        if ($uploadOk != 0) {
          if (move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_file)) {
            chmod($target_file,0644);
            array_push($output['uploaded_file'], $new_filename);
          } else {
              $output['error'] = "Sorry, there was an error uploading your file.";
          }
      }
    }


    $json_string = json_encode($output);
    echo $json_string;
    exit();
  }

  if(isset($_POST['uploaded'])){

    $hashtags = explode(",", $_POST["hash_tag"]);
    session_start();
    require('lib/db.connect.php');
    require('lib/user_info.php');
    $stmt = $db->prepare('INSERT INTO `Book` (`Bname`, `ISBN`, `Author`, `Category`, `Price`, `Description`, `Seller`, `filename`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->BindValue(1, $_POST['bookname']);
    $stmt->BindValue(2, $_POST['isbn']);
    $stmt->BindValue(3, $_POST['author']);
    $stmt->BindValue(4, $_POST['category']);
    $stmt->BindValue(5, $_POST['price']);
    $stmt->BindValue(6, $_POST['descriptiont']);
    $stmt->BindValue(7, $_SESSION['user']);
    $stmt->BindValue(8, $_POST['uploaded']);
    $stmt->execute();

    $stmt = $db->prepare('SELECT LAST_INSERT_ID()');
    $stmt->execute();
    $bid = $stmt->fetch()[0];

    $hashtags = explode(",", $_POST["hash_tag"]);
    foreach ($hashtags as $hashtag){
      $hashtag = trim($hashtag);
      $stmt = $db->prepare('INSERT INTO `Hashtag` (`Book`, `Tag`) VALUES (?, ?)');
      $stmt->BindValue(1, $bid);
      $stmt->BindValue(2, $hashtag);
      $stmt->execute();
    }


    header("Location: upload.php?success=1");
  }

?>
<?php
  $page_config['title'] = 'Upload Item';
  $page_config['js'] = array(
                                  'lib/bootstrap-tokenfield/bootstrap-tokenfield.min.js',
                                  'lib/bootstrap-tokenfield/typeahead.bundle.min.js',
                                  'lib/bootstrap-fileinput/js/plugins/sortable.min.js',
                                  'lib/bootstrap-fileinput/js/fileinput.min.js',
                                  'upload.js');
  $page_config['css'] = array('lib/bootstrap-fileinput/css/fileinput.min.css',
                                  'lib/bootstrap-tokenfield/css/bootstrap-tokenfield.css',
                                  'lib/bootstrap-tokenfield/css/tokenfield-typeahead.css'
                                  );
  include('template/main.php');
?>
<div class="container">
  <?php if (isset($_GET['success']) && $_GET['success'] == "1"):?>
    <div class="alert alert-success">
      Successfully Uploaded.
    </div>
  <?php endif; ?>

  <div class="box-head clearfix">
      <h1 class="pull-left">Upload Item</h1>
  </div>
  <br>
  <form method="POST" action="upload.php" id="upload-form">
      <table id="upload" class="table">
        <tbody>
          <tr>
            <td>Book Name</td>
            <td><input type="text" id="bookname" name="bookname" class="form-control"></td>
          </tr>
          <tr>
            <td>ISBN</td>
            <td><input type="text" id="isbn" name="isbn" class="form-control"></td>
          </tr>
          <tr>
            <td>Author</td>
            <td><input type="text" id="author" name="author" class="form-control"></td>
          </tr>
          <tr>
            <td>Category</td>
            <td>
              <select class="form-control" name="category" id="category" placeholder="Choose the Category" required>

                <?php
                  $stmt = $db->prepare("SELECT b.* FROM `Category` a INNER JOIN `Category` b ON (b.`categoryID`=a.`parentID`) GROUP BY b.`categoryID`");
                  $stmt->execute();
                  $mainCategories = $stmt->fetchAll();
                ?>
                <?php foreach ($mainCategories as $mainCategory): ?>
                <option disabled>-----<?php echo $mainCategory['chiName']?> <?php echo $mainCategory['engName']?>-----</option>
                <?php
                  $subStmt = $db->prepare("SELECT * FROM `Category` WHERE `parentID`=?");
                  $subStmt->bindValue(1, $mainCategory['categoryID']);
                  $subStmt->execute();
                  $subEntries = $subStmt->fetchAll();
                ?>
                <?php if (sizeof($subEntries) > 0): ?>
                  <?php foreach ($subEntries as $subentry): ?>
                    <option value="<?php echo $subentry['categoryID']?>"><?php echo $subentry['chiName']?> <?php echo $subentry['engName']?></option>
                  <?php endforeach;?>
                <?php endif;?>
                <?php endforeach;?>

                <option disabled>-----其他 Others-----</option>
                <?php
                  $subStmt = $db->prepare("SELECT * FROM `Category` WHERE `parentID` = -1 AND `categoryID` NOT IN( SELECT b.`categoryID` FROM `Category` a INNER JOIN `Category` b ON(b.`categoryID` = a.`parentID`))");
                  $subStmt->execute();
                  $subEntries = $subStmt->fetchAll();
                ?>
                <?php if (sizeof($subEntries) > 0): ?>
                  <?php foreach ($subEntries as $subentry): ?>
                    <option value="<?php echo $subentry['categoryID']?>"><?php echo $subentry['chiName']?> <?php echo $subentry['engName']?></option>
                  <?php endforeach;?>
                <?php endif;?>

              </select>
            </td>
          </tr>
          <tr>
            <td>Photo</td>
            <td>
              <input id="uploader" name="image[]" type="file" class="file-loading" multiple data-show-caption="true">
                        </td>
          </tr>
          <tr>
            <td>Hash Tag</td>
            <td><input type="text" id="hash_tag" name="hash_tag" class="form-control" placeholder="Press comma after each input"></td>

          </tr>
          <tr>
            <td>Price</td>
            <td><div class="input-group">
            <span class="input-group-addon">HK$</span><input type="number" id="price" name="price" class="form-control" max="999999" min="0"></div>
            </td>
          </tr>
          <tr>
            <td>Description</td>
            <td><input type="text" id="descriptiont" name="descriptiont" class="form-control"></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="modal-footer">
      <input type="hidden" name="uploaded" id="uploaded">
      <button name="upload-btn" type="button" class="btn btn-primary" id="upload-btn">Upload</button>
    </div>
</form>
<?php include('template/footer.php');?>
