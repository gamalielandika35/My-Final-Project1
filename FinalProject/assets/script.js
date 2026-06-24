document.addEventListener("DOMContentLoaded", function(){
 
  const loginForm = document.getElementById("loginForm");
  loginForm.addEventListener("submit", function(e){
    e.preventDefault();
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "alogin.php", true);
    xhr.onload = function(){
      if(xhr.status === 200){
        const xmlDoc = new DOMParser().parseFromString(xhr.responseText, "application/xml");
        const status = xmlDoc.getElementsByTagName("status")[0]?.textContent;
        const message = xmlDoc.getElementsByTagName("message")[0]?.textContent;
        document.getElementById("msg").textContent = message;
        if(status === "success"){
          window.location.href = "home.php";
        }
      }
    };
    xhr.send(new FormData(loginForm));
  });


  const guestForm = document.getElementById("guestForm");
  guestForm.addEventListener("submit", function(e){
    e.preventDefault();
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "alogin.php", true);
    xhr.onload = function(){
      if(xhr.status === 200){
        const xmlDoc = new DOMParser().parseFromString(xhr.responseText, "application/xml");
        const status = xmlDoc.getElementsByTagName("status")[0]?.textContent;
        const message = xmlDoc.getElementsByTagName("message")[0]?.textContent;
        document.getElementById("msg").textContent = message;
        if(status === "success"){
          window.location.href = "home.php";
        }
      }
    };
    const formData = new FormData();
    formData.append("guest", "1");
    xhr.send(formData);
  });
});