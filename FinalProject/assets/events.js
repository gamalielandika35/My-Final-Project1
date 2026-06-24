$(document).ready(function(){
 
  $('.head').click(function(e){
   
    if($(e.target).hasClass('delete-btn')) return;

    const item = $(this).closest('.item');
    const panel = item.find('.panel');
    const chev = item.find('.chev');
    $('.panel').not(panel).slideUp();
    $('.chev').not(chev).css('transform','rotate(0deg)');
    panel.slideToggle();
    const isOpen = panel.is(':visible');
    chev.css('transform', isOpen ? 'rotate(180deg)' : 'rotate(0deg)');
  });

// ini delet button 
$(document).on("click", ".delete-btn", function(e){
  e.stopPropagation(); 
  e.preventDefault(); 
  let id = $(this).data("id");
  let btn = $(this); 
// keluar konfirmas deletnya
  if(confirm("Yakin ini ? ingin menghapus event ini?")){
    $.post("event_delete_process.php", { id: id }, function(response){
      let xmlDoc = new DOMParser().parseFromString(response, "application/xml");
      let statusNode = xmlDoc.getElementsByTagName("status")[0];
      let messageNode = xmlDoc.getElementsByTagName("message")[0];
      let status = statusNode ? statusNode.textContent : "error";
      let message = messageNode ? messageNode.textContent : "Response tidak valid";
//notif alert biasa
      alert(message);
      if(status === "success"){
       
        btn.closest(".item").fadeOut(400, function(){
          $(this).remove();
        });
      }
    });
  }
});



});
