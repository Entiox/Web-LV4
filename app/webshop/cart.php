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
      <a href="cart.php"><button disabled>Cart<span class="cart-badge"><?php echo $cart_count; ?></span></button></a>
      <a href="orderinformation.php"><button>Order information</button></button></a>
    </nav>

    <div class="cart-items">
      <?php
        if (empty($_SESSION["shopping_cart"])) {
          echo "<script language='javascript'>";
          echo "alert('Cart is empty.')";
          echo "</script>";
          session_write_close();
          exit;
        }
        foreach ($_SESSION["shopping_cart"] as $key => $item) {
          $total_price = $item["quantity"] * $item["price"];
          echo "<div class=cart-item>";
          echo "<h2>$item[name]</h2>";
          echo "<h3>Total price: $total_price$</h3>";
          echo "<form method='POST'>";
          echo "<div>";
          echo "<input type='number' name=$item[code]-quantity min='1' max='100' value=$item[quantity]>";
          echo "<input type='submit' value='Change quantity' class='add-to-cart-btn' name=$item[code]-change-quantity>";
          echo "</div>";
          echo "<input type='submit' value='Remove' class='add-to-cart-btn' name=$item[code]-remove>";
          echo "</form>";
          echo "</div>";
          if (isset($_POST[$item["code"] . "-remove"])) {
            unset($_SESSION["shopping_cart"][$key]);
            header("Location: cart.php");
          } else if (isset($_POST[$item["code"] . "-quantity"])) {
            if ((int)$_POST[$item["code"] . "-quantity"] !== $item["quantity"]) {
              $_SESSION["shopping_cart"][$key]["quantity"] = (int)$_POST[$item["code"] . "-quantity"];
            }
            header("Location: cart.php");
          }
        }
        session_write_close();
      ?>
    </div>

    <div class="cart-proceed-to-order-info">
      <a href="orderinformation.php"><button>Proceed to order information</button></a>
    </div>
  </body>
</html>