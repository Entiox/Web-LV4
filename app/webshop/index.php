<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Web Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>

  <body>
    <h1>Web Shop</h1>
    <?php
      session_start();
      if (!empty($_SESSION["shopping_cart"])) {
        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
      } else {
        $cart_count = 0;
      }
      session_write_close();
    ?>
    <nav>
      <a href="products.php"><button>Browse shop</button></a>
      <a href="cart.php"><button>Cart<span class="cart-badge"><?php echo $cart_count; ?></span></button></a>
      <a href="orderinformation.php"><button>Order information</button></button></a>
    </nav>

    <div class="info">
      <h3>
        Welcome to the webshop where you can buy fruits. Use buttons above to navigate to different sections of the page.
      </h3>
    </div>
  </body>
</html>
