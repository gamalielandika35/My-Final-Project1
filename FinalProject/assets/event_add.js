document.addEventListener("DOMContentLoaded", function(){
  const form = document.getElementById("eventAddForm");
  const msgBox = document.getElementById("msg");

  form.addEventListener("submit", function(e){
    e.preventDefault();
    let formData = new FormData(form);

    fetch("event_add_process.php", { method: "POST", body: formData })
    .then(res => res.text())
    .then(str => {
      console.log("Raw response:", str); // debug di console karna kemaren kebanyakan error jadi butuh 

      let xmlDoc = new DOMParser().parseFromString(str, "application/xml");
      let statusNode = xmlDoc.getElementsByTagName("status")[0];
      let messageNode = xmlDoc.getElementsByTagName("message")[0];

      let status = statusNode ? statusNode.textContent : "error";
      let message = messageNode ? messageNode.textContent : "Response tidak valid";

      msgBox.innerText = message;

      if(status === "success"){
  msgBox.innerText = message;
  setTimeout(() => {
    window.location.href = "events.php";
  }, 1500); 
}

    })
    .catch(err => {
      msgBox.innerText = "Error: " + err;
    });
  });
});
