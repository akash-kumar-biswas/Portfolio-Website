document.addEventListener("keydown", function (event) {
    if (event.ctrlKey && event.altKey && event.key.toLowerCase() === "k") {
        window.location.href = "http://localhost/Portfolio-Website/admin/login.php";
    }
});