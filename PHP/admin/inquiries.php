<?php
    include "header.php";
    include "../../includes/database.inc.php";
    include_once '../../includes/adminSidePanel.inc.php';
?>
<div class="container">
  <h1 style="margin-left: 0;">Inquiries</h1>
  <div class="row row-inq" id="messageGrid">

    <?php
    // Pagination variables
    $results_per_page = 9; // Number of messages to display per page
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start_index = ($current_page - 1) * $results_per_page;

    $sql = "SELECT * FROM inquiries LIMIT $start_index, $results_per_page";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
      $id = $row['inquiryId'];
      $title = $row['subject'];
      $email = $row['email'];
      $senderName = $row['senderName'];
      $content = $row['message'];
      $limitedContent = substr($content, 0, 70);
      $dateTime = new DateTime($row['submission_date']);
      $month = $dateTime->format('m'); // 08
      $day = $dateTime->format('d');   // 03
      $year = $dateTime->format('Y');  // 2023

      // Display the message in a card
      echo "<div class='col-lg-4 col-md-6 col-sm-12'>";
      echo "<div class='card' data-toggle='modal' data-target='#messageModal-" . $id . "'>";
      echo "<div class='card-body'>
              <h5 class='card-title'><b>From:</b> $senderName</h5>
              <h5 class='card-title'><b>Email:</b> $email</h5>
              <h5 class='card-title'><b>Subject:</b> $title</h5>
              <p class='card-title' style='margin-bottom: 0'><b>Content:</b></p>
              <p class='card-text'>$limitedContent...</p>
              <span class='card-text'>Date submitted: $day/$month/$year</span>
            </div>
          </div>
        </div>
      ";

      echo '<div class="modal fade" id="messageModal-' . $id . '" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">';
      echo '<div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="messageModalLabel">Message Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">';
      echo '<p>' . $content . '</p>
            </div>
          </div>
        </div>
      </div>
      ';
    }
    ?>

  </div>
  
  
  <!-- Pagination -->
  <ul class="pagination">
    <?php
    // Calculate the total number of pages
    $sql_count = "SELECT COUNT(*) AS total FROM inquiries;";
    $result_count = mysqli_query($conn, $sql_count);
    if (!$result_count) {
        die("Error: " . mysqli_error($conn)); 
    }    

    $row_count = mysqli_fetch_assoc($result_count);
    $total_pages = ceil($row_count['total'] / $results_per_page);

    // Display pagination links
    for ($i = 1; $i <= $total_pages; $i++) {
      echo "<li class='page-item" . ($i == $current_page ? ' active' : '') . "'>";
      echo "<a class='page-link' href='?page=$i'>$i</a>";
      echo "</li>";
    }
    ?>
  </ul>
</div>


<?php
    include "footer.php";
?>