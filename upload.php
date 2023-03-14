<?php
class UploadImage
{
  private $target_file;
  private $imageFileType;
  private $target_dir;
  private $fileToUpload;
  private $uploadOk;

  function __construct($target_file, $imageFileType, $target_dir, $fileToUpload, $uploadOk)
  {
    $this->target_file = $target_file;
    $this->imageFileType = $imageFileType;
    $this->target_dir = $target_dir;
    $this->fileToUpload = $fileToUpload;
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
  function get_fileToUpload()
  {
    return $this->fileToUpload;
  }
  function get_uploadOk()
  {
    return $this->uploadOk;
  }

  // call all function
  public function init()
  {
    $this->startAll();
  }

  public function startAll()
  {
    if ($this->checkNoInputImageWhenSubmit()) { //check input empty
      echo "<br><br>Bạn chưa chọn tệp!";
    } else {
      $this->checkFileSize();// Check file size
      $this->checkFileExist();// Check file exist
      $this->checkTypeImage();// Check style file
      $this->checkNumInputFile();// Check num file when input & click submit
      $this->uploadOkToUpload(); // Check file when all validate
    }
  }

  public function countNameInFileToUpload()
  {
    $countArr = count($_FILES["$this->fileToUpload"]["name"]);
    return $countArr;
  }

  public function checkNoInputImageWhenSubmit()
  {
    // Check if image file is empty
    for ($i = 0; $i < 1; $i++) {
      if ($_FILES["$this->fileToUpload"]["name"][$i] == "") {
        return true;
      }
    }
    return false;
  }

  public function checkInputImageWhenSubmit()
  {
    $check = getimagesize($_FILES["$this->fileToUpload"]["tmp_name"]);
    if ($check !== false) {
      echo "<br><br>File ảnh là - " . $check["mime"] . ".";
      // $this->uploadOk = 1;
    } else {
      echo "<br><br>File không phải là file hình!.";
      // $this->uploadOk = 0;
    }
  }

  // public function sumSizeAllFileInput($fx, $fy) {
  //   return $fx + $fy;
  // }

  public function checkFileSize()
  {
    $sumfile = array_reduce($_FILES["$this->fileToUpload"]["size"], function ($fx, $fy) {
      return $fx + $fy;
    }, 0);
    // Check file size
    if ($sumfile > 5242880) {
      echo "<br><br>Thông báo!, tổng dung lượng file bạn đưa vào vượt quá 5MB!";
      $this->uploadOk = 0;
    }
  }

  public function checkTypeImage()
  {
    // Allow certain file formats
    $checkwhenfailtype = 1;
    for ($i = 0; $i < $this->countNameInFileToUpload(); $i++) {
      if (
        $this->get_imageFileType()[$i] != "jpg" && $this->get_imageFileType()[$i] != "png" && $this->get_imageFileType()[$i] != "jpeg"
        && $this->get_imageFileType()[$i] != "gif"
      ) {
        echo "<br><br>Thông báo!, tệp " . htmlspecialchars(basename($_FILES["$this->fileToUpload"]["name"][$i])) . " này không đúng định dạng!";
        $this->uploadOk = 0;
        $checkwhenfailtype = 0;
      }
    }
    if ($checkwhenfailtype == 0) {
      echo "<br><br>Thông báo!, chỉ cho phép các file có định dạng sau JPG, JPEG, PNG & GIF";
    }
  }

  public function checkFileExist()
  {
    // Check if file already exists
    for ($i = 0; $i < $this->countNameInFileToUpload(); $i++) {
      if (file_exists($this->get_target_file()[$i])) {
        echo "<br><br>Thông báo!, tệp " . htmlspecialchars(basename($_FILES["$this->fileToUpload"]["name"][$i])) . " này đã tồn tại!";
        $this->uploadOk = 0;
      }
    }
  }

  public function checkNumInputFile()
  {
    if ($this->countNameInFileToUpload() > 5) {
      echo "<br><br>Thông báo!, Số lượng file vượt quá số lượng tải lên cho phép là 5";
      $this->uploadOk = 0;
    }
  }

  public function uploadOkToUpload()
  {
    $countArr = count($_FILES["$this->fileToUpload"]["name"]);
    if ($this->get_uploadOk() == 1) {
      for ($i = 0; $i < $countArr; $i++) {
        if (move_uploaded_file($_FILES["$this->fileToUpload"]["tmp_name"][$i], $this->get_target_file()[$i])) {
          echo "<br><br>Tệp " . htmlspecialchars(basename($_FILES["$this->fileToUpload"]["name"][$i])) . " đã được tải lên!";
        } else {
          echo "<br><br><strong class='text-blue-300'>Thông báo1, file ảnh " . htmlspecialchars(basename($_FILES["$this->fileToUpload"]["name"][$i])) . " khi tải lên có sự cố!.</strong>";
        }
      }
    }
  }

  //Count image in dir
  // public function countImage()
  // {
  //   $total_files = 0;
  //   if (is_dir($this->get_target_dir())) {
  //     $dp = opendir($this->get_target_dir());
  //     if ($dp) {
  //       while (($filename = readdir($dp)) == true) {
  //         if (($filename != ".") && ($filename != "..")) {
  //           $total_files++;
  //         }
  //       }
  //     }
  //   }
  //   return $total_files;
  // }

  // public function checkCountFileImgInDir()
  // {
  //   if ($this->countImage() >= 5) {
  //     return true;
  //   }
  //   return false;
  // }
}


//when event is submit
if (isset($_POST["submit"])) {

  $target_dir = "uploads/";
  $fileToUpload = "fileToUpload";
  $uploadOk = 1;

  $countArr = count($_FILES["$fileToUpload"]["name"]);
  $target_file = array();
  $imageFileType = array();

  for ($i = 0; $i < $countArr; $i++) {
    array_push($target_file, $target_dir . basename($_FILES["$fileToUpload"]["name"][$i]));
    array_push($imageFileType, strtolower(pathinfo($target_file[$i], PATHINFO_EXTENSION)));
  }
  //Create new object
  $uploadimg = new UploadImage($target_file, $imageFileType, $target_dir, $fileToUpload, $uploadOk);
  $uploadimg->init();
}
