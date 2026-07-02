import $ from 'jquery';
import Swal from 'sweetalert2';


$('#loginForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: LOGIN_URL,
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                window.location.href = response.redirect;
            } else {
                Swal.fire({
                    title: 'Login Failed',
                    text: response.message,
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                title: 'Error',
                text: 'Something went wrong.',
                icon: 'error'
            });
        }
    });
});







// document.addEventListener("DOMContentLoaded", function() {
//     document.getElementById("logoutBtn").addEventListener("click", function(e) {
//         e.preventDefault();

//         Swal.fire({
//         title: "Are you sure?",
//         text: "You will be logged out of the system.",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         confirmButtonText: "Yes, logout!"
//         }).then((result) => {
//         if (result.isConfirmed) {
//             fetch("{{ route('logout') }}", {
//             method: "POST",
//             headers: {
//                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
//             }
//             })
//             .then(res => {
//             if (res.ok) {
//                 Swal.fire({
//                 title: "Logged Out!",
//                 text: "You have been successfully logged out.",
//                 icon: "success",
//                 timer: 1500,
//                 showConfirmButton: false
//                 }).then(() => {
//                 window.location.href = "{{ route('login') }}";
//                 });
//             } else {
//                 Swal.fire("Error", "Logout failed. Try again.", "error");
//             }
//             })
//             .catch(() => Swal.fire("Error", "Something went wrong!", "error"));
//         }
//         });
//     });
// });
