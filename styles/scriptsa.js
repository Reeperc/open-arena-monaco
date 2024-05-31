// scripts.js
$(document).ready(function () {
    $('#emailForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'sendMail-form-sent2.php',
            data: $(this).serialize(),
            success: function (response) {
                $('#result').html(response.message);
                if (response.status === 'success') {
                    animateSuccess();
                } else {
                    animateFailure();
                }
            },
            error: function () {
                $('#result').html('An error occurred.');
                animateFailure();
            }
        });
    });

    function animateSuccess() {
        gsap.fromTo("#result", {scale: 0, opacity: 0}, {scale: 1, opacity: 1, duration: 1, ease: "elastic.out(1, 0.3)"});
        gsap.fromTo("#result", {color: "green"}, {color: "green", duration: 1});
    }

    function animateFailure() {
        gsap.fromTo("#result", {scale: 0, opacity: 0}, {scale: 1, opacity: 1, duration: 1, ease: "elastic.out(1, 0.3)"});
        gsap.fromTo("#result", {color: "red"}, {color: "red", duration: 1});
    }
});
