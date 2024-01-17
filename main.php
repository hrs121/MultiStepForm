<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Multiple Step Form</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

    <form id="multipleStepForm" action="validate.php" method="post">
        <div class="form-step active" id="step1">
          <h2>Step 1</h2>
          <label for="firstName">First Name:</label>
          <input type="text" id="firstName" name="firstName" required pattern="[A-Za-z ]+">
          <label for="lastName">Last Name:</label>
          <input type="text" id="lastName" name="lastName" required pattern="[A-Za-z ]+">
          <label for="age">Age:</label>
          <input type="number" id="age" name="age" required>
          <label for="gender">Gender:</label>
          <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
          <label for="country">Country:</label>
          <input type="text" id="country" name="country" required pattern="[A-Za-z ]+">
          <div id="step1Error" class="error"></div>
          <button type="button" onclick="validateNextStep('step1', 'step2')">Next</button>
        </div>
      
        <div class="form-step" id="step2">
            <h2>Step 2</h2>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required pattern="[0-9]+">
            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required pattern="[A-Za-z ]+">
            <label for="zipcode">Zip Code:</label>
            <input type="text" id="zipcode" name="zipcode" required pattern="[0-9]+">
            <div id="step2Error" class="error"></div>
            <button type="button" onclick="validateNextStep('step2', 'step3')">Next</button>
            <button type="button" onclick="prevStep('step2', 'step1')">Previous</button>
          </div>
        
          <div class="form-step" id="step3">
            <h2>Step 3</h2>
            <label for="institution">Institution:</label>
            <input type="text" id="institution" name="institution" required pattern="[A-Za-z ]+">
            <label for="degree">Degree:</label>
            <input type="text" id="degree" name="degree" required pattern="[A-Za-z ]+">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
            <label for="subscribe">Subscribe to Newsletter:</label>
            <input type="checkbox" id="subscribe" name="subscribe">

            <div id="step3Error" class="error"></div>
            <button type="button" onclick="prevStep('step3', 'step2')">Previous</button>
            <button type="submit">Submit</button>
          </div>
        </form>
        
        <script>
          function validateNextStep(currentStepId, nextStepId) {
            var errorElement = document.getElementById(currentStepId + 'Error');
            var inputs = document.querySelectorAll('#' + currentStepId + ' input, #' + currentStepId + ' select, #' + currentStepId + ' textarea');
        
            for (var i = 0; i < inputs.length; i++) {
              if (inputs[i].hasAttribute('required')) {
                if (!inputs[i].value.trim()) {
                  errorElement.innerHTML = 'Please fill in all required fields.';
                  return;
                }
        
                // Additional validation based on input types
                if (inputs[i].type === 'text' && inputs[i].hasAttribute('pattern')) {
                  var pattern = new RegExp(inputs[i].getAttribute('pattern'));
                  if (!pattern.test(inputs[i].value)) {
                    errorElement.innerHTML = 'Invalid format for ' + inputs[i].name + '.';
                    return;
                  }
                }
        
                // Additional validation for email format
                if (inputs[i].type === 'email') {
                  var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                  if (!emailPattern.test(inputs[i].value)) {
                    errorElement.innerHTML = 'Invalid email format.';
                    return;
                  }
                }
        
                // Additional validation for phone format
                if (inputs[i].type === 'tel' && inputs[i].hasAttribute('pattern')) {
                  var phonePattern = new RegExp(inputs[i].getAttribute('pattern'));
                  if (!phonePattern.test(inputs[i].value)) {
                    errorElement.innerHTML = 'Invalid phone number format.';
                    return;
                  }
                }
              }
            }
        
            errorElement.innerHTML = '';
            document.getElementById(currentStepId).classList.remove('active');
            document.getElementById(nextStepId).classList.add('active');
          }
        
          function prevStep(currentStepId, prevStepId) {
            document.getElementById(currentStepId).classList.remove('active');
            document.getElementById(prevStepId).classList.add('active');
          }
        </script>
</body>
</html>
