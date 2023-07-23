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