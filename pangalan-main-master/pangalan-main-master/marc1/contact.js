// contact.js - simple validation before submitting to submit_contact.php
function validateForm() {
  const nameEl = document.getElementById("name");
  const emailEl = document.getElementById("email");
  const messageEl = document.getElementById("message");

  const name = nameEl ? nameEl.value.trim() : '';
  const email = emailEl ? emailEl.value.trim() : '';
  const message = messageEl ? messageEl.value.trim() : '';

  if (!name || !email || !message) {
    alert("Please fill out all fields before submitting.");
    return false;
  }

  // Basic email pattern (keeps your original simple pattern but slightly improved)
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
  if (!emailPattern.test(email)) {
    alert("rickmarcarnado@gmail.com");
    emailEl.focus();
    return false;
  }

  // Allow form submit so backend (submit_contact.php) can store the message in DB
  return true;
}
