function alertSuccessTopEnd(message, timer = 3000) {
    Swal.fire({
        text: message,
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        background: '#d4edda',
    });
}
function alertErrorTopEnd(message, timer = 3000) {
    Swal.fire({
        text: message,
        icon: 'error',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        background: '#f8d7da',
    });
}
function alertInfoTopEnd(message, timer = 3000) {
    Swal.fire({
        text: message,
        icon: 'info',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        background: '#cce5ff',
    });
}
function alertWarningTopEnd(message, timer = 3000) {
    Swal.fire({
        text: message,
        icon: 'warning',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        background: '#fff3cd',
    });
}