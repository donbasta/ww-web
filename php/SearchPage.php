<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="../styles/search-page.css">
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a class="active" href="dashboard.php">Home</a></li>
            <?php 
                $check_role = include('checkRole.php');
                $getUsername = include('getusername.php');
                $current_role = $check_role($_COOKIE["currentUsername"]);
                $username = $getUsername($_COOKIE['currentUsername']);

                if (strcmp($current_role, 'superuser') == 0) {
                    echo "<li><a href='tambah-coklat.php'>Add Coklat</a></li>";
                } else if (strcmp($current_role, 'user') == 0) {
                    echo "<li><a href='lihattransaksi.php?username=<?php echo $username ?>'>History</a></li>";
                }
            ?>
            <li class="logout-link"><a href="logout.php">Logout</a></li>
            <li class="search-bar">
              <form method="get" action="SearchPage.php">
                  <input type="text" name="search" id="search" autocomplete="off" placeholder="Search">
              </form>
            </li>
        </ul>
    </div>

    <br>
    <br>
    <br>

    <h1>
        <?php 
            $search = $_GET["search"];
            echo "<h1 style='margin-left:30px;'> Search result for query: " . $search . "</h1>";
        ?>
    </h1>

    
      <?php 

        include 'connectDB.php';

        $content_per_page = 3;
        $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
        $start = ($page>1) ? ($page * $content_per_page) - $content_per_page : 0;

        $sql = "SELECT * FROM coklat WHERE choco_name LIKE '%$search%'";
        $result = mysqli_query($conn, $sql);
        $total_row = mysqli_num_rows($result);

        $total_page = ceil($total_row / $content_per_page);

        $sql2 = "SELECT * FROM coklat WHERE choco_name LIKE '%$search%' LIMIT $start, $content_per_page";
        $result2 = mysqli_query($conn, $sql2);

        if ($total_row == 0) {
            echo "<i style='margin-left:30px;'> No result found for keyword " . $search . " </i>";
        } else {

            echo "<i style='margin-left:30px;'> Found " . $total_row . " results for keyword " . $search . " </i>";

            while ($row = mysqli_fetch_assoc($result2)) {
                $full_img_path = "../" . $row["imgpath"];

                echo "<a href='ChocoDetailUser.php?id=" . $row["idcoklat"] . "' style='color:black; text-decoration:none;'>";
                echo "<div class='choco-board'>";

                echo "<div>";
                echo "<img src='". $full_img_path ."'>";
                echo "</div>";

                echo "<div class='choco-details'>";
                echo "<ul>";
                echo "<li class='name'>".$row["choco_name"]."</li>";
                echo "<li> <span class='title'>Harga </span>".$row["price"]."</li>";
                echo "<li> <span class='title'>Jumlah Stok Tersedia </span>".$row["amount"]."</li>";
                echo "<li> <span class='title'>Jumlah Stok Terjual </span>".$row["amountsold"]."</li>";
                echo "<li> <span class='title'>Deskripsi </span>".$row["description"]."</li>";
                echo "</ul>";
                echo "<div class='btn'>";
                echo "Lihat";
                echo "</div>";
                echo "</div>";

                echo "</div>";

                echo "</a>";   
            }
        }        
    ?>
<br>
<center> <div>
    <?php 
        $current_page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;

        echo "<div class='pagination'>";
        echo "<ul>";

        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            echo "<div class='search-page'>";
            echo "<li><a href='?search=$search&page=$prev_page'> &larr; </a></li>";
            echo "</div>";
        }

        for($i=1; $i<=$total_page; $i++) {
            echo "<div class='search-page'>";
            echo "<li><a href='?search=$search&page=$i'>".$i."</a></li>";
            echo "</div>";
        }

        if ($current_page < $total_page) {
            $next_page = $current_page + 1;
            echo "<div class='search-page'>";
            echo "<li><a href='?search=$search&page=$next_page'> &rarr; </a></li>";
            echo "</div>";
        }

        echo "</ul>";
        echo "</div>";
    ?>
</div> </center>


</body>
</html>