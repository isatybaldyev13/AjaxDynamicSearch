/**
 * Created by Alex on 17/08/2016.
 */
$(document).ready(function () {
    $("#search").on("input",function () {
        $search=$("#search").val();
        if($search.length>0){
            $.post('getResult.php',{"search":$search},function ($data) {
                $("#result").html($data);
            })
        }
    } )
})