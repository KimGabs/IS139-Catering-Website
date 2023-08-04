console.log("Hello, Script.js is running!");
  
  // Preview image before upload
  const imageInput = document.getElementById('image');
  const imagePreview = document.getElementById('preview');
  
  if(imageInput !== null){

    imageInput.onchange = evt => {
      const [file] = imageInput.files
      if (file) {
        imagePreview.src = URL.createObjectURL(file)
      }
    };
  }

  const imageInputs = document.querySelectorAll('[data-prod-id]');

  imageInputs.forEach(imageInput => {
    const prodId = imageInput.dataset.prodId;
    const imagePreview = document.querySelector('.preview-' + prodId);
    const cancelButton = document.querySelector('.cancel-btn-' + prodId);
    cancelButton.textContent = 'Cancel';
  
    // Store the original image URL and texts
    const originalImageSrc = imagePreview.src;
  
    if (imageInput !== null) {
      imageInput.onchange = evt => {
        const [file] = imageInput.files;
        if (file) {
          imagePreview.src = URL.createObjectURL(file);
        }
      };
    }

    // Add a click event listener to the cancel button for each set
  cancelButton.addEventListener('click', () => {
    // Revert back to the original image URL
    imagePreview.src = originalImageSrc;
    // Clear the selected file from the input field
    imageInput.value = '';
  });
});

  try{
    var myModal = new bootstrap.Modal(document.getElementById('pkgwindow'), {});
    myModal.toggle();
  }
  catch(e){
  }
 
  try{
    var myModal = new bootstrap.Modal(document.getElementById('addToCartWindow'), {});
    myModal.toggle();
  }
  catch(e){
  }

  try{
    var myModal = new bootstrap.Modal(document.getElementById('inquiryWindow'), {});
    myModal.toggle();
  }
  catch(e){
  }

function closeInquiryModal() {
    const inquiryModal = document.getElementById('inquiryWindow');
    if (inquiryModal) {
        $(inquiryModal).modal('hide'); // Use jQuery's hide() method to close the modal
    }
}

// Close the modal automatically after 5 seconds (5000 milliseconds)
setTimeout(closeInquiryModal, 1500);
  

// function submitCategory() {
//   document.getElementById("category").submit();
// }
  

// Store the form input values in localStorage
const myCheckbox = document.getElementById('rice');
const savedState = localStorage.getItem('checkboxState');

if (savedState === 'checked') {
  myCheckbox.checked = true;
} else {
  myCheckbox.checked = false;
}

myCheckbox.addEventListener('change', function () {
  if (this.checked) {
    // If the checkbox is checked, save the state as 'checked' in localStorage
    localStorage.setItem('checkboxState', 'checked');
  } else {
    // If the checkbox is unchecked, save the state as 'unchecked' in localStorage
    localStorage.setItem('checkboxState', 'unchecked');
  }
});


function storeInputs() {
  // Store the form input values in localStorage
  const paxValue = document.getElementById('pax').value;
  if(paxValue > 0){
    localStorage.setItem('pax', paxValue);
  }
}
function retrieveInputs() {
  const paxValue = localStorage.getItem('pax');
  document.getElementById('pax').value = paxValue || ''; // Set the input value, or empty string if null
}

retrieveInputs();
