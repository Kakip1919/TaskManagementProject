document.getElementById("delete_task").addEventListener("click", () => {
    const result = window.confirm("このタスクを削除しますか？")
    if(result){document.delete_form.submit();}
})
