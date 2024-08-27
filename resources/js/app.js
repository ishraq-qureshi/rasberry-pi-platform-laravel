import './bootstrap';


jQuery(function(){
  setTimeout(() => {
    jQuery('div[role=alert]').remove()
  }, 5000);
})