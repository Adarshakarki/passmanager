const lengthSlider = document.querySelector(".pass-length input"),
    options = document.querySelectorAll(".option input"),
    copyIcon = document.querySelector(".input-box span"),
    passwordInput = document.querySelector(".input-box input"),
    passIndicator = document.querySelector(".pass-indicator"),
    generateBtn = document.querySelector(".generate-btn");

const characters = {
    lowercase: "abcdefghijklmnopqrstuvwxyz",
    uppercase: "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
    numbers: "0123456789",
    symbols: "^!$%&|[](){}:;.,*+-#@<>~"
}

const generatePassword = () => {
    let staticPassword = "",
        randomPassword = "",
        excludeDuplicate = false,
        passLength = lengthSlider.value;

    options.forEach(option => {
        if (option.checked) {

            if (option.id !== "exc-duplicate" && option.id !== "spaces") {
                staticPassword += characters[option.id];
            } else if (option.id === "spaces") {
                staticPassword += `  ${staticPassword}  `;
            } else {
                excludeDuplicate = true;
            }
        }
    });

    for (let i = 0; i < passLength; i++) {
        let randomChar = staticPassword[Math.floor(Math.random() * staticPassword.length)];
        if (excludeDuplicate) {
            !randomPassword.includes(randomChar) || randomChar == " " ? randomPassword += randomChar : i--;
        } else {
            randomPassword += randomChar;
        }
    }
    passwordInput.value = randomPassword;
}

const upadatePassIndicator = () => {
    passIndicator.id = lengthSlider.value <= 8 ? "weak" : lengthSlider.value <= 16 ? "medium" : "strong";
}

const updateSlider = () => {
    document.querySelector(".pass-length span").innerText = lengthSlider.value;
    generatePassword();
    upadatePassIndicator();
}
updateSlider();

const copyPassword = () => {
    navigator.clipboard.writeText(passwordInput.value);
    copyIcon.innerText = "check";
    copyIcon.style.color = "#4285F4";
    setTimeout(() => {
        copyIcon.innerText = "copy_all";
        copyIcon.style.color = "#707070";
    }, 1500);
}
copyIcon.addEventListener("click", copyPassword);
lengthSlider.addEventListener("input", updateSlider);
generateBtn.addEventListener("click", generatePassword);

document.addEventListener("DOMContentLoaded", function() {
    const openPopupBtn = document.querySelector(".open-popup-btn");
    const closePopupBtn = document.querySelector(".close-popup-btn");
    const popup = document.getElementById("popup");
    const overlay = document.createElement("div");
    overlay.className = "overlay";

    openPopupBtn.addEventListener("click", function() {
        document.body.appendChild(overlay);
        popup.style.display = "block";
        overlay.style.display = "block";
    });

    closePopupBtn.addEventListener("click", function() {
        document.body.removeChild(overlay);
        popup.style.display = "none";
        overlay.style.display = "none";
    });
});

function addPopupListeners() {
    $(document).on("click", ".open-popup-btn", function() {
        $("#popup, .overlay").show();
    });

    $(document).on("click", ".close-popup-btn", function() {
        $("#popup, .overlay").hide();
    });
}