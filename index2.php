<!-- <script> -->

    $(document).ready(function(){
        getTasks();
    });

    function getTasks() {
        var taskList;
        $.ajax({
            url: "server.php",
            type: 'get',
            success: function(data, success) {
                taskList = data;
                $('#tasklist').html(data);
            }
        });
    }
  
    function addTask() {
        var taskname = $('#task-name').val();
        var due_date = $('#due-date').val();
        console.log(taskname, due_date)

        $.ajax({
            url: "server.php",
            type: 'post',
            // dataType:"jsonp" ,
            data: {
                task: taskname,
                duedate: due_date,
            },
            success: function(data, status) {
                $('#addTask').modal("hide");
                getTasks();
            }
        });
    }
    function getTaskDetails(id){
        $('#hiddent-task-id').val(id);

        $.post("server.php",{
            getTaskId: id
        },function(response, status){
            
            <!-- $('#updated-task-name').val(response); -->
            var taskDet= JSON.parse(response);
            $('#updated-task-name').val(taskDet.task);
            $('#updated-due-date').val(taskDet.dueDate);
            $('#hidden-task-id').val(taskDet.id);
        });
        $('#updateTask').modal("show");
    }

    function deleteTask(taskId){
        var conf= confirm("Are you sure to delete the given task? ");
        if(conf){
            $.ajax({
                url: "server.php",
                type: 'post',
                data :{
                    deleteId : taskId
                },
                success: function(data, status) {
                    getTasks();
                }
            });
        }
    }

    function updateTask(){
        var taskId = $('#hidden-task-id').val();
        var taskname = $('#updated-task-name').val();
        var due_date = $('#updated-due-date').val();
            $.ajax({
                url: "server.php",
                type: 'post',
                data :{
                    updateTaskId : taskId ,
                    taskn: taskname,
                    duedate: due_date,
                },
                success: function(data, status) {
                    $('#updateTask').modal("hide");
                    getTasks();
                }
            });
    }

    function markTaskDone(taskId){

            $.ajax({
                url: "server.php",
                type: 'post',
                data :{
                    updateId : taskId
                },
                success: function(data, status) {
                    getTasks();
                }
            });
    
    }
<!-- </script> -->