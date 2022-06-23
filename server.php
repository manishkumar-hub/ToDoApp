<?php
$dbName = 'todolist';
$conn = mysqli_connect('localhost', 'root', '', $dbName);
extract($_POST);

if (isset($_POST['task']) && isset($_POST['duedate'])) {
  $query = "INSERT INTO `task`(`task`, `dueDate`) VALUES ('$task','$duedate')";
  mysqli_query($conn, $query);
}


if (isset($_GET)&&!isset($_POST['getTaskId'])) {
  $query = "SELECT * FROM `task` ";
  $data = '<table  class="table table-striped table-hover">
   <thead>
       <tr>
           <th scope="col">S.No</th>
           <th scope="col">Task</th>
           <th scope="col">Due Date</th>
           <th scope="col">Status</th>
           <th scope="col"></th>
       </tr>
   </thead>
   <tbody>
  ';
  $num = 1;
  $res = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_array($res)) {
    $data .= '<tr></tr> <th scope="row">' . $num . '</th>
     <td>' . $row['task'] . '</td>
     <td>' .date('D',strtotime($row['dueDate'])).' ,'. date("d-m-Y", strtotime($row['dueDate']))  . '</td>
     <td>' . $row['status'] . '</td>
     <td> <button class="btn btn-primary"  onClick="markTaskDone(' . $row['id'] . ')"  > <i class="fa-solid fa-xl fa-circle-check"></i> </button>&nbsp; <button onClick="getTaskDetails('.$row['id'] . ')" data-bs-toggle="modal" data-bs-target="#updateTask"class="btn  btn-success"> <i  class="fa-solid  fa-xl fa-pen-to-square"></i> </button> &nbsp;  <button class="btn btn-danger"  onClick="deleteTask(' . $row['id'] . ')"> <i class="fa-solid fa-xl fa-trash"></i> </button>  </td></tr>';
    $num = $num + 1;
  }
  $data .= '     
   </tbody>
</table>';
  echo $data;
}

if (isset($_POST['getTaskId'])) {
  $taskId = $_POST['getTaskId'];
  $query = "SELECT * FROM `task` WHERE id='$taskId' ";
  if(!$result=mysqli_query($conn, $query))
  {
      // exit(mysqli_error());
      echo "error in data";
  }
  $response= array();
  while ($row=mysqli_fetch_assoc($result)) {
    $response= $row ;
  }
  echo json_encode($response);
}

if (isset($_POST['deleteId'])) {
  $taskId = $_POST['deleteId'];
  $query = "DELETE FROM `task` WHERE id=$taskId ";
  mysqli_query($conn, $query);
}


if (isset($_POST['updateId'])) {
  $taskId = $_POST['updateId'];
  $query = "UPDATE `task` SET `status`='Done'  WHERE id=$taskId ";
  mysqli_query($conn, $query);
}

if (isset($_POST['updateTaskId'])) {
  $taskId = $_POST['updateTaskId'];
  $taskName= $_POST['taskn']; 
  $duedate= $_POST['duedate'] ;
  $query = "UPDATE `task` SET `task`='$taskName' , `dueDate`='$duedate'  WHERE id=$taskId ";
  mysqli_query($conn, $query);
}
