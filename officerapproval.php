<!-- PHP code to establish connection with the localserver -->
<?php
 
$user = 'root';
$password = '';
$database = 'project2';
$servername='localhost';
$mysqli = new mysqli($servername, $user, $password, $database);
// Checking for connections
if ($mysqli->connect_error) 
{
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}
 
//SQL query to select data from database
$sql = " SELECT * FROM tender ORDER BY tender_id ASC ";
$result = $mysqli->query($sql);
$mysqli->close();

$offId = $_GET["off_id"];

?>

<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"rel="stylesheet"></script>

    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        * {box-sizing: border-box;}

        /* Button used to open the contact form - fixed at the bottom of the page */
        .open-button 
        {
          background-color: #555;
          color: white;
          padding: 16px 20px;
          border: none;
          cursor: pointer;
          opacity: 0.8;
          width: 280px;
        }

        /* The popup form - hidden by default */
        .form-popup 
        {
          display: none;
          position: fixed;
          bottom: 0;
          right: 15px;
          border: 3px solid #f1f1f1;
          z-index: 9;
        }

        /* Add styles to the form container */
        .form-container 
        {
          max-width: 300px;
          padding: 10px;
          background-color: white;
        }

        /* Full-width input fields */
        .form-container input[type=text], .form-container input[type=password] 
        {
          width: 100%;
          padding: 15px;
          margin: 5px 0 22px 0;
          border: none;
          background: #f1f1f1;
        }

        /* When the inputs get focus, do something */
        .form-container input[type=text]:focus, .form-container input[type=password]:focus 
        {
          background-color: #ddd;
          outline: none;
        }

        /* Set a style for the assign button */
        .form-container .btn 
        {
          background-color: #04AA6D;
          color: white;
          padding: 16px 20px;
          border: none;
          cursor: pointer;
          width: 100%;
          margin-bottom:10px;
          opacity: 0.8;
        }

        /* Add a red background color to the cancel button */
        .form-container .cancel 
        {
          background-color: red;
        }

        /* Add some hover effects to buttons */
        .form-container .btn:hover, .open-button:hover 
        {
          opacity: 1;
        }
    </style>
</head>
 
<body><!-- CSS only -->
    <!-- JavaScript Bundle with Popper -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        var tenderId
        $(document).ready(function(){
            var mainTable= $('#myTable').DataTable({
                ajax:{
                    url: 'approvalbackend.php?off_id=<?php echo $offId ?>',
                    responsive:true,
                    dataSrc: 'data',
                }
            });
        })
    
        function openForm(thisProId, thisTenderId) 
        {
            document.getElementById("myForm").style.display = "block";
            document.getElementById("proVal").innerText = thisProId;
            proId = thisProId;
            tenderId = thisTenderId;
        }

        function closeForm() 
        {
            document.getElementById("myForm").style.display = "none";
        }

        function submitForm(){
            document.getElementById('approveTender').action = 'sendapproval.php?pro_id='+proId+'&tender_id='+tenderId+'&off_id=<?php echo $offId ?>';
            document.getElementById('approveTender').submit();
        }
    </script>
    
    <table id="myTable" class="table table-borded table-hover dt-responsive">
        <thead>
            <tr>
                <th>Proposal ID</th>
                <th>Tender Id</th>
                <th>Proposal Price</th>
                <th>Proposal Date</th>
                <th>Supplier Name</th>
                <th>Approval</th>

            </tr>
        </thead>
    </table>

    <div class="form-popup" id="myForm">
        <form id="approveTender" method="POST" class="form-container" onsubmit="submitForm()">
            <h1>Officer Approve Proposal : <p id="proVal"></p> </h1>

            <label for="Officer Approval:"><b>Approval:</b></label>
            <select name="approval" id="approval" required>
                <option value=""></option>
                <option value="0">Approve</option>
                <option value="1">Reject</option>
            </select>

            <button type="submit" class="btn">CONFIRM</button>
            <button type="button" class="btn cancel" onclick="closeForm()">CANCEL</button>
        </form>
    </div>
</body>
</html>