 
 // When the document is ready
$(document).ready(() => {
    //setting up month inputs
    const setMonth = () => {
        var d = new Date();
        var currentMonth;
        (d.getMonth() + 1) >= 10 ? 
        currentMonth = (d.getMonth() + 1) :
        currentMonth = "0" + (d.getMonth() + 1);
        $("#month").val(d.getFullYear() + "-" + currentMonth);
        $("#year").val(d.getFullYear());
        // console.log("month set");
    }
    setMonth();

    // setMonth();
    // function setMonth() {
    //     var d = new Date()
    //     var currentMonth
    //     (d.getMonth() + 1) >= 10 ?
    //         currentMonth = (d.getMonth() + 1) :
    //         currentMonth = "0" + (d.getMonth() + 1);
    //     $(".month").val(d.getFullYear() + "-" + currentMonth);
    //     $(".month-all").val(d.getFullYear() + "-" + currentMonth);
    //     $(".cancel-month").val(d.getFullYear() + "-" + currentMonth);
    // }
    //Empty inputs
    const emptyInputs = () => {
        $("#desc").val("");
        $("#budget").val("");
        $("#reason-text").val("");
    }

    //Get function request
    const getRequest = url => {
        return $.ajax({
            url:url,
            type: "get",
            dataType: "json"
        });
    };
    
    // //check for connectivity
    // setInterval(() => {
    //     $.when(getRequest("check").then(response => {}).fail(error => {
    //         $(".connection-check").html("Your may be disconnected from internet");
    //     }))
    // }, 6000);
    
    //setting up commas in budget
    const numberWithCommas = (number)  => {
        var parts = number.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }

    //post function request
    const postActions = (actionUrl, sendData) => {
        return $.ajax({
            url: actionUrl,
            type: "post",
            data: JSON.stringify(sendData),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: "application/json",
            cache: false,
            processData: false,
        });
    }

    //closing modal
    $(document).on("click", ".modal-close", e => {
        emptyInputs();
        $("#request-btn").attr("btn-action", "save").html('<i class="mdi mdi-check"></i> Request');
    })

    // $('#subcategory').datepicker({
    //     minViewMode: 'years',
    //     autoclose: true,
    //         format: 'yyyy-yyyy'
    // });

    // submitting savings
    $('#savings-form').submit(function(e) {
        e.preventDefault();
        var actionUrl = "savings/create";
        
            if($("#save-btn").attr("btn-action") !== "save"){
                actionUrl=`savings/edit/${$("#save-btn").attr("btn-id")}`;
                }
                $('#save-btn').html('Submiting...');
                $("#save-btn").prop('disabled', true);
                $.ajax({
                    url: actionUrl,
                    type: "post",
                    data: new FormData(this),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                .done(response => {
                    $(savings).modal("hide");
                    emptyInputs();
                    $("#save-btn").modal("hide");
                })
                .fail(error => {
                    console.log(error);
                });
        
    });


    


    const fetchSavings = () => {
        var monthData = {"date": ($("#month").val())}
        $.when(postActions("fetch", monthData).done(response => {
            renderSavings(response);
            $(".year-total").html(`${numberWithCommas(response.totalYear)}`);
            $(".expenditure").html(`${numberWithCommas(response.Expenditure)}`);
            $(".amountdue").html(`${numberWithCommas(response.Amountdue)}`);
        }).fail(error => {
            console.log(error);
        }))
    }
    fetchSavings();
   
    
    const renderSavings = savingsData => {
        $(".saving-tbody").html("");
        
        console.log("rendering", savingsData);
        savingsData? savingsData.forEach(saving => {
            var months = new Array(12);
            months[0] = "January";
            months[1] = "February";
            months[2] = "March";
            months[3] = "April";
            months[4] = "May";
            months[5] = "June";
            months[6] = "July";
            months[7] = "August";
            months[8] = "September";
            months[9] = "October";
            months[10] = "November";
            months[11] = "December";

            var d = new Date();
            month_value = d.getMonth();
            year_value = d.getFullYear();
            return $(".saving-tbody").append(`
                 
                <tr>
                    <td class="border-top-0" rowspan="1" scope="col"><span class="font-14">${months[month_value]}</span></td>
                    <td class="border-top-0" rowspan="1" scope="col"><span class="font-14">${year_value}</span></td>
                    <td class="border-top-0" rowspan="1" scope="col"><span class="font-14">${numberWithCommas(saving.monthly_contribution)}</span></td>
                    <td class="border-top-0" scope="col"><span class="font-14">${numberWithCommas(saving.late_payment)}</span></td>
                    <td class="border-top-0" scope="col"><span class="font-14">${numberWithCommas(saving.late_meeting)}</span></td>
                    <td class="border-top-0" scope="col"><span class="font-14">${numberWithCommas(saving.absenteeism)}</span></td>
                    <td class="border-top-0" scope="col"><span class="font-14">${numberWithCommas(saving.marriage)}</span></td>
                    <td class="border-top-0" scope="col"><span class="font-14">${numberWithCommas(saving.birth)}</span></td>
                    <td class="border-top-0" scope="col"><span class="font-14">${numberWithCommas(saving.graduation)}</span></td>
                    <td class="border-top-0" scope="col"><span class="font-14">${numberWithCommas(saving.consecration)}</span></td>
                    <td class="border-top-0" scope="col"><span class="font-14">${numberWithCommas(saving.sickness)}</span></td>
                    <td class="border-top-0" scope="col"><span class="font-14">${numberWithCommas(saving.death)}</span></td>
                    <td class="border-top-0" scope="col"><span class="font-14">${numberWithCommas(saving.loan_liability)}</span></td>
                    <td class="border-top-0" rowspan="1" scope="col"><span class="font-14">${numberWithCommas(saving.total_amount)}</span></td>
                </tr> 
               
            `)
        }):null;
    }

    $('#cate').on('change',function(e) {
        console.log($(this).val());
        const cat_id = $(this).val();
        const sendData = {
                "cate": cat_id
            }

        $.when(getRequest("/members", sendData).done(response => {
            
        }).fail(error => {
            console.log(error);
        }))      
    });
    $('#category, #subcategory').on('change',function(e) {
        console.log($(this).val());
        const cat_id = $(this).val();
        const sendData = {
                "cat_id": cat_id
                
            }

        $.when(postActions("/savings/fetch", sendData).done(response => {
            renderSavings(response);
            $(".year-total").html(`${numberWithCommas(response.totalYear)}`);
            $(".expenditure").html(`${numberWithCommas(response.Expenditure)}`);
            $(".amountdue").html(`${numberWithCommas(response.Amountdue)}`);
        }).fail(error => {
            console.log(error);
        }))      
    });
    $('#subcategory').on('change',function(e) {
        console.log($(this).val());

        $.when(postActions("fetch", {"date": ($(this).val())}).done(response => {
            renderSavings(response.savings);
            $(".year-total").html(`${numberWithCommas(response.totalYear)}`);
            $(".expenditure").html(`${numberWithCommas(response.Expenditure)}`);
            $(".amountdue").html(`${numberWithCommas(response.Amountdue)}`);
        }).fail(error => {
            console.log(error);
        }))
    });

});
