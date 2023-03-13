<?php
class UploadImage
{
  public $target_file;
  public $imageFileType;
  public $target_dir;
  public $uploadOk;

  function __construct($target_file, $imageFileType, $target_dir, $uploadOk)
  {
    $this->target_file = $target_file;
    $this->imageFileType = $imageFileType;
    $this->target_dir = $target_dir;
    $this->uploadOk = $uploadOk;
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
  function get_uploadOk()
  {
    return $this->uploadOk;
  }

  // call all function
  public function init()
  {
    if ($this->checkImage() === 0) {
      $this->checkImage();
    } else {
      $this->checkFileExist();
      $this->checkFileSize();
      $this->checkTypeImage();
      $this->checkUploadOkToUpload();
      $this->checkCountFileInDir();
    }
  }

  private function checkImage()
  {
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
      if (empty($_FILES["fileToUpload"]["tmp_name"])) {
        echo "<br><br>Bạn chưa chọn file";
        return 0;
      } else {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
          echo "<br><br>File ảnh là - " . $check["mime"] . ".";
          $this->uploadOk = 1;
        } else {
          echo "<br><br>Tệp không phải là file hình!.";
          $this->uploadOk = 0;
        }
      }
    }
  }

  public function checkFileExist()
  {
    // Check if file already exists
    if (file_exists($this->get_target_file())) {
      echo "<br><br>Xin lỗi, file đã tồn tại!";
      $this->uploadOk = 0;
    }
  }

  public function checkFileSize()
  {
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5120) {
      echo "<br><br>Xin lỗi, file bạn đưa vào lớn hơn 5MB!";
      $this->uploadOk = 0;
    }
  }

  public function checkTypeImage()
  {
    // Allow certain file formats
    if (
      $this->get_imageFileType() != "jpg" && $this->get_imageFileType() != "png" && $this->get_imageFileType() != "jpeg"
      && $this->get_imageFileType() != "gif"
    ) {
      echo "<br><br>Thông báo, chỉ cho phép các file có định dạng sau JPG, JPEG, PNG & GIF";
      $this->uploadOk = 0;
    }
  }

  public function checkUploadOkToUpload()
  {
    // Check if $uploadOk is set to 0 by an error
    if ($this->uploadOk == 0) {
      echo "<br><br>Thông báo, file của bạn không đưa lên được!";
      // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $this->get_target_file())) {
        echo "<br><br>File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " đã được tải lên!";
      } else {
        echo "<br><br><strong class='text-blue-300'>Xin lỗi, file ảnh khi tải lên có sự cố!.</strong>";
      }
    }
  }

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

  public function checkCountFileInDir () {
    if ($this->countImage() > 5) {
      echo "<br><br>Số lượng tệp đã đầy";
    }
  }
}

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$uploadimg = new UploadImage($target_file, $imageFileType, $target_dir, $uploadOk = '1');
$uploadimg->init();
