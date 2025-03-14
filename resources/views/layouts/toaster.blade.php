{{-- Alert 
<!-- Toastr CSS -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
--}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        Livewire.on("toast", (data) => {
            console.log("Received toast event:", data); // Debugging log

            // Extract type and message correctly
            let [type, message] = data;

            setTimeout(() => {
                if (typeof toastr !== "undefined" && typeof toastr[type] === "function") {
                    toastr[type](message); // Example: toastr.success("Post Created!")
                } else {
                    console.error("Toastr function not found for type:", type);
                }
            }, 300);
        });
    });

    toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000",
            };
</script>