console.log("Hello, Script-2.js is running!");
// Get all the plus and minus buttons
const plusBtns = document.querySelectorAll('.plus-btn');
const minusBtns = document.querySelectorAll('.minus-btn');
const qtyInput = document.querySelectorAll('.qty');

//Limit Character
function handleInput(event) {
  if (event.target.value.length > event.target.maxLength) {
    event.target.value = event.target.value.slice(0, event.target.maxLength);
  }
}

// Submit on input and click
document.querySelectorAll('.qty-form').forEach(function(form) {
  var input = form.querySelector('.qty');
  var minusBtn = form.querySelector('.minus-btn');
  var plusBtn = form.querySelector('.plus-btn');
  
  input.addEventListener('change', function() {
      form.submit();
  });
  
  minusBtn.addEventListener('click', function() {
      input.stepDown();
      form.submit();
  });
  
  plusBtn.addEventListener('click', function() {
      input.stepUp();
      form.submit();
  });
});

// Submit Delivery Form
function submitDeliveryForm() {
  document.getElementById("delivery-form").submit();
}

function updateOrderStatus() {
  document.getElementById("orderStatus").submit();
}

function updateProdStatus(){
  document.getElementById("prodStatus").submit();
}

$(document).ready(function(){
  $("#myModalBtn").click(function(){
      $("#myModal").modal();
  });
});

function submit(){
  let forms = document.getElementsByClassName("order-form");
  for(var i =0; i < forms.length; i++){
    forms[i].submit();
  }
}

const progressBars = document.querySelectorAll('.progress');

progressBars.forEach(progressBar => {
  const progressStat = progressBar.dataset.progressStat;

  if (progressStat == 'processing') {
    progressBar.classList.add('processing');
  } else if (progressStat == 'shipped') {
    progressBar.classList.add('shipped');
  } else if (progressStat == 'completed') {
    progressBar.classList.add('completed');
  } else if (progressStat == 'cancelled') {
    progressBar.classList.add('cancelled');
  }
});


document.getElementById("clearPackageBtn").addEventListener("click", function() {
  // Clear the package cookie by setting its expiration to a past date
  document.cookie = "package=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

  // Optionally, you can reload the page to see the changes (if needed)
  location.reload();
});

function submitSortForm(selectOption) {
  const selectedValue = selectOption.value;
  const previousPageURL = document.referrer;
  let url = "menu.php";
  let parameter;
  const urlSearchParams = new URLSearchParams(window.location.search);
  const category = urlSearchParams.get('category');

  if(category == "" || category == "null" || category == null){
    console.log("Null category")
    if (selectedValue == 0) {
      parameter = "";
    } else {
      parameter = "?sort=" + selectedValue;
    }
  }
  else{
    console.log("Category")
    if (selectedValue == 0) {
      parameter = "?category=" + category;
    } else {
      parameter = "?category=" + category + "&sort=" + selectedValue;
    }
  }
  
  fetch(url)
    .then(response => {
      // Handle the response if needed (optional)
      console.log("Form data submitted successfully.");
      window.location.href = url + parameter;
    })
    .catch(error => {
      // Handle errors if any (optional)
      console.error("An error occurred while submitting the form:", error);
    });
}

document.addEventListener('DOMContentLoaded', function () {
  // Get references to the relevant DOM elements
  const riceCheck = document.getElementById('rice');
  const paxInput = document.getElementById('pax');
  const ricePriceSpan = document.getElementById('ricePrice');
  const subtotalSpan = document.getElementById('subtotal');
  const phpSubtotalInput = document.getElementById('phpSubtotal');
  const pkgButton = document.querySelector('.pkg-btn'); 

  // Calculate the subtotal based on the rice checkbox and PAX input
  function calculateSubtotal() {
      storeInputs();
      const ricePrice = riceCheck.checked ? 10 : 0;
      const pax = parseInt(paxInput.value) || 0;
      const rice_subtotal = ricePrice * pax;
      const subtotal = rice_subtotal + (parseFloat(phpSubtotalInput.value) * pax);

      ricePriceSpan.textContent = rice_subtotal.toFixed(2);
      subtotalSpan.textContent = subtotal.toLocaleString("en-US", { style: "currency", currency: "PHP", minimumFractionDigits: 2 });
  }

  // Attach event listeners to the relevant elements using 'input' and 'change' events
  riceCheck.addEventListener('change', calculateSubtotal);
  paxInput.addEventListener('input', calculateSubtotal);
  pkgButton.addEventListener('click', calculateSubtotal);

  // Initial calculation on page load
  calculateSubtotal();
});

function submitRfForm() {
  document.getElementById("pkgForm").submit();
}

document.addEventListener('DOMContentLoaded', function () {
  // Get the current URL
  const currentURL = window.location.href;

  // Check if the URL contains "menu.php?removed=success"
  if (currentURL.includes("menu.php?show=modal")) {
    // Find the button element
    const button = document.getElementById("pkgbButton");

    // Trigger the button click event
    button.click();
  }
});

function addToCart(){
  document.getElementById("addToCartForm").submit();
}

function removeFromCart(){
  document.getElementById("rf_Cart").submit();
}

function editPackage(){
  document.getElementById("editForm").submit();
}

function submitOrder(){
  document.getElementById("orderForm").submit();
}

function submitEditOrder(id){
  document.getElementById("editOrderForm-" + id).submit();
}

function submitEditProduct(id){
  document.getElementById("editProdForm-" + id).submit();
}

$(function(){
  $('#datepicker').datepicker();
});