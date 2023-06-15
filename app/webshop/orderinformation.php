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
    ?>
    <nav>
      <a href="products.php"><button>Browse shop</button></a>
      <a href="cart.php"><button>Cart<span class="cart-badge"><?php echo $cart_count; ?></span></button></a>
      <a href="orderinformation.php"><button disabled>Order information</button></button></a>
    </nav>

    <div class="order-information">
      <form method="POST">
        <label for="order-first-name">First name: </label>
        <input type="text" name="order-first-name" id="order-first-name" required>
        <label for="order-last-name">Last name: </label>
        <input type="text" name="order-last-name" id="order-last-name" required>
        <label for="order-address">Address: </label>
        <input type="text" name="order-address" id="order-address" required>
        <input type="submit" name="order-submit" value="Order">
      </form>
      <?php
        if (isset($_POST["order-submit"])) {
          require "db.php";
          if (empty($_SESSION["shopping_cart"])) {
            echo "<script language='javascript'>";
            echo "alert('Cart is empty.')";
            echo "</script>";
            session_write_close();
            exit;
          }
          $conn = get_connection();
          $first_name = $_POST["order-first-name"];
          $last_name = $_POST["order-last-name"];
          $address = $_POST["order-address"];
          foreach ($_SESSION["shopping_cart"] as $key => $item) {
            $product_id = $item["id"];
            $quantity = $item["quantity"];
            mysqli_query($conn, "INSERT INTO orders (product_id, recipient_first_name, recipient_last_name, recipient_address, quantity)
                        VALUES ('$product_id', '$first_name', '$last_name', '$address', $quantity)");
          }
          unset($_SESSION["shopping_cart"]);
          $_SESSION["message"] = "Your order was requested successfully.";
          header("Location: products.php");
        }
        session_write_close();
      ?>
    </div>
  </body>
</html>
