$(document).ready(function () {
    // NAV
    $("#nav-toggler").click(function () {
        let nav = $("nav");
        const body = document.querySelector("body");

        if (nav.css("left") === "0px") {
            // Jika menu terbuka
            nav.animate({ left: "-100%" }, 500);
            body.style.overflow = "auto";
            $("#nav-toggler")
                .html(
                    `<span class="bi bi-list text-white p-0" style="font-size: 30px"></span>`
                )
                .css("transition", "transform 0.3s ease");
        } else {
            // Jika menu tertutup
            nav.animate({ left: "0" }, 300);
            $("#nav-toggler")
                .html(
                    `<span class="bi bi-x text-white p-0" style="font-size: 30px"></span>`
                )
                .css("transition", "transform 0.3s ease");
            body.style.overflow = "hidden";
        }
    });

    function showLoading() {
        document.getElementById("loading").style.display = "flex";
    }

    function hideLoading() {
        document.getElementById("loading").style.display = "none";
    }

    $(document)
        .ajaxStart(function () {
            $("#loading").show();
        })
        .ajaxStop(function () {
            $("#loading").hide();
        });

    $(".product-card").on("mouseenter", function () {
        $(this).removeClass("border-0");
        $(this).addClass("border-2");
    });
    $(".product-card").on("mouseleave", function () {
        $(this).removeClass("border-2");
        $(this).addClass("border-0");
    });
    // CART
    // $("#cart-screen-toggler").click(function () {
    //     let nav_screen = $("#cart-screen");
    //     if (nav_screen.css("right") === "0px") {
    //         nav_screen.animate({ right: "-350px" }, 500);
    //     } else {
    //         nav_screen.animate({ right: "0" }, 500);
    //     }
    // });
});
