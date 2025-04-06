$(document).ready(function () {
    $(document).on("submit", "form", function () {
        const $submitButton = $(this).find('button[type="submit"]');

        $submitButton.each(function () {
            $(this).attr("disabled", "disabled");
            const originalText = $(this).html();
            $(this).data("original-text", originalText);
            $(this).html("Submitting...");
        });
    });
});
