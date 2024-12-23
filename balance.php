<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "company";
$GETTABLE=$_GET["TABLE"];

$conn = new mysqli($servername, $username, $password, $dbname);
$check="select *from $GETTABLE where date=curdate()";
$checked=mysqli_query($conn,$check);

if(mysqli_num_rows($checked)==0)
{

$sql = "SELECT OPNAME, TKNO, EMPNAME FROM $GETTABLE where date=(select MAX(date) from $GETTABLE)";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head> 
<style>
    .notes
    {
        width: 32%;
        height:30%;
        margin-top: 10%;
        margin-left: 35%;
        background-color: rgb(215,46,40);
        border: 2px solid #2c3e50;
        border-radius: 10px;
        box-shadow: 5px 5px 15px rgba(0,0,0,0.2);
        color: whitesmoke;
        align-content: center;
    }      
               input {
     width:300px;
}
       
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-family: Arial, sans-serif;
}


table thead {
    background-color:rgba(0, 105, 175, 0.62);
    color: white;
}


table th {
    padding: 10px;
    text-align: left;
}


table tr:nth-child(even) {
    background-color:rgba(0, 255, 242, 0.1);
}


table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}


table tr:hover {
    background-color: #ddd;
}


table td:first-child {
    font-weight: bold;
}


table {
    margin-top: 20px;
}
input {
        width:80%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
        outline: none;
        transition: border-color 0.3s;
    }

    input:focus {
        border-color: #4CAF50;
    }

    input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        font-size: 1.1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }

    input[type="submit"]:active {
        background-color: #388E3C;
        transform: scale(0.98);
    }
 .button {
            padding: 12px 30px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            width:20%;
            margin-left:40%;
            cursor: pointer; 
 }
.button:hover {
            background-color: #45a049;
} 
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script>
         // Function to update the empname based on tkno
         function updateEmpName(tkno, rowIndex) {
            // Use Fetch API to get empname from PHP script
            console.log(26);
            fetch('getempname.php?tkno=' + tkno)
                .then(response => response.json())
                .then(data => {
                    
                    const empnameCell = document.getElementById('empname-' + rowIndex);
                    empnameCell.value = data.empname;
                    console.log(data.empname);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
</script>

</head>
<body>
    <h1 align="center"> Balance <?php echo $GETTABLE;?></h1>

    <!-- Form to submit data -->
    <form method="POST" action="submit_changes.php?TABLE=<?php echo $GETTABLE;?>">
        <input type="number" name="target" placeholder="Input Target for the line  Here" required>
        <table border="0">
            <thead>
                <tr>
                    <th>OPNAME</th>
                    <th>TKNO</th>
                    <th>EMPNAME</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $i=0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='text' name='OPNAME[]' value='" . $row["OPNAME"] . "' readonly /></td>";
                        echo "<td><input type='text' id='tkno-".$i."' class='tkno-input' onChange='updateEmpName(this.value, ".$i.")' name='TKNO[]' value='" . $row["TKNO"] . "' /></td>";
                        echo "<td><input type='text'id='empname-".$i."' class='empname-input'name='EMPNAME[]' value='" . $row["EMPNAME"] . "'readonly /></td>";
                        echo "</tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='3'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>

     
        <button type="submit"class="button" name="save_changes">Save All Changes</button>
    </form>

</body>
</html>

<?php
    
}
else{
    echo"Date:".date("Y-m-d");
    echo"<div id='note'><p>Already the line has been balanced for today </p></div>";

}
$conn->close();
?>
