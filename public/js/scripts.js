(function($) {
    "use strict";

    var path = window.location.href;
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    $("body").on("click", "#sidebarToggle", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });
    $(document).on("show.bs.modal", ".modal", function() {
        var zIndex = 1040 + 10 * $(".modal:visible").length;
        $(this).css("z-index", zIndex);
        setTimeout(function() {
            $(".modal-backdrop")
                .not(".modal-stack")
                .css("z-index", zIndex - 1)
                .addClass("modal-stack");
        }, 0);
    });
    $(document).on("hidden.bs.modal", "#imgModal", function(e) {
        $("#exampleModal").modal("show");
    });
})(jQuery);
