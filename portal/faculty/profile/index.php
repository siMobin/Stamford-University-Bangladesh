<?php
$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') !== false ? 'https://' : 'http://';
$host = $protocol . $_SERVER['HTTP_HOST'];

// session_start(); // Start session if not already started

if (isset($_SESSION["FacultyId"])) {
  $sessionId = $_SESSION["FacultyId"];
} else {
  echo "Session not set or Not found";
  exit; // Terminate script execution
}

require($_SERVER["DOCUMENT_ROOT"] . "/conn.php");
require($_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php");

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

$userResult = sqlsrv_query($conn, "SELECT * FROM profilePicture WHERE id = ?", array($sessionId));
$user = sqlsrv_fetch_array($userResult, SQLSRV_FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"]["name"])) {
  $id = $sessionId;

  $imageName = $_FILES["image"]["name"];
  $imageSize = $_FILES["image"]["size"];
  $tmpName = $_FILES["image"]["tmp_name"];

  $validImageExtension = ['jpg', 'jpeg', 'png', 'webp'];
  $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);

  if (!in_array(strtolower($imageExtension), $validImageExtension)) {
    echo "<script>alert('Invalid Image Extension');</script>";
  } elseif ($imageSize > 1200000) {
    echo "<script>alert('Image Size Is Too Large');</script>";
  } else {
    $newImageName = $id . "_" . date("YmdHis") . '.' . $imageExtension;
    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/storage/profile/' . $newImageName;

    if (move_uploaded_file($tmpName, $uploadDirectory)) {
      // Open the uploaded image using Intervention Image
      $manager = new ImageManager(Driver::class);

      // Now that the file is uploaded, use Intervention Image
      $image = $manager->read($uploadDirectory);

      // Crop the best fitting 1:1 (500x500) ratio and resize to 500x500 pixels
      $image->cover(500, 500);

      // Convert the image to webp
      $encode = $image->toWebp();

      // Save the image after modifications
      $encode->save($uploadDirectory);

      if ($user) {
        $updateQuery = "UPDATE profilePicture SET path = ? WHERE id = ?";
        $updateParams = array($newImageName, $id);
        $updateStatement = sqlsrv_query($conn, $updateQuery, $updateParams);
      } else {
        $insertQuery = "INSERT INTO profilePicture (ID, path) VALUES (?, ?)";
        $insertParams = array($id, $newImageName);
        $insertStatement = sqlsrv_query($conn, $insertQuery, $insertParams);
      }

      if ($updateStatement === false || $insertStatement === false) {
        echo "<script>alert('Error updating image path in the database');</script>";
      } else {
        // Image uploaded and database updated successfully
        header("Location: ./");
        exit; // Terminate script execution after redirect
      }
    } else {
      echo "<script>alert('Error uploading image');</script>";
    }
  }
}

// Retrieving Gender information from the 'students' table
$genderQuery = sqlsrv_query($conn, "SELECT Gender FROM Faculty WHERE FacultyId = ?", array($sessionId));
$genderInfo = sqlsrv_fetch_array($genderQuery, SQLSRV_FETCH_ASSOC);
$gender = isset($genderInfo['Gender']) ? strtolower($genderInfo['Gender']) : 'unknown'; // Default to 'unknown' if gender info not found

?>
<form class="form profile_form" id="form" action="" enctype="multipart/form-data" method="post">
  <div class="upload">
    <?php
    if ($user && isset($user["path"])) {
      $id = $user["id"];
      $image = $user["path"];
    ?>
      <img class="profile" src="<?php echo $host; ?>/storage/profile/<?php echo $image; ?>">
      <?php } else {
      // Display default image based on gender
      if ($gender === 'male') {
      ?>
        <img class="profile" src="<?php echo $host; ?>/storage/profile/default_male.svg">
      <?php } elseif ($gender === 'female') {
      ?>
        <img class="profile" src="<?php echo $host; ?>/storage/profile/default_female.svg">
      <?php } else {
        // If gender is unknown, display a generic default image
      ?>
        <img class="profile" src="<?php echo $host; ?>/storage/profile/noprofile.jpg">
    <?php }
    } ?>

    <div class="round">
      <input type="hidden" name="id" value="<?php echo $sessionId; ?>">
      <input type="file" name="image" id="image" accept=".jpg, JPG, .jpeg, .png, PNG, .webp" title="300px x 300px">
      <i class="fa-solid fa-camera-rotate" style="color: #fff;" title="300px x 300px"></i>
    </div>
  </div>
</form>

<script type="text/javascript">
  document.getElementById("image").onchange = function() {
    document.getElementById("form").submit();
  };
</script>