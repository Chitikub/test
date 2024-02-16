<?php
require 'connect.php';
$sql = "select * from queqe";
$stmt = $conn->prepare($sql);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style type="text/css">
        img {
            transition: transform 0.25s ease;
        }

        img:hover {
            -webkit-transform: scale(1.5);
            transform: scale(1.5);
        }
    </style>


</head>


<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4"> <br>
                <h3>ฟอร์มเพิ่มข้อมูลคิว</h3>
                <br><br>

                <form action="AddQueue.php" method="POST">
                    <input type="date" placeholder="วันที่" name="qDate" class="form-control" required>
                    <br>
                    <input type="number" placeholder="หมายเลขคิว" name="qNumber" class="form-control" required>
                    <br>
                    <input type="text" placeholder="รหัสบัตรประชาชน" class="form-control" name="Pid">
                    <br>
                    <input type="submit" value="Submit" name="submit" class="btn btn-primary" />
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#queqeTable').DataTable();
        });
    </script>



</body>

</html>


<?php
try {
    if (isset($_POST['Pid']) && isset($_POST['Pid'])) :

        require 'connect.php';
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "insert into queqe values(:qDate, qNumber, :Pid)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':qDate', $_POST['qDate']);
        $stmt->bindParam(':qNumber', $_POST['qNumber']);
        $stmt->bindParam(':Pid', $_POST['Pid']);

        try {
            if ($stmt->execute()) :
                $message = 'Successfully add new Food';
                echo '
                        <script type="text/javascript">        
                        $(document).ready(function(){
                    
                            swal({
                                title: "Success!",
                                text: "Successfuly add Food",
                                type: "success",
                                timer: 2500,
                                showConfirmButton: false
                            }, function(){
                                    window.location.href = "index.php";
                            });
                        });                    
                        </script>
                    ';
            else :
                $message = 'Fail to add new Food';
            endif;
            // echo $message;
        } catch (PDOException $e) {
            echo 'Fail! ' . $e;
        }
        $conn = null;

?>
<?php
        if ($stmt->execute()) :
            $message = 'Suscessfully add new Food';
        else :

            $message = 'Fail to add new Food';
        endif;
        echo $message;

        $conn = null;
    endif;
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>