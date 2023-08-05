
<?php
    include "header.php";
    include_once '../../includes/adminSidePanel.inc.php';
    include_once '../../includes/getEvent.inc.php';
?>
<link rel="stylesheet" href="../../css/eventCalendar.css">
<div class="container">
    <h1 style="position: absolute; margin: 20px 20px 20px 0;">Event Calendar</h1>     
    <div class="content">
        <div class="calendar-container">
          <div class="calendar"> 
            <div class="year-header"> 
              <span class="left-button" id="prev"> &lang; </span> 
              <span class="year" id="label"></span> 
              <span class="right-button" id="next"> &rang; </span>
            </div> 
            <table class="months-table"> 
              <tbody>
                <tr class="months-row">
                  <td class="month">Jan</td> 
                  <td class="month">Feb</td> 
                  <td class="month">Mar</td> 
                  <td class="month">Apr</td> 
                  <td class="month">May</td> 
                  <td class="month">Jun</td> 
                  <td class="month">Jul</td>
                  <td class="month">Aug</td> 
                  <td class="month">Sep</td> 
                  <td class="month">Oct</td>          
                  <td class="month">Nov</td>
                  <td class="month">Dec</td>
                </tr>
              </tbody>
            </table> 
            
            <table class="days-table"> 
              <td class="day">Sun</td> 
              <td class="day">Mon</td> 
              <td class="day">Tue</td> 
              <td class="day">Wed</td> 
              <td class="day">Thu</td> 
              <td class="day">Fri</td> 
              <td class="day">Sat</td>
            </table> 
            <div class="frame"> 
              <table class="dates-table"> 
                  <tbody class="tbody">             
                  </tbody> 
              </table>
            </div> 
          </div>
        </div>
        <div class="events-container">
        </div>
        <div class="dialog" id="dialog">
            <h2 class="dialog-header"> Add New Event </h2>
            <form class="form" id="form">
              <div class="form-container" align="center">
                <label class="form-label" id="valueFromMyButton" for="name">Event name</label>
                <input class="input" type="text" id="name" maxlength="36">
                <label class="form-label" id="valueFromMyButton" for="count">Number of people to invite</label>
                <input class="input" type="number" id="count" min="0" max="1000000" maxlength="7">
                <input type="button" value="Cancel" class="button" id="cancel-button">
                <input type="button" value="OK" class="button" id="ok-button">
              </div>
            </form>
          </div>
      </div>
</div>

<?php     
    include "footer.php";
?>
<script>
    var event_data = <?php echo json_encode($dataArray); ?>;
  </script>
