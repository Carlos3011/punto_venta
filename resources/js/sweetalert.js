import Swal from "sweetalert2";


document.addEventListener('DOMContentLoaded', function() {
    window.confirmarEliminacion = function(url) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f97316',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                popup: 'animate__animated animate__zoomIn animate__faster rounded-xl',
                confirmButton: 'bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold py-2 px-6 rounded-lg',
                cancelButton: 'bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold py-2 px-6 rounded-lg'
            },
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Eliminando...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    timer: 1500,
                    backdrop: 'rgba(0,0,0,0.8)',
                    willOpen: () => {
                        Swal.showLoading();
                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({ _method: 'DELETE' })
                        })
                        .then(response => {
                            if (!response.ok) throw response;
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: data.message || 'El elemento fue eliminado correctamente',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1500,
                                customClass: {
                                    popup: 'animate__animated animate__fadeOutUp',
                                    icon: 'animate__animated animate__bounceOut'
                                }
                            }).then(() => {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 500);
                            });
                        })
                        .catch(error => {
                            error.json().then(err => {
                                Swal.fire({
                                    title: 'Error',
                                    text: err.message || 'Ocurrió un error al eliminar el elemento',
                                    icon: 'error',
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        popup: 'animate__animated animate__bounceIn animate__faster rounded-xl',
                                        icon: 'animate__animated animate__heartBeat animate__infinite',
                                        popup: 'animate__animated animate__headShake'
                                    }
                                });
                            });
                        });
                    },
                });
            }
        });
    };

    // Animaciones para la tabla
    const tableRows = document.querySelectorAll('#tabla-usuarios tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease-out';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Efecto de carga al enviar formulario de búsqueda
    const searchForm = document.querySelector('form[action="{{ route(\'admin.users.index\') }}"]');
    searchForm.addEventListener('submit', function() {
        Swal.fire({
            title: 'Buscando...',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
    });
});