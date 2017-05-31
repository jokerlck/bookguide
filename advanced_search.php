<?php include('template/main.php');?>
<div class="container">
  <div class="box-head clearfix">
      <h1 class="pull-left">Advanced Search</h1>
  </div>
  <br>
  <div class="table-container">
    <form id="my_form" action="category_page.php" method="GET"></form>
    <table id="advance_search" class="table is-datatable dataTable" >
      <tbody>
        <tr>
          <td>Book Name</td>
          <td><input type="text" id="bookname" name="Bname" class="form-control" form="my_form"></td>
        </tr>
        <tr>
          <td>ISBN</td>
          <td><input type="text" id="isbn" name="ISBN" class="form-control" form="my_form"></td>
        </tr>
        <tr>
          <td>Author</td>
          <td><input type="text" id="author" name="Author" class="form-control" form="my_form"></td>
        </tr>
        <tr>
          <td>Category</td>
          <td>
            <select class="form-control" name="Category" id="category" placeholder="Choose your District" required form="my_form">
              <!-- Category list -->
              <option value="NULL"> </option>

              <option value="0">-----辭書及工具書 Reference-----</option>
              <option value="1">辭書 Dictionary</option>
              <option value="2">百科全書 Encyclopedia</option>
              <option value="3">工具書 Reference books</option>

              <option value="4">-----語言文字 Language-----</option>
              <option value="5">語言學理論 Linguistic</option>
              <option value="6">中文 Chinese</option>
              <option value="7">英語 English</option>
              <option value="8">日語 Japanese</option>
              <option value="9">其他外語 Other languages</option>
              <option value="10">翻譯理論 Translation</option>


              <option value="11">-----文學 Literature-----</option>
              <option value="12">文學理論 Literary Theory</option>
              <option value="13">中國文學 Chinese Literature</option>
              <option value="14">世界文學 World Literature</option>
              <option value="15">文學研究及批評 Literary Hist & Crit</option>
              <option value="16">-----傳記 Biography-----</option>
              <option value="17">-----哲學 Philosophy-----</option>
              <option value="18">-----宗教 Religion-----</option>
              <option value="19">-----社會科學 Social Science-----</option>
              <option value="20">-----教育 Education-----</option>
              <option value="21">-----金融與商務 Business & Finance-----</option>
              <option value="22">-----工程學 Engineering-----</option>
              <option value="23">-----電腦與資訊科技 Computer & Information Technology-----</option>
              <option value="24">-----自然科學 Natural Science-----</option>
              <option value="25">-----醫藥衛生 Health & Medicine-----</option>
              <option value="26">-----藝術及音樂 Art & Music-----</option>
              <option value="27">-----生活百科 Leisure-----</option>
              <option value="28">-----地理旅遊 Geography & Travel-----</option>
              <option value="29">地圖 Atlas and Map</option>
              <option value="30">旅遊 Travel Guide</option>
              <option value="31">地理 Geography</option>
              <option value="32">-----流行讀物 Popular Books-----</option>
              <option value="33">小說散文 Novel</option>
              <option value="34">幽默小品 Humour</option>
              <option value="35">漫畫 Comics & Cartoon</option>
              <option value="36">其他 Other</option>

            </select>
          </td>
        </tr>
        <tr>
          <td>Hash Tag</td>
          <td><input type="text" id="hash_tag" name="hash_tag" class="form-control" form="my_form"></td>
        </tr>
        <tr>
          <td>Seller Name</td>
          <td><input type="text" id="seller" name="Seller" class="form-control" form="my_form"></td>
        </tr>
        <tr>
          <td>Minimum Price</td>
          <td><input type="text" id="min_price" name="min_price" class="form-control" form="my_form"></td>
        </tr>
        <tr>
          <td>Maximum Price</td>
          <td><input type="text" id="max_price" name="max_price" class="form-control" form="my_form"></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button name="submit" type="submit" class="btn btn-primary" id="submit" form="my_form">Search</button>
  </div>
</div>
<script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.0/angular.min.js"></script>
</script>
<?php include('template/footer.php');?>
