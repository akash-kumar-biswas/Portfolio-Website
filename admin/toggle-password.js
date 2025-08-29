function togglePassword() {
    const pwd = document.getElementById("password");
    if (pwd.type === "password") {
        pwd.type = "text";
    } 
    else {
        pwd.type = "password";
    }
}
