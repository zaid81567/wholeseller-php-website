<?php
  include 'db/conn.php';
  function getFilePath($image, $imgOf){
    $imgName = $image['name'];
    $imgTmpName = $image['tmp_name'];
    $imgSize = $image['size'];
    $imgError = $image['error'];
    $imgExtension = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpeg', 'jpg', 'png'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB LIMIT

    // Check for file extension validation
    if (!in_array($imgExtension, $allowedExtensions)) {
        return ['error' => "Invalid file type. Only JPEG and PNG files are allowed."];
    }

    // Check for basic file upload errors
    if ($imgError !== 0) {
        return ['error' => "Error occurred during file upload."];
    }

    // Check for file size limit
    if ($imgSize > $maxFileSize) {
        return ['error' => "Image size exceeds 5MB limit."];
    }

    // Generate a unique file name and set destination path
    $newImgName = uniqid()."_".$imgOf.".".$imgExtension;
    $imgDestination = "uploads/$newImgName";

    // Move the uploaded file
    if (move_uploaded_file($imgTmpName, $imgDestination)) {
        return ['path' => $imgDestination]; // Return the path if the upload succeeds
    } else {
        return ['error' => "Failed to move the uploaded file."];
    }
}

  // Handle Add Request 
  if (isset($_POST['submit'])) {
    $prodName = $_POST['prodName'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Validate product data before proceeding...
    
    // Insert product details into `products` table
    $sql = "INSERT INTO products (prodName, price, category) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sds", $prodName, $price, $category); // Binding the parameters
    if ($stmt->execute()) {
        // Get the ID of the inserted product
        $product_id = $conn->insert_id;

        // Handle image uploads and get file paths
        $frontImg = $_FILES['frontImg'];
        $backImg = $_FILES['backImg'];

        $frontImgResult = getFilePath($frontImg, "front");
        $backImgResult = getFilePath($backImg, "back");

        if (!isset($frontImgResult['error']) && !isset($backImgResult['error'])) {
            // Insert image paths into `product_images` table
            $sql = "INSERT INTO product_images (product_id, front_image, back_image) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $product_id, $frontImgResult['path'], $backImgResult['path']);
            $stmt->execute();

            echo "Product and images added successfully!";
        } else {
            // Handle image upload errors
            echo "Error uploading images.";
        }
    } else {
        echo "Error adding product.";
    }
  }
    ?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Add Product</title>
  </head>
  <body>
    <?php include 'components/_nav.php';  ?>

    <div class="container my-4">
        <form method="POST" action="/azhar/add.php" enctype="multipart/form-data">
          <div class="form-group">
              <label for="prodName">Enter Product Name</label>
              <input type="text" class="form-control" id="prodName" name="prodName" placeholder="Enter product name" >
          </div>
          <div class="form-group">
              <label for="price">Price without GST</label>
              <input type="text" class="form-control" id="price" name="price" placeholder="Enter product price" >
          </div>
          <p>Upload Images</p>
          <div class="form-group d-flex justify-content-around">
              <div>
                  <label for="frontImg">Front Image</label>
                  <input type="file" class="form-control-file" id="frontImg" name="frontImg" accept="image/*"  >
              </div>
              <div>
                  <label for="backImg">Backpack Image</label>
                  <input type="file" class="form-control-file" id="backImg" name="backImg" accept="image/*"  >
              </div>
          </div>
          <div class="form-group">
              <label for="category">Enter Product Catagory</label>
              <select class="form-control" name="category" id="category"  >
                  <option value="">Select a category</option>
                  <option>Kids bag</option>
                  <option>Luggage bag</option>
                  <option>Leather bag</option>
                  <option>Trolly bag</option>
                  <option>Laptop bag</option>
                  <option>Duffle bag</option>
              </select>
          </div>

          <button type="submit" name="submit" class="btn btn-primary w-100">Add Product</button>
      </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>