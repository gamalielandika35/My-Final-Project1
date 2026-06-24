document.addEventListener("DOMContentLoaded", function(){
  const form = document.getElementById("eventEditForm");
  const msgBox = document.getElementById("msg");

  form.addEventListener("submit", function(e){
    e.preventDefault();
    let formData = new FormData(form); // ngambil file juga 

    fetch("event_edit_process.php", { method: "POST", body: formData })
    .then(res => res.text())
    .then(str => {
      let xmlDoc = new DOMParser().parseFromString(str, "application/xml");
      let status = xmlDoc.getElementsByTagName("status")[0].textContent;
      let message = xmlDoc.getElementsByTagName("message")[0].textContent;
      msgBox.innerText = message;
      if(status === "success"){ window.location.href = "events.php"; }
    })
    .catch(err => msgBox.innerText = "Error: " + err);
  });
});
