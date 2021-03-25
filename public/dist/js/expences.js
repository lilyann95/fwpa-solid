$(document).ready(() => {
    //setting up month inputs
    const setMonth = () => {
        var d = new Date();
        var currentMonth;
        (d.getMonth() + 1) >= 10 ? 
        currentMonth = (d.getMonth() + 1) :
        currentMonth = "0" + (d.getMonth() + 1);
        $("#month").val(d.getFullYear() + "-" + currentMonth);
        console.log("month set");
    }
    setMonth();
    // mine savings.js
    // $(document).on("click", ".deposits", function(e) {
    //     e.preventDefault();
    //     console.log($(this).val());
    //     const cat_id = $(this).val();
    //     const sendData = {
    //             "cat_id": cat_id
    //         }

    //     $.when(postActions("/expected_deposits/fetch", sendData).done(response => {
    //         renderSavings(response);
    //     }).fail(error => {
    //         console.log(error);
    //     }))      
    // });

    // const fetchDeposits = () => {
    //     var monthData = {"date": ($("#year").val())}
    //     $.when(postActions("fetch", monthData).done(response => {
    //         renderdeposits(response);
    //     }).fail(error => {
    //         console.log(error);
    //     }))
    // }
    // fetchDeposits();
    // const renderdeposits = depositsData => {
    //     $(".all-tbody").html("");
    //     console.log("rendering", depositsData);
    //     depositsData? depositsData.forEach(deposit => {
    //         return $(".all-tbody").append(`
    //             <tr>
    //                 <th class="border-top-0" scope="col">${deposit.user_id}</th>
    //                 <th class="border-top-0" scope="col">${deposit.name}</th>
    //                 <th class="border-top-0" scope="col">${numberWithCommas(deposit.total_amount)}</th>
    //                 <th class="border-top-0" scope="col">${numberWithCommas(deposit.Expected_savings)}</th>
    //                 <th class="border-top-0" scope="col">${numberWithCommas(deposit.Arrears)}</th>
    //                 <th class="border-top-0" scope="col">${numberWithCommas(deposit.loan_offered)}</th>
    //                 <th class="border-top-0" scope="col">${numberWithCommas(deposit.months_taken)}</th>
    //                 <th class="border-top-0" scope="col">${numberWithCommas(deposit.loan_return)}</th>
    //                 <th class="border-top-0" scope="col">${numberWithCommas(deposit.last_paymentdate)}</th>
    //             </tr>
    //         `)
    //     }):null;
    // }


    

    //Empty inputs
    const emptyInputs = () => {
        $("#desc").val("");
        $("#budget").val("");
        $("#reason-text").val("");
    }

    // $('.top-right').notify({
        //     message: { text: "Hello its working" }
        // }).show();

    
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
    $('#pdf-year').datepicker({
        minViewMode: 'years',
        autoclose: true,
            format: 'yyyy'
    });

    $('#expense-form').submit(function(e) {
        e.preventDefault();
        var actionUrl = "expense";
        if($("#request-btn").attr("btn-action") !== "save"){
            actionUrl=`expenses/edit/${$("#request-btn").attr("btn-id")}`;
        }
        $('#request-btn').html('Submiting...');
        $("#request-btn").prop('disabled', true);
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
            fetchExpenses();
            $(expenses).modal("hide");
            emptyInputs();
            $('#request-btn').html('<i class="mdi mdi-check"></i> Request').attr("btn-action", "save");
            $("#request-btn").prop('disabled', false);
        })
        .fail(error => {
            console.log(error);
        });
    });
    
    const fetchExpenses = () => {
        var monthData = {"date": ($("#month").val())}
        $.when(postActions("expenses/fetch", monthData).done(response => {
            renderExpenses(response);
        }).fail(error => {
            console.log(error);
        }))
    }
    fetchExpenses();
    $(".fetchExp").change(function() {
        $.when(postActions("expenses/fetch", {"date": ($(this).val())}).done(response => {
            renderExpenses(response);
        }).fail(error => {
            console.log(error);
        }))
    });
    
    const renderExpenses = expensesData => {
        $(".expenses-tbody").html("");
        expensesData.forEach(expense => {
            var spanClass;
            switch (expense.status) 
            {
                case 'pending':
                    spanClass = "label label-rounded label-primary"
                    break;
                case 'approved':
                    spanClass = "label label-rounded label-success"
                    break;
                case 'declined':
                    spanClass = "label label-rounded label-danger" 
                    break; 
                case 'recommend':
                    spanClass = "label label-rounded label-warning" 
                    break;                                   
                default:
                    break;
            }
            return $(".expenses-tbody").append(`
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <h4 class="m-b-0 font-14">
                                            ${expense.desc}
                                            ${(expense.status === "declined") ? '<br><strong class="text-muted" style="font-size: 12px;">Reason:</strong><br><I class="text-muted" style="font-size: 12px;">'+expense.reason+'<I/>': ' '}
                                        </h4>
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-14">${numberWithCommas(expense.budget)}</span></td>
                            <td><span class="font-14">${expense.name}</span></td>
                            <td><span class="font-14">${expense.created_at}</span></td>
                            <td><span class="${spanClass}">${expense.status}</span></td>
                            <td>
                                <span class="action-icons">
                                    ${(expense.status === 'pending') ? '<a href="#" class="edit-icon" disabled id-data="'+expense.id+'" budget-data="'+expense.budget+'" desc-data="'+expense.desc+'"><i class="ti-pencil-alt"></i></a> | ': '__'}
                                    ${(expense.status === 'pending') ? '<a href="#" class="delete-icon" id-data="'+expense.id+'"><i class="fa fa-trash color-danger" aria-hidden="true"></i></a> | ': ' '}
                                </span>
                            </td>
                        </tr>
                    `)
        });
    }
    $(document).on("click", ".edit-icon", function(e) {
        e.preventDefault();
        $("#budget").val($(this).attr("budget-data"));
        $("#desc").val($(this).attr("desc-data"));
        $("#request-btn").attr("btn-action", "edit").html('<i class="fa fa-save"></i> Save Changes').attr("btn-id", $(this).attr('id-data'));
        $("#expenses").modal("show");
    });

    $(document).on("click", ".delete-icon", function(e) {
        e.preventDefault();
        var deleteExp = {"id": $(this).attr("id-data")}
        $.when(postActions("expenses/delete", deleteExp).done(response => {
            fetchExpenses();
        }).fail(error => {
            console.log(error);
        }));
    });

    $(document).on("click", ".recommend-icon", function(e) {
        e.preventDefault();
        var recomExp = {
            "id": $(this).attr("id-data"),
            "action": "recommend",
            "reason": "not cancelled",
            "reasoner": $("reason-text").attr("user")
            }
        $.when(postActions("actions", recomExp).done(response => {
            fetchPendingExp();
        }).fail(error => {
            console.log(error);
        }))
    });
    
    $(document).on("click", ".recommend-again", function(e) {
        e.preventDefault();
        $("#reason-text").attr("exp-id", $(this).attr("id-data"));
        $("#reason-text").attr("user", "rerecommend");
        $("#reasonTitle").html("Reason for recommending the expense again")
        $(".decliner").html('<i class="ti-check color-success"></i> Re-recommend');
        $("#reason").modal("show");
    })
    
    $(document).on("click", ".decline-icon", function(e) {
        e.preventDefault();
        $("#reason-text").attr("exp-id", $(this).attr("id-data"));
        $("#reasonTitle").html("Reason for declining expense")
        $(".decliner").html('<i class="mdi mdi-block-helper"></i> Decline');
        $("#reason").modal("show");
    });
    
    $(document).on("click", ".decline-admin", function(e){
        e.preventDefault();
        $("#reason-text").attr("exp-id", $(this).attr("id-data"));
        $("#reason-text").attr("user", "chairman");
        $("#reason").modal("show");
    })
    
    //submitting reason
    $('#reason').submit(function(e) {
        e.preventDefault();
        var status = "declined";
        switch ($("#reason-text").attr("user")) 
            {
                case 'chairman':
                    status = "pending"
                    break;
                case 'rerecommend':
                    status = "recommend"
                    break;                                   
                default:
                    break;
            }
        var actionExp = {
            "id": $("#reason-text").attr("exp-id"),
            "action": status,
            "reason": $("#reason-text").val()
        }
        $.when(postActions("actions", actionExp).done(response => {
            fetchPendingExp();
            fetchRecoExp();
            $("#reason-text").val(" ");
            $("#reason").modal("hide");
        }).fail(error => {
            console.log(error);
        }))
    })
    
    $(document).on("click", ".approve-icon", function(e) {
        e.preventDefault();
        var acceptExp = {
            "id": $(this).attr("id-data"),
            "action": "approved",
            "reason": "not cancelled",
            "reasoner": $("reason-text").attr("user")
            }
        $.when(postActions("actions", acceptExp).done(response => {
            fetchRecoExp();
        }).fail(error => {
            console.log(error);
        }))
    });
    
    const fetchPendingExp = () => {
        var monthData = {"date": ($("#month").val())}
        $.when(postActions("fetch/pending", monthData).done(response => {
            renderPendingExp(response);
        }).fail(error => {
            console.log(error);
        }))
    }
    fetchPendingExp();
    const renderPendingExp = expensesData => {
        $(".pending-tbody").html("");
        expensesData.forEach(expense => {
            return $(".pending-tbody").append(`
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <h4 class="m-b-0 font-14">
                                            ${expense.desc}
                                            ${(expense.status === "pending")&&(expense.reason !== "not cancelled")? 
                                                '<br><strong class="text-muted" style="font-size: 12px;">Chairman Reason:</strong><br><I class="text-muted" style="font-size: 12px;">'+expense.reason+'<I/>': ' '}
                                        </h4>
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-14">${numberWithCommas(expense.budget)}</span></td>
                            <td><span class="font-14">${expense.name}</span></td>
                            <td><span class="font-14">${expense.created_at}</span></td>
                            <td>
                                ${(expense.status === "pending")&&(expense.reason !== "not cancelled")? 
                                '<span class="label label-rounded label-danger">Declined</span>':
                                '<span class="label label-rounded label-primary">'+expense.status+'</span>'}
                            </td>
                            <td>
                                <span class="action-icons">
                                    ${(expense.status === "pending")&&(expense.reason !== "not cancelled") ? 
                                    '<a style="color: #00ff9f" href="#" class="recommend-again" id-data="'+expense.id+'"><i class="ti-heart"></i></a>' : 
                                    '<a style="color: #00ff9f" href="#" class="recommend-icon" id-data="'+expense.id+'"><i class="ti-heart"></i></a>'} | 
                                    <a style="color: #e86060;" href="#" class="decline-icon" id-data="${expense.id}"><i class="mdi mdi-block-helper"></i></a>
                                </span>
                            </td>
                        </tr>
                    `)
        });
    }
    $(".pendingExp").change(function() {
        $.when(postActions("fetch/pending", {"date": ($(this).val())}).done(response => {
            renderPendingExp(response);
        }).fail(error => {
            console.log(error);
        }))
    });

    const fetchRecoExp = () => {
        var monthData = {"date": ($("#month").val())}
        $.when(postActions("fetchReco", monthData).done(response => {
            renderRecoExp(response);
        }).fail(error => {
            console.log(error);
        }))
    }
    fetchRecoExp();
    const renderRecoExp = expensesData => {
        $(".recommend-tbody").html("");
        expensesData.forEach(expense => {
            return $(".recommend-tbody").append(`
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <h4 class="m-b-0 font-14">
                                            ${expense.desc}
                                            ${(expense.status === "recommend")&&(expense.reason !== "not cancelled")? 
                                                '<br><strong class="text-muted" style="font-size: 12px;">Treasurer Reason:</strong><br><I class="text-muted" style="font-size: 12px;">'+expense.reason+'<I/>': ' '}
                                        </h4>
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-14">${numberWithCommas(expense.budget)}</span></td>
                            <td><span class="font-14">${expense.name}</span></td>
                            <td><span class="font-14">${expense.created_at}</span></td>
                            <td><span class="label label-rounded label-warning">${expense.status}</span></td>
                            <td>
                                <span class="action-icons">
                                    <a href="#" class="approve-icon" id-data="${expense.id}"><i class="ti-check color-success"></i></a> | 
                                    <a style="color: #e86060;" href="#" class="decline-admin" id-data="${expense.id}"><i class="mdi mdi-block-helper"></i></a>
                                </span>
                            </td>
                        </tr>
                    `)
        });
    }
    $(".recoExp").change(function() {
        $.when(postActions("fetchReco", {"date": ($(this).val())}).done(response => {
            renderRecoExp(response);
        }).fail(error => {
            console.log(error);
        }))
    });

    const fetchAllExpenses = () => {
        var monthData = {"date": ($("#month").val())}
        $.when(postActions("fetch/expenses", monthData).done(response => {
            renderAllExpenses(response.expenses);
            $(".year-total").html(`${numberWithCommas(response.totalYear)} UGX`);
            $(".month-total").html(`${numberWithCommas(response.totalMonth)} UGX`);
        }).fail(error => {
            console.log(error);
        }))
    }
    fetchAllExpenses();
    const renderAllExpenses = expensesData => {
        $(".all-tbody").html("");
        expensesData.forEach(expense => {
            return $(".all-tbody").append(`
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <h4 class="m-b-0 font-14">${expense.desc}</h4>
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-14">${numberWithCommas(expense.budget)}</span></td>
                            <td><span class="font-14">${expense.name}</span></td>
                            <td><span class="font-14">${expense.created_at}</span></td>
                            <td><span class="label label-rounded label-success">${expense.status}</span></td>
                        </tr>
                    `)
        });
    }
    $(".allExp").change(function() {
        $.when(postActions("fetch/expenses", {"date": ($(this).val())}).done(response => {
            renderAllExpenses(response.expenses);
            $(".year-total").html(`${numberWithCommas(response.totalYear)}`);
            $(".month-total").html(`${numberWithCommas(response.totalMonth)}`);
        }).fail(error => {
            console.log(error);
        }))
    })
    // setTimeout(() => {
    //     fetchPendingExp();
    //     fetchExpenses();
    //     fetchRecoExp();
    //     fetchAllExpenses();
    // }, 6000);
});