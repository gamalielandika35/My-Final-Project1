document.addEventListener("DOMContentLoaded", function(){
  const form = document.getElementById("registerForm");
  const msgBox = document.getElementById("msg");

  form.addEventListener("submit", function(e){
    e.preventDefault();
    let formData = new FormData(form);

    fetch("register_process.php", { method: "POST", body: formData })
    .then(res => res.text())
    .then(str => {
      let xmlDoc = new DOMParser().parseFromString(str, "application/xml");
      let statusNode = xmlDoc.getElementsByTagName("status")[0];
      let messageNode = xmlDoc.getElementsByTagName("message")[0];
      let status = statusNode ? statusNode.textContent : "error";
      let message = messageNode ? messageNode.textContent : "Response tidak valid";

      msgBox.innerText = message;
      if(status === "success"){ 
       
        setTimeout(()=>{ window.location.href = "index.php"; }, 1500);
      }
    })
    .catch(err => msgBox.innerText = "Error: " + err);
  });
});
