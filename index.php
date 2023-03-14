<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload image</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- <link href="./app.css" rel="stylesheet">
    <link href="./tailwind/styles.css" rel="stylesheet"> -->
</head>

<body>
  <div class="w-full h-100vh flex justify-center align-middle mx-auto">
    <form action="" method="post" enctype="multipart/form-data">
      <label for="formFile" class="mb-2 inline-block text-neutral-700 dark:text-neutral-200">Chọn ảnh bạn muốn tải lên</label>
      <input class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 dark:border-neutral-600 bg-clip-padding py-[0.32rem] px-3 text-base font-normal text-neutral-700 dark:text-neutral-200 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 dark:file:bg-neutral-700 file:px-3 file:py-[0.32rem] file:text-neutral-700 dark:file:text-neutral-100 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none" type="file" name="fileToUpload" id="fileToUpload">
      <input class="bg-gray-400 mt-5 rounded-lg p-2" type="submit" value="Upload Image" name="submit">
    </form>
  </div>
  <div class="flex justify-center align-middle">
    <?php require './upload.php'; ?>
  </div>
</body>

</html>