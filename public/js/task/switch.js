const deadline_checkbox = document.getElementById("deadline");
const complete_checkbox = document.getElementById("complete")

deadline_checkbox.addEventListener("change", () => {
    console.log(deadline_checkbox.checked)
    if (deadline_checkbox.checked) {
        window.location.href = "http://127.0.0.1:8000/?kind=deadline"
    } else {
        window.location.href = "http://127.0.0.1:8000"
    }
})

complete_checkbox.addEventListener("change", () => {

    if (complete_checkbox.checked) {
        window.location.href = "http://127.0.0.1:8000/?kind=complete"
    } else {
        window.location.href = "http://127.0.0.1:8000"
    }
})
