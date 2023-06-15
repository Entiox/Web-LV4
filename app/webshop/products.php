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
      if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        echo "<script language='javascript'>";
        echo "alert('$message')";
        echo "</script>";
        unset($_SESSION['message']);
      }
      if(!empty($_SESSION["shopping_cart"])) {
        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
      }
      else{
        $cart_count = 0;
      }
    ?>
    <nav>
      <a href="products.php"><button disabled>Browse shop</button></a>
      <a href="cart.php"><button>Cart<span class="cart-badge"><?php echo $cart_count; ?></span></button></a>
      <a href="orderinformation.php"><button>Order information</button></button></a>
    </nav>

    <div class="items-grid">
      <?php
        require "db.php";
        $conn = get_connection();
        $result = mysqli_query($conn, "SELECT * FROM products");
		    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          echo "<div class=item>";
          echo "<img src=$row[image] alt='Missing'>";
          echo "<h2>$row[name]</h2>";
          echo "<h3>$row[price]$</h3>";
          echo "<form method='POST'>";
          echo "<input type='number' name=$row[code]-quantity min='1' max='100' value='1'>";
          echo "<input type='submit' value='Add to cart' class='add-to-cart-btn' name=$row[code]-insert>";
          echo "</form>";
          echo "</div>";
          if(isset($_POST[$row["code"]."-insert"])){
            $itemArray = array(
              $row["code"] =>array(
              'id'=>$row["id"],
              'name'=>$row["name"],
              'code'=>$row["code"],
              'image'=>$row["image"],
              'price'=>$row["price"],
              'quantity'=>(int)($_POST[$row["code"]."-quantity"])),
            );
            if(empty($_SESSION["shopping_cart"])) {
              $_SESSION["shopping_cart"] = $itemArray;
              $_SESSION["message"] = "Product added successfully.";
            }
            else {
              $array_keys = array_keys($_SESSION["shopping_cart"]);
              if(in_array($row["code"],$array_keys)) {
                $_SESSION["message"] = "Product is already inside your cart.";
              } 
              else {
                $_SESSION["shopping_cart"] = array_merge(
                  $_SESSION["shopping_cart"],
                  $itemArray
                );
                $_SESSION["message"] = "Product added successfully.";
              }
            }
            header("Location: products.php");
          }
        }

        mysqli_free_result($result);
        mysqli_close($conn);
        session_write_close();
      ?>
    </div>
  </body>
</html>
