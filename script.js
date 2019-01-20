$(function(){


    // airport validation
    var airAirCode=false;
    var airAirName=false;





    $("#airCode").focusout(function(){
        
        var airCode_Length=$("#airCode").val().length;
        if(airCode_Length < 1 || airCode_Length > 6){
            $("#errorAirCode").removeClass("d-none");
            $("#airCode").addClass("is-invalid");
        }else{
            $("#errorAirCode").addClass("d-none");
            $("#airCode").removeClass("is-invalid");
            airAirCode=true;
        }

    });

    $("#airName").focusout(function(){
        
        var airName_Length=$("#airName").val().length;
        if((airName_Length < 1 || airName_Length > 255)){
            $("#errorAirName").removeClass("d-none");
            $("#airName").addClass("is-invalid");
        }else{
            $("#errorAirName").addClass("d-none");
            $("#airName").removeClass("is-invalid");
            airAirName=true;
        }

    });

    $("#airSubmit").click(function(){
        $("#airSubmit").removeClass("btn-primary");
        if(airAirCode==true && airAirName==true){
            $("#airSubmit").addClass("btn-success");
            alert("Record Added!");
        }else{
            $("#airSubmit").addClass("btn-danger");
        }

    });
    // airport validation ends here

    // flight validation starts
    var from_Airport=false;
    var to_Airport=false;
    var flnumber=false;
    var time=false;



    $("#fromAirId").focusout(function(){
        
        var from_air_Length=$("#fromAirId").val().length;
        if((from_air_Length < 1 || from_air_Length > 4)){
            $("#error_fl_from_air").removeClass("d-none");
            $("#fromAirId").addClass("is-invalid");
        }else{
            $("#error_fl_from_air").addClass("d-none");
            $("#fromAirId").removeClass("is-invalid");
            from_Airport=true;
        }

    });


    $("#toAirId").focusout(function(){
        
        var to_air_Length=$("#toAirId").val().length;
        if((to_air_Length < 1 || to_air_Length > 4)){
            $("#error_fl_to_air").removeClass("d-none");
            $("#toAirId").addClass("is-invalid");
        }else{
            $("#error_fl_to_air").addClass("d-none");
            $("#toAirId").removeClass("is-invalid");
            to_Airport=true;
        }

    });


    $("#flightNumber").focusout(function(){
        
        var fl_number_Length=$("#flightNumber").val().length;
        if((fl_number_Length < 1 || fl_number_Length > 10)){
            $("#error_fl_number").removeClass("d-none");
            $("#flightNumber").addClass("is-invalid");
        }else{
            $("#error_fl_number").addClass("d-none");
            $("#flightNumber").removeClass("is-invalid");
            flnumber=true;
        }

    });


    $("#departTime").focusout(function(){
        
        checkTime();

    });

    $("#arrTime").focusout(function(){
        
        checkTime();

    });

    function checkTime(){
        var depart=$("#departTime").val();
        var arr=$("#arrTime").val();
        if(depart==arr){
            $("#error_fl_arrival").removeClass("d-none");
            $("#arrTime").addClass("is-invalid");
        }else{
            $("#error_fl_arrival").addClass("d-none");
            $("#arrTime").removeClass("is-invalid");
            time=true;
        }
    }


    $("#flightSubmit").click(function(){
        $("#flightSubmit").removeClass("btn-primary");
        if(from_Airport==true && to_Airport==true && flnumber==true && time==true){
            $("#flightSubmit").addClass("btn-success");
            alert("Record Added!")
        }else{
            $("#flightSubmit").addClass("btn-danger");
        }

    });


    });
