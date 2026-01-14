import './bootstrap';
import Swal from "sweetalert2";
window.Swal = Swal;
import "bootstrap-icons/font/bootstrap-icons.css";

// import $ from 'jquery';
// window.jQuery = $;
// window.$ = $;
// // case 1
// $(document).ready(function() {
//   console.log("test");
// });


// // Disable right-click
document.addEventListener('contextmenu', (e) => e.preventDefault());

function ctrlShiftKey(e, keyCode) {
  return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
}

document.onkeydown = (e) => {
  // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
  if (
    event.keyCode === 123 ||
    ctrlShiftKey(e, 'I') ||
    ctrlShiftKey(e, 'J') ||
    ctrlShiftKey(e, 'C') ||
    (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
  )
    return false;
};