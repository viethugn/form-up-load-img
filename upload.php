<?php
class UploadImage
{
  private $target_file;
  private $imageFileType;
  private $target_dir;
  private $fileToUpload;
  private $uploadOk;
  private $uploadName; 
  private $uploadTmp_name; 
  private $uploadSize;

  function __construct($target_file, $imageFileType, $target_dir, $fileToUpload, $uploadOk, $uploadName, $uploadTmp_name, $uploadSize)
  {
    $this->target_file = $target_file;
    $this->imageFileType = $imageFileType;
    $this->target_dir = $target_dir;
    $this->fileToUpload = $fileToUpload;
    $this->uploadOk = $uploadOk;
    $this->uploadName = $uploadName;
    $this->uploadTmp_name = $uploadTmp_name; 
    $this->uploadSize = $uploadSize;
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
      $this->checkFileSize(); // Check file size
      $this->checkFileExist(); // Check file exist
      $this->checkTypeImage(); // Check style file
      $this->checkNumInputFile(); // Check num file when input & click submit
      $this->uploadOkToUpload(); // Check file when all validate
    }
  }

  public function countNameInFileToUpload()
  {
    $countArr = count($this->fileToUpload["$this->uploadName"]);
    return $countArr;
  }

  public function checkNoInputImageWhenSubmit()
  {
    // Check if image file is empty
    for ($i = 0; $i < 1; $i++) {
      if ($this->fileToUpload["$this->uploadName"][$i] == "") {
        return true;
      }
    }
    return false;
  }



  public function checkFileSize ()
  {
    for ($i = 0; $i < $this->countNameInFileToUpload(); $i++) {
      // Check file size
      if ($this->fileToUpload["$this->uploadSize"][$i] > 5242880) {
        echo "<br><br>Thông báo!, dung lượng file  " . htmlspecialchars(basename($this->fileToUpload["$this->uploadName"][$i])) . "  bạn đưa vào vượt quá 5MB!";
        $this->uploadOk = 0;
      }
    }

  }

  public function checkTypeImage ()
  {
    $checkwhenfailtype = 1;
    
    for ($i = 0; $i < $this->countNameInFileToUpload(); $i++) {
      if (
        $this->imageFileType[$i] != "jpg" && $this->imageFileType[$i] != "png" && $this->imageFileType[$i] != "jpeg"
        && $this->imageFileType[$i] != "gif"
      ) {
        echo "<br><br>Thông báo!, file " . htmlspecialchars(basename($this->fileToUpload["$this->uploadName"][$i])) . " này không đúng định dạng!";
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
      if (file_exists($this->target_file[$i])) {
        echo "<br><br>Thông báo!, file " . htmlspecialchars(basename($this->fileToUpload["$this->uploadName"][$i])) . " này đã tồn tại!";
        $this->fileToUpload["error"][$i] = "<br><br>Thông báo!, file " . htmlspecialchars(basename($this->fileToUpload["$this->uploadName"][$i])) . " này đã tồn tại!";
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
    if ($this->get_uploadOk() == 1) {
      for ($i = 0; $i < $this->countNameInFileToUpload(); $i++) {
        $check = getimagesize($this->fileToUpload["$this->uploadTmp_name"][$i]);
        if ($check !== false) {
          if (move_uploaded_file($this->fileToUpload["$this->uploadTmp_name"][$i], $this->target_file[$i])) {
            echo "<br><br>File " . htmlspecialchars(basename($this->fileToUpload["$this->uploadName"][$i])) . " đã được tải lên!";
          } else {
            echo "<br><br><strong class='text-blue-300'>Thông báo1, file ảnh " . htmlspecialchars(basename($this->fileToUpload["$this->uploadName"][$i])) . " khi tải lên có sự cố!.</strong>";
          }
        } else {
          echo "<br><br>File " . htmlspecialchars(basename($this->fileToUpload["$this->uploadName"][$i])) . " không phải là file hình!.";
          $this->uploadOk = 0;
        }
      }
    }
  }

}


//when event is submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["submit"])) {

    $target_dir = "uploads/";
    $fileToUpload = $_FILES["fileToUpload"];
    $uploadName = "name";
    $uploadTmp_name = "tmp_name";
    $uploadSize = "size";

    $uploadOk = 1;
    $target_file = array();
    $imageFileType = array();
  
    $countArr = count($fileToUpload["$uploadName"]);
  
    for ($i = 0; $i < $countArr; $i++) {
      array_push($target_file, $target_dir . basename($fileToUpload["$uploadName"][$i]));
      array_push($imageFileType, strtolower(pathinfo($target_file[$i], PATHINFO_EXTENSION)));
    }
    
    // Create new object
    $uploadimg = new UploadImage($target_file, $imageFileType, $target_dir, $fileToUpload, $uploadOk, $uploadName, $uploadTmp_name, $uploadSize);
    $uploadimg->init();

    // var_dump($_FILES["fileToUpload"]["error"]);
  }
}
