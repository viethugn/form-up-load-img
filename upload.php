<?php
class UploadImage
{
  public $target_file;
  public $imageFileType;
  public $target_dir;

  function __construct($target_file, $imageFileType, $target_dir)
  {
    $this->target_file = $target_file;
    $this->imageFileType = $imageFileType;
    $this->target_dir = $target_dir;
   
  }

  function get_target_file()
  {
    return $this->target_file;
  }
  function get_imageFileType()
  {
    return $this->imageFileType;
  }
  function get_target_dir()
  {
    return $this->target_dir;
  }
  // function get_uploadOk()
  // {
  //   return $this->uploadOk;
  // }

  // call all function
  public function init()
  {
    if ($this->checkNoInputImageWhenSubmit() === true) { //check input empty
      echo "<br><br>Bạn chưa chọn tệp!";
    } elseif ($this->checkFileExist() === true) {//check file exist
      echo "<br><br>Thông báo, tệp này đã tồn tại!";
    } elseif ($this->checkFileSize()) {
      echo "<br><br>Thông báo, file bạn đưa vào lớn hơn 5MB!";
    } elseif ($this->checkTypeImage() === true) {//check type is type img
      echo "<br><br>Thông báo, chỉ cho phép các file có định dạng sau JPG, JPEG, PNG & GIF";
    } elseif ($this->checkCountFileImgInDir() === true ){//check dir <=5
      echo "<br><br>Số lượng tệp đã đầy";
    } else {
      $this->checkInputImageWhenSubmit();
      $this->checkUploadOkToUpload();
    }
  }

  public function checkNoInputImageWhenSubmit()
  {
    // Check if image file is empty
    if (isset($_POST["submit"]) && empty($_FILES["fileToUpload"]["tmp_name"])) {
      return true;
    }
    return false;
  }

  public function checkInputImageWhenSubmit() {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
      echo "<br><br>File ảnh là - " . $check["mime"] . ".";
      // $this->uploadOk = 1;
    } else {
      echo "<br><br>File không phải là file hình!.";
      // $this->uploadOk = 0;
    }
  }

  public function checkFileSize()
  {
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5120) {
      // $this->uploadOk = 0;
      return true;
    }
    return false;
  }

  public function checkTypeImage()
  {
    // Allow certain file formats
    if ($this->get_imageFileType() != "jpg" && $this->get_imageFileType() != "png" && $this->get_imageFileType() != "jpeg" 
      && $this->get_imageFileType() != "gif") {
      // $this->uploadOk = 0;
      return true;
    }
    return false;
  }

  public function checkFileExist()
  {
    // Check if file already exists
    if (file_exists($this->get_target_file())) {
      // $this->uploadOk = 0;
      return true;
    }
    return false;
  }

  public function checkUploadOkToUpload()
  {
    if ( move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $this->get_target_file())) {
        echo "<br><br>Tệp " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " đã được tải lên!";
    } else {
        echo "<br><br><strong class='text-blue-300'>Thông báo, file ảnh khi tải lên có sự cố!.</strong>";
    }
  }

  //Count image in dir
  public function countImage()
  {
    $total_files = 0;
    if (is_dir($this->get_target_dir())) {
      $dp = opendir($this->get_target_dir());
      if ($dp) {
        while (($filename = readdir($dp)) == true) {
          if (($filename != ".") && ($filename != "..")) {
            $total_files++;
          }
        }
      }
    }
    return $total_files;
  }

  public function checkCountFileImgInDir()
  {
    if ($this->countImage() >= 5) {
      return true;
    }
    return false;
  }
}


//when event is submit
if (isset($_POST["submit"])) {
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  // $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  //Create new object
  $uploadimg = new UploadImage($target_file, $imageFileType, $target_dir);
  $uploadimg->init();
  $temp = 0;

}

// $uploadimg = new UploadImage($target_file, $imageFileType, $target_dir, $uploadOk = '1');
// $uploadimg->init();

// echo "<br><br><<<a href='index.php'>Trở lại</a>>>";
