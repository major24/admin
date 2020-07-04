function ajaxPost(url, data, cb) {
  var reqOptions = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    json: true,
  };
  reqOptions.url = url;
  reqOptions.data = JSON.stringify(data);
  // console.log(reqOptions);

  axios
    .request(reqOptions)
    .then(function (response) {
      console.log(response);
      console.log(response.status);
      cb(response);
    })
    .catch(function (error) {
      console.log(">>>Error:main.js:ajaxPost", error.response.message);
      showToast(error.response.status);
      // var url = "/admin/residents/funds/dal/insertLog.php";
      // var dataError = {
      //   userId: data.userId,
      //   logType: 'Error:Data',
      //   description: JSON.stringify(data)
      // }
      // var dataErrorMsg = {
      //   userId: data.userId,
      //   logType: 'Error',
      //   description: JSON.stringify(error.response)
      // }
      // ajaxPost(url, dataError);
      // ajaxPost(url, dataErrorMsg);
    });
}

// ===================================================================
// log in
function validateLogin() {
  var data = {
    password: document.getElementById("password").value,
    userName: document.getElementById("userName").value,
  };
  if (data.password === "" || data.userName === "") {
    showToast(999);
    return;
  }
  var url = "/admin/residents/funds/dal/authentication/authenticate.php";
  ajaxPost(url, data, validateLoginHandleResponse);
}
function validateLoginHandleResponse(response) {
  if (response.status === 200) {
    var url = "showAllResidents.php";
    window.location = url;
  } else {
    console.log(">>>>>error: ", response.status);
  }
}
// end of login

//=====================================================================
// change pwd
function changePassword() {
  var data = {
    userName: document.getElementById("resetUserName").value.trim(),
    currentPassword: document.getElementById("currentPassword").value.trim(),
    newPassword: document.getElementById("newPassword").value.trim(),
    confirmPassword: document.getElementById("confirmPassword").value.trim(),
  };

  if (
    data.resetUserName === "" ||
    data.currentPassword === "" ||
    data.newPassword === "" ||
    data.confirmPassword === ""
  ) {
    showToast(999);
    return;
  }
  if (data.newPassword != data.confirmPassword) {
    showToast(800);
    return;
  }
  var url = "/admin/residents/funds/dal/authentication/changePassword.php";
  ajaxPost(url, data, changePasswordHandleResponse);
}
function changePasswordHandleResponse(response) {
  if ((response.status === 200) | (response.status === 201)) {
    showToast(response.status);
  } else {
    console.log(">>>>>error: ", response.status);
  }
}
// end of change pwd

//=====================================================================
// navigation
function navigateToCredit(id) {
  var url = `credit.php?id=${id}`;
  window.location = url;
}
function navigateToExpense(id) {
  var url = `expense.php?id=${id}`;
  window.location = url;
}
function navigateToTransactions(id) {
  var url = `transactions.php?id=${id}&limit=30`;
  window.location = url;
}

//=====================================================================
// income post
function postCredit() {
  var data = {
    residentId: document.getElementById("residentId").value,
    userId: document.getElementById("userId").value,
    crDr: "Credit",
    transactionType: document.getElementById("transactionType").value,
    chqOrReceiptNumber: document.getElementById("chqOrReceiptNumber").value,
    sourceType: document.getElementById("sourceType").value,
    amount: CleanNumber(document.getElementById("amount").value),
    transactionDate: document.getElementById("transactionDate").value,
    description: document.getElementById("description").value,
  };
  if (
    data.transactionType === "" ||
    data.description === "" ||
    data.sourceType === "" ||
    data.amount === ""
  ) {
    showToast(999);
    return false;
  }
  // console.log(JSON.stringify(data));
  var url = "/admin/residents/funds/dal/transactions/insertTransaction.php";
  ajaxPost(url, data, postCreditHandleResponse);
}
function postCreditHandleResponse(response) {
  if (response.status === 200 || response.status === 201) {
    clearIncomeFields();
    showToast(response.status);
  }
}
function clearIncomeFields() {
  document.getElementById("transactionType").value = "";
  document.getElementById("sourceType").value = "";
  document.getElementById("chqOrReceiptNumber").value = "";
  document.getElementById("amount").value = "";
  document.getElementById("transactionDate").value = "";
  document.getElementById("description").value = "";
}
// income post end

//=====================================================================
// expense post
function postExpense() {
  var data = {
    residentId: document.getElementById("residentId").value,
    userId: document.getElementById("userId").value,
    crDr: "Debit",
    transactionType: document.getElementById("transactionType").value,
    chqOrReceiptNumber: "",
    sourceType: document.getElementById("sourceType").value,
    amount: CleanNumber(document.getElementById("amount").value),
    transactionDate: document.getElementById("transactionDate").value,
    description: document.getElementById("description").value,
  };
  if (
    data.amount === "" ||
    data.transactionType === "" ||
    data.sourceType === "" ||
    data.transactionDate === "" ||
    data.description === ""
  ) {
    showToast(999);
    return false;
  }
  // console.log(JSON.stringify(data));

  var url = "/admin/residents/funds/dal/transactions/insertTransaction.php";
  ajaxPost(url, data, postExpenseHandleResponse);
}
function postExpenseHandleResponse(response) {
  if (response.status === 200 || response.status === 201) {
    // console.log(">>>=", response.data);
    clearExpenseFields();
    showToast(response.status);
  }
}
function clearExpenseFields() {
  document.getElementById("transactionType").value = "";
  document.getElementById("sourceType").value = "";
  document.getElementById("amount").value = "";
  document.getElementById("transactionDate").value = "";
  document.getElementById("description").value = "";
}
// expense post end

//=====================================================================
// transferfunds
function postTransferFunds() {
  var data = {
    userId: document.getElementById("userId").value,
    sourceType: document.getElementById("sourceType").value,
    amount: CleanNumber(document.getElementById("amount").value),
    description: document.getElementById("description").value,
    transactionDate: "",
  };
  if (data.amount === "" || data.sourceType === "") {
    showToast(999);
    return false;
  }
  console.log(JSON.stringify(data));

  var url = "/admin/residents/funds/dal/transactions/transferFunds.php";
  ajaxPost(url, data, postTransferFundsHandleResponse);
}
function postTransferFundsHandleResponse(response) {
  if (response.status === 200 || response.status === 201) {
    // console.log(">>>=", response.data);
    clearTransferFundsFields();
    showToast(response.status);
  }
}
function clearTransferFundsFields() {
  document.getElementById("sourceType").value = "";
  document.getElementById("amount").value = "";
  document.getElementById("description").value = "";
}
// endof post transferfunds

//=====================================================================
// add new resident post
function postResident() {
  var data = {
    referenceNumber: document.getElementById("referenceNumber").value,
    firstName: document.getElementById("firstName").value,
    surname: document.getElementById("surname").value,
    middleName: document.getElementById("middleName").value,
  };
  // console.log(data);
  if (data.referenceNumber === "" || data.firstName === "" || surname === "") {
    showToast(999);
    return;
  }
  // console.log(JSON.stringify(data));

  var url = "/admin/residents/funds/dal/residents/insertResident.php";
  ajaxPost(url, data, postResidentHandleResponse);
}
function postResidentHandleResponse(response) {
  if (response.status === 201) {
    // console.log(">>>=", response.data);
    showToast(response.status);
    clearAddResidentFields();
  } else if (response.status === 400) {
    showToast(response.status);
  }
}
function clearAddResidentFields() {
  document.getElementById("referenceNumber").value = "";
  document.getElementById("firstName").value = "";
  document.getElementById("surname").value = "";
  document.getElementById("middleName").value = "";
}
// add new resident post end

//=====================================================================
// add user
function postUser() {
  var data = {
    userName: document.getElementById("userName").value,
    firstName: document.getElementById("firstName").value,
    surName: document.getElementById("surName").value,
    password: document.getElementById("password").value,
  };
  // console.log(data);
  if (data.userName === "" || data.firstName === "" || password === "") {
    showToast(999);
    return;
  }
  console.log(JSON.stringify(data));

  var url = "/admin/residents/funds/dal/users/insertUser.php";
  ajaxPost(url, data, postUserHandleResponse);
}
function postUserHandleResponse(response) {
  if (response.status === 200 || response.status === 201) {
    showToast(response.status);
    clearAddUserFields();
  }
}
function clearAddUserFields() {
  document.getElementById("userName").value = "";
  document.getElementById("firstName").value = "";
  document.getElementById("surName").value = "";
  document.getElementById("password").value = "";
}

//=====================================================================
// reset pwd by admin
function resetPassword() {
  var data = {
    password: document.getElementById("password").value,
    userName: document.getElementById("userName").value,
  };
  var url = "/admin/residents/funds/dal/authentication/resetPassword.php";
  ajaxPost(url, data, resetPasswordHandleResponse);
}
function resetPasswordHandleResponse(response) {
  if (response.status === 200) {
    showToast(response.status);
  } else {
    console.log(">>>>>error: ", response.status);
  }
}

// validate number only
function isNumber(evt) {
  var iKeyCode = evt.which ? evt.which : evt.keyCode;
  if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
    return false;

  return true;
}

function CleanNumber(number) {
  return number.replace(/[^\d.-]/g, "");
}

function showToast(status) {
  if (status == 200 || status == 201) {
    showToastSuccess();
    return;
  }

  // if error or validation show diff messages
  if (status == 404) {
    $("#toastMessageError").text("Not found: We cannot find the data.");
  } else if (status == 400) {
    $("#toastMessageError").text(
      "Resident or client id already exists in our system."
    );
  } else if (status == 999) {
    $("#toastMessageError").text(
      "Required: Please fill all required field(s)."
    );
  }
  var opts = {
    animation: true,
    autohide: true,
    delay: 7000,
  };
  $("#toastControlError").toast(opts);
  $("#toastControlError").toast("show");
}

function showToastSuccess() {
  var opts = {
    animation: true,
    autohide: true,
    delay: 1000,
  };
  $("#toastControlSuccess").toast(opts);
  $("#toastControlSuccess").toast("show");
}
