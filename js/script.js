console.log("Hello, Script.js is running!");

// Toggle the dropdown content when clicking on the profile picture
  // document.querySelector(".profile-pic").addEventListener(DOMContentLoaded, function() {
  //   document.querySelector(".dropdown-content").classList.toggle("show");
  // });
  
  // Hide the dropdown content when clicking outside of it
  window.addEventListener("click", function(event) {
    if (!event.target.matches(".profile-pic")) {
      var dropdowns = document.querySelectorAll(".dropdown-content");
      for (var i = 0; i < dropdowns.length; i++) {
        var dropdown = dropdowns[i];
        if (dropdown.classList.contains("show")) {
          dropdown.classList.remove("show");
        }
      }
    }
  });

  
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

  try{
    var myModal = new bootstrap.Modal(document.getElementById('addToCartWindow'), {})
    myModal.toggle()
  }
  catch(e){
  }
  

function submitCategory() {
  document.getElementById("category").submit();
}
  

