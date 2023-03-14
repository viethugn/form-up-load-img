  Code co the dung lai
  
  
   // public function checkInputImageWhenSubmit()
  // {
  //   for ($i = 0; $i < $this->countNameInFileToUpload(); $i++) {
  //     $check = getimagesize($_FILES["$this->fileToUpload"]["tmp_name"][$i]);
  //     // echo var_dump($check);
  //     if ($check !== false) {
  //       // echo "<br><br>File ảnh là - " . $check["mime"]. ".";
  //       $this->uploadOk = 1;
  //     } else {
  //       echo "<br><br>File " . htmlspecialchars(basename($_FILES["$this->fileToUpload"]["name"][$i])) . " không phải là file hình!.";
  //       $this->uploadOk = 0;
  //     }
  //   }
  // }
  public function checkFileSize ()
  {
    $sumfile = array_reduce($this->fileToUpload["size"], function ($fx, $fy) {
      return $fx + $fy;
    }, 0);
    // Check file size
    if ($sumfile > 5242880) {
      echo "<br><br>Thông báo!, tổng dung lượng file bạn đưa vào vượt quá 5MB!";
      $this->uploadOk = 0;
    }
  }
   // $check = getimagesize($_FILES["$this->fileToUpload"]["tmp_name"][$i]);
      // if ($check !== false) {
      //   // echo "<br><br>File ảnh là - " . $check["mime"]. ".";
      //   $this->uploadOk = 1;
      // } else {
      //   echo "<br><br>File " . htmlspecialchars(basename($_FILES["$this->fileToUpload"]["name"][$i])) . " không phải là file hình!.";
      //   $this->uploadOk = 0;
      // }
  
  
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



