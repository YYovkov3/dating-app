function checkAge() {
    var ageInput = document.getElementById("age");
    var age = parseInt(ageInput.value);

    if (age > 18) {
        // Продължавате с регистрационния процес
    } else {
        alert("Трябва да сте на възраст над 18 години, за да се регистрирате.");
    }
}