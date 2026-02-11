// BUDGET MODAL JS

const budget_modal = document.getElementById("budget_modal");
const budget_category = document.getElementById("budget_category");
const budget_amount = document.getElementById("budget_amount");
const budget_monthly = document.getElementById("budget_monthly");
const budget_weekly = document.getElementById("budget_weekly");
const budget_today = document.getElementById("budget_today");
const budget_start_date = document.getElementById("budget_start_date");
const budget_end_date = document.getElementById("budget_end_date");

// OPEN MODAL
function openModal() {
    budget_modal.style.display = "flex";
    budget_category.value = "";
    budget_amount.value = "";
    budget_monthly.value = "";
    budget_weekly.value = "";
    budget_today.value = "";
    budget_start_date.value = "";
    budget_end_date.value = "";
    budget_category.focus();
}

// CLOSE MODAL
function closeModal() {
    budget_modal.style.display = "none";
}

// HIDE MODAL ON PAGE LOAD
document.addEventListener("DOMContentLoaded", function () {
    closeModal();
});

/* EDIT MODAL */
function editBudget(id, category, amount, period, start, end) {
    document.getElementById("budget_id").value = id;
    document.getElementById("budget_category").value = category;
    document.getElementById("budget_amount").value = amount;

    document.querySelector(
        `input[name="budget_period"][value="${period}"]`
    ).checked = true;

    document.getElementById("budget_start_date").value = start;
    document.getElementById("budget_end_date").value = end;

    budget_modal.style.display = "flex";
}