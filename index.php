 <?php
    // Connecting to DB

    $severname = "localhost";
    $username = "root";
    $password = "";
    $database = "crud";

    $insert = false;
    $update = false;
    $delete = false;
    // Create a connection
    $conn = mysqli_connect($severname, $username, $password, $database);

    if (!$conn) {
        die("Sorry we failed to connect: " . mysqli_connect_error());
    }
    if(isset($_GET['delete'])) {
        $sno = $_GET["delete"];
        $delete = true;
        $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
        $result = mysqli_query($conn, $sql);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['snoEdit'])) {
            $title = $_POST["titleEdit"];
            $description = $_POST["descriptionEdit"];
            $sno = $_POST["snoEdit"];

            $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $update = true;
            } else {
                $update = false;
            }
        } else {

            $title = $_POST['title'];
            $description = $_POST['description'];

            $sql = "INSERT INTO `notes`(`title`, `description`) VALUES ('$title', '$description')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $insert = true;
            } else {
                $insert = false;
            }
        }
    }


    ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <title>I-Notes Notes made easy.</title>
     <style>
         .form {
             margin-left: 50vw;
         }

         .form>button {
             margin-left: 5px;
         }
     </style>
     <!-- <link rel="stylesheet" href="style.css"> -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
     <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
     <link rel="shortcut icon" href="rock.png" type="image/x-icon">
 </head>

 <body>
     <!-- Button trigger modal -->
     <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button> -->

     <!-- Modal -->
     <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Edit Note
                     </h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <form action="/crud/index.php" method="POST" class="my-3">
                         <input type="hidden" name="snoEdit" id="snoEdit">
                         <div class="mb-3">
                             <label for="title" class="form-label">Note Title</label>
                             <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp" />
                         </div>
                         <div class="mb-3">
                             <label for="description" class="form-label">Note Description</label>
                             <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                         </div>
                         <button type="submit" class="btn btn-primary">Update Note</button>
                     </form>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 </div>
             </div>
         </div>
     </div>

     <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <div class="container-fluid">
             <a class="navbar-brand" href="#">I-Notes</a>
             <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
             </button>
             <div class="collapse navbar-collapse" id="navbarSupportedContent">
                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                     <li class="nav-item">
                         <a class="nav-link active" aria-current="page" href="#">Home</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link active" aria-current="page" href="#">About</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link active" aria-current="page" href="#">Contact</a>
                     </li>
                 </ul>
                 <form class="d-flex form">
                     <input class="form-control me-2 mx-40" type="search" placeholder="Search" aria-label="Search" />
                     <button class="btn btn-outline-warning" type="submit">
                         Search
                     </button>
                 </form>
             </div>
         </div>
     </nav>
     <?php
        if ($insert === true) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your note has been inserted successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
        if ($update === true) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
     <strong>Success!</strong> Your note has been updated successfully!
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
        }
        if ($delete === true) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
     <strong>Success!</strong> Your note has been deleted successfully!
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
        }
        ?>

     <div class="container my-3">
         <h2>Add A note!</h2>
         <form action="/crud/index.php?update=true" method="POST" class="my-3">
             <div class="mb-3">
                 <label for="title" class="form-label">Note Title</label>
                 <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" required>
             </div>
             <div class="mb-3">
                 <label for="description" class="form-label">Note Description</label>
                 <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
             </div>
             <button type="submit" class="btn btn-primary">Add Note</button>
         </form>
     </div>
     <div class="container my-4">

         <table class="table" id="myTable">
             <thead>
                 <tr>
                     <th scope="col">S.NO</th>
                     <th scope="col">Title</th>
                     <th scope="col">Description</th>
                     <th scope="col">Actions</th>
                 </tr>
             </thead>
             <tbody>
                 <?php
                    $sql = "SELECT * FROM `notes`";
                    $result = mysqli_query($conn, $sql);
                    $sno = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sno = $sno + 1;
                        echo "<tr>
            <th scope='row'>" . $sno . "</th>
            <td>" . $row['title'] . "</td>
            <td>" . $row['description'] . "</td>
            <td> <button data-bs-toggle='modal' data-bs-target='#exampleModal' class='edit btn btn-primary' id=" . $row['sno'] . ">Edit</button> <button class='delete btn btn-danger' id=d" . $row['sno'] . ">Delete</button>  </td>
          </tr>";
                    }
                    ?>
             </tbody>
         </table>
         <hr>
     </div>
     <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
     <script src="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"></script>
     <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
     <script>
         $(document).ready(function() {
             $('#myTable').DataTable();
         });
     </script>
     <script>
         edits = document.getElementsByClassName('edit');
         Array.from(edits).forEach((element) => {
             element.addEventListener("click", (e) => {
                 console.log("edit ");
                 tr = e.target.parentNode.parentNode;
                 title = tr.getElementsByTagName("td")[0].innerText;
                 description = tr.getElementsByTagName("td")[1].innerText;
                 console.log(title, description);
                 titleEdit.value = title;
                 descriptionEdit.value = description;
                 snoEdit.value = e.target.id;
                 console.log(e.target.id)
                 $('#editModal').modal('toggle');
             })
         })

         deletes = document.getElementsByClassName('delete');
         Array.from(deletes).forEach((element) => {
             element.addEventListener("click", (e) => {
                 console.log("edit ");
                 tr = e.target.parentNode.parentNode;
                 title = tr.getElementsByTagName("td")[0].innerText;
                 description = tr.getElementsByTagName("td")[1].innerText;
                 var sno = e.target.id.substr(1,)

                 if (confirm("Are you sure you want to delete this note!")) {
                     console.log("yes");
                     window.location = `/crud/index.php?delete=${sno}`

                 } else {
                     console.log("no");
                 }
             })
         })
     </script>
 </body>

 </html>