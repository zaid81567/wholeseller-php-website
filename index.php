<?php
  include 'db/conn.php';
?>


<!DOCTYPE html>
<!-- saved from url=(0049)https://getbootstrap.com/docs/4.4/examples/album/ -->
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta
      name="author"
      content="Mark Otto, Jacob Thornton, and Bootstrap contributors"
    />
    <meta name="generator" content="Jekyll v3.8.6" />
    <title>MBG</title>

    <link
      rel="canonical"
      href="https://getbootstrap.com/docs/4.4/examples/album/"
    />

    <!-- Bootstrap core CSS -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />

    <!-- Favicons -->
    <link
      rel="apple-touch-icon"
      href="https://getbootstrap.com/docs/4.4/assets/img/favicons/apple-touch-icon.png"
      sizes="180x180"
    />
    <link
      rel="icon"
      href="https://getbootstrap.com/docs/4.4/assets/img/favicons/favicon-32x32.png"
      sizes="32x32"
      type="image/png"
    />
    <link
      rel="icon"
      href="https://getbootstrap.com/docs/4.4/assets/img/favicons/favicon-16x16.png"
      sizes="16x16"
      type="image/png"
    />
    <link
      rel="manifest"
      href="https://getbootstrap.com/docs/4.4/assets/img/favicons/manifest.json"
    />
    <link
      rel="mask-icon"
      href="https://getbootstrap.com/docs/4.4/assets/img/favicons/safari-pinned-tab.svg"
      color="#563d7c"
    />
    <link
      rel="icon"
      href="https://getbootstrap.com/docs/4.4/assets/img/favicons/favicon.ico"
    />
    <meta
      name="msapplication-config"
      content="/docs/4.4/assets/img/favicons/browserconfig.xml"
    />
    <meta name="theme-color" content="#563d7c" />

    <style>
      img{
          width: 100%;
      }

      .img-container img{
            width: 100%;              
            height: 300px;            
            object-fit: cover;        
            display: block;  
      }

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

  </head>

  <body cz-shortcut-listen="true">
    <header>
      <!-- navbar  -->
      <?php include 'components/_nav.php'; ?>
    </header>

    <main role="main">
      <!-- <section class="container my-4 rounded overflow-hidden">
        <img src=<?php echo $img_src; ?> alt="heropage image">
      </section> -->
      <section class="jumbotron text-center">
        <div class="container">
          <h1>Album example</h1>
          <p class="lead text-muted">
            Something short and leading about the collection belowâits contents,
            the creator, etc. Make it short and sweet, but not too short so
            folks donât simply skip over it entirely.
          </p>
          <p>
            <a
              href="https://getbootstrap.com/docs/4.4/examples/album/#"
              class="btn btn-primary my-2"
              >Main call to action</a
            >
            <a
              href="https://getbootstrap.com/docs/4.4/examples/album/#"
              class="btn btn-secondary my-2"
              >Secondary action</a
            >
          </p>
        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">
          <?php
              $sql = 'SELECT * FROM products p JOIN product_images pi ON p.id = pi.product_id';
              $result = $conn->query($sql);
          ?>
          <div class="<?php echo mysqli_num_rows($result) > 0 ? 'row' : ''; ?>">
            <?php
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $productId = $row['id'];
                  $prodName = $row['prodName'];
                  $price = $row['price'];
                  $img_src = $row['front_image'];
                  $category = $row['category'];

                  echo "
                    <div class='col-md-4'>
                      <div class='card mb-4 shadow-md'>
                        <div class='img-container'>
                          <img src='$img_src' alt='Card image' class='card-img-top'>
                        </div>
                        <div class='card-body'>
                          <div class='d-flex justify-content-between mb-2'>
                            <div class='product-name'>$prodName</div>
                            <div class='price'>&#8377;<strong>$price/piece</strong></div>
                          </div>
                          <div class='d-flex justify-content-between align-items-center'>
                            <div class='input-group mb-3'>
                              <input type='number' name='qauntity' class='form-control' aria-label='Amount (to the nearest dollar)' placeholder='Enter Quantity' pattern='[0-9]*' inputmode='numeric'>
                            <div class='input-group-append'>
                            <input type='hidden' name='product_id' value='$productId'>
                            <button class='btn btn-outline-primary' type='submit' name='addtToCart'>Add to Cart</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              ";
            }
              }else{
                echo "<div class='alert alert-warning' role='alert'>
                  Currently no product to show, try again!
                </div>";
              }
            ?>
          </div>
        </div>
      </div>
    </main>

    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="https://getbootstrap.com/docs/4.4/examples/album/#"
            >Back to top</a
          >
        </p>
        <p>
          Album example is Â© Bootstrap, but please download and customize it
          for yourself!
        </p>
        <p>
          New to Bootstrap?
          <a href="https://getbootstrap.com/">Visit the homepage</a> or read our
          <a
            href="https://getbootstrap.com/docs/4.4/getting-started/introduction/"
            >getting started guide</a
          >.
        </p>
      </div>
    </footer>
    <script
      src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
      integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
      crossorigin="anonymous"
    ></script>
  </body>
  <div id="slickdeals" data-initialized="1"></div>
</html>
