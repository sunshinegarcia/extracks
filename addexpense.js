// EXPENSE MODAL JS

const expenseModal = document.getElementById("expenseModal");
const expenseName = document.getElementById("expenseName");
const expenseAmount = document.getElementById("expenseAmount");
const expenseDate = document.getElementById("expenseDate");
const expenseCategory = document.getElementById("expenseCategory");

// OPEN MODAL
function openExpenseModal() {
    expenseModal.style.display = "flex";
    expenseName.value = "";
    expenseAmount.value = "";
    expenseDate.value = "";
    expenseCategory.value = "";
    expenseName.focus();
}

// CLOSE MODAL
function closeExpenseModal() {
    expenseModal.style.display = "none";
}

// HIDE MODAL ON PAGE LOAD
document.addEventListener("DOMContentLoaded", function () {
    closeExpenseModal();
});

// SAVE EXPENSE FUNCTION
function saveExpense() {

    if (!expenseName.value.trim() || 
        !expenseAmount.value.trim() || 
        !expenseDate.value || 
        !expenseCategory.value) {

        alert("All fields are required.");
        return;
    }

    const formData = new FormData();
    formData.append("expense_name", expenseName.value.trim());
    formData.append("expense_amount", expenseAmount.value.trim());
    formData.append("expense_date", expenseDate.value);
    formData.append("category_id", expenseCategory.value);

    fetch("add_expense.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "error") {
            alert(data.message);
            return;
        }

        alert("Expense added successfully!");
        closeExpenseModal();
        window.location.href = "expenses.php";
    })
    .catch(err => {
        console.error(err);
        alert("Something went wrong. Please try again.");
    });
}